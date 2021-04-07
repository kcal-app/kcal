<?php

namespace Database\Support;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

/**
 * @method static Collection adjectives()
 * @method static Collection nouns()
 * @method static Collection prepositions()
 * @method static Collection verbs()
 */
class Words
{

    /**
     * Overload by word type.
     */
    public static function __callStatic($method, $parameters): ?Collection {
        if (in_array($method, ['adjectives', 'nouns', 'prepositions', 'verbs'])) {
            $cache_key = __METHOD__ . "::{$method}";
            if (Cache::has($cache_key)) {
                return Cache::get($cache_key);
            }

            $words = new Collection();
            $storage = Storage::disk('wordlists');
            foreach ($storage->files($method) as $file) {
                $contents = array_filter(explode("\n", $storage->get($file)));
                $words->push(...$contents);
            }

            Cache::put($cache_key, $words, 60 * 5);
            return $words;
        }
        throw new \BadMethodCallException();
    }

    /**
     * Create a random string of words in the provided format.
     *
     * Supported format keys:
     *  - a: adjective,
     *  - n: noun,
     *  - p: preposition, and
     *  - v: verb.
     */
    public static function randomWords(string $format = 'an'): string {
        $name = [];
        foreach (str_split($format) as $type) {
            $name[] = match ($type) {
                'a' => self::adjectives()->random(),
                'n' => self::nouns()->random(),
                'p' => self::prepositions()->random(),
                'v' => self::verbs()->random(),
                default => NULL
            };
        }
        return implode(' ', $name);
    }

}
