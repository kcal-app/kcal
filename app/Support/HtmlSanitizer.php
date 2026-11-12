<?php

namespace App\Support;

use DOMDocument;
use DOMElement;

/**
 * Minimal allow-by-scrubbing HTML sanitizer for stored rich-text (e.g. recipe descriptions edited
 * with Quill). Removes script-bearing and framing elements, strips every event-handler and style
 * attribute, and drops URL attributes whose scheme is not http(s)/mailto/tel/relative. Enough to
 * stop stored XSS while preserving ordinary formatting markup.
 */
class HtmlSanitizer
{
    private const DANGEROUS_TAGS = [
        'script', 'style', 'iframe', 'object', 'embed', 'form', 'link', 'meta',
        'base', 'svg', 'math', 'template', 'noscript', 'frame', 'frameset', 'applet',
    ];

    private const URL_ATTRS = ['href', 'src', 'action', 'formaction', 'background', 'poster', 'xlink:href'];

    public static function clean(?string $html): string
    {
        $html = (string) $html;

        if (trim($html) === '') {
            return '';
        }

        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML(
            '<?xml encoding="UTF-8"?><div id="__sanitize_root__">' . $html . '</div>',
            LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING
        );
        libxml_clear_errors();

        // Remove dangerous elements entirely (including their content).
        foreach (self::DANGEROUS_TAGS as $tag) {
            foreach (iterator_to_array($doc->getElementsByTagName($tag)) as $node) {
                if ($node->parentNode) {
                    $node->parentNode->removeChild($node);
                }
            }
        }

        // Scrub attributes on every remaining element.
        foreach (iterator_to_array($doc->getElementsByTagName('*')) as $el) {
            if (!$el instanceof DOMElement) {
                continue;
            }
            foreach (iterator_to_array($el->attributes) as $attr) {
                $name = strtolower($attr->nodeName);

                if (str_starts_with($name, 'on') || $name === 'style'
                    || str_starts_with($name, 'xmlns') || str_starts_with($name, 'xlink:')) {
                    $el->removeAttribute($attr->nodeName);
                    continue;
                }

                if (in_array($name, self::URL_ATTRS, true) && !self::safeUrl((string) $attr->nodeValue)) {
                    $el->removeAttribute($attr->nodeName);
                }
            }
        }

        $root = $doc->getElementById('__sanitize_root__');
        if (!$root) {
            return '';
        }

        $out = '';
        foreach ($root->childNodes as $child) {
            $out .= $doc->saveHTML($child);
        }

        return $out;
    }

    private static function safeUrl(string $url): bool
    {
        $url = trim($url);

        if ($url === '') {
            return false;
        }

        // Relative URLs, fragments and query-only references are safe.
        if (preg_match('#^(/|\./|\.\./|\#|\?)#', $url)) {
            return true;
        }

        // Strip control chars/whitespace that could smuggle a scheme (e.g. "java\tscript:").
        $probe = preg_replace('/[\x00-\x20]+/', '', $url);

        if (preg_match('#^([a-z][a-z0-9+.\-]*):#i', $probe, $m)) {
            return in_array(strtolower($m[1]), ['http', 'https', 'mailto', 'tel'], true);
        }

        // No scheme at all => a relative path like "foo/bar".
        return true;
    }
}
