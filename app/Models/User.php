<?php

namespace App\Models;

use App\Models\Traits\Sluggable;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property string $username
 * @property string $password
 * @property bool $admin
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Goal[] $goals
 * @property-read int|null $goals_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\JournalEntry[] $journalEntries
 * @property-read int|null $journal_entries_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|Media[] $media
 * @property-read int|null $media_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User findSimilarSlugs(string $attribute, array $config, string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User withUniqueSlugConstraints(\Illuminate\Database\Eloquent\Model $model, string $attribute, array $config, string $slug)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\JournalDate[] $journalDates
 * @property-read int|null $journal_dates_count
 * @property \Illuminate\Support\Collection|null $meals
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMeals($value)
 * @property-read Collection $meals_enabled
 */
final class User extends Authenticatable implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use Notifiable;
    use Sluggable;

    /**
     * @inheritdoc
     */
    protected static function booted(): void {
        static::creating(function (User $user) {
            // Set default meals configuration.
            $user->meals = User::getDefaultMeals();
        });
    }

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'username',
        'password',
        'name',
        'meals',
        'admin',
    ];

    /**
     * @inheritdoc
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @inheritdoc
     */
    protected $casts = [
        'admin' => 'bool',
        'meals' => AsCollection::class,
    ];

    /**
     * Get the default meals structure.
     */
    public static function getDefaultMeals(): Collection {
        $meals = new Collection();
        for ($i = 0; $i <= 7; $i++) {
            $meals->add([
                'value' => $i,
                'label' => 'Meal ' . ($i + 1),
                'weight' => $i,
                'enabled' => $i < 3,
            ]);
        }
        return $meals;
    }

    /**
     * @inheritdoc
     */
    public function sluggable(): array
    {
        return ['slug' => ['source' => 'username']];
    }

    /**
     * Get the User's goals.
     */
    public function goals(): HasMany {
        return $this->hasMany(Goal::class);
    }

    /**
     * Get the User's journal dates.
     */
    public function journalDates(): HasMany {
        return $this->hasMany(JournalDate::class);
    }

    /**
     * Get the User's journal entries.
     */
    public function journalEntries(): HasMany {
        return $this->hasMany(JournalEntry::class);
    }

    /**
     * Get the User's enabled meals, sorted by weight.
     */
    public function getMealsEnabledAttribute(): Collection {
        return $this->meals->where('enabled', true)->sortBy('weight');
    }

    /**
     * Get user's goal (if one exists) for a specific date.
     *
     * The primary use for a JournalDate entry right now is the goal so this
     * method also creates a JournalDate if one does not already exist.
     */
    public function getGoalByDate(Carbon $date): ?Goal {
        $journal_date = JournalDate::getOrCreateJournalDate($this, $date);
        if ($journal_date->goal) {
            return $journal_date->goal;
        }

        // Check for a goal based on day of week configurations.
        $day = Goal::days()->firstWhere('dow', $date->format('N'));
        if (!$day) {
            throw new \BadMethodCallException("No day with `dow` value {$date->format('N')}.");
        }
        /** @var \App\Models\Goal $goal */
        $goal = $this->goals()->whereRaw("(days & {$day['value']}) != 0")->first();
        if (!empty($goal)) {
            $journal_date->goal()->associate($goal);
        }

        if ($journal_date->hasChanges(['date', 'goal'])) {
            $journal_date->save();
        }

        return $goal;
    }

    /**
     * Defines conversions for the User image.
     *
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     *
     * @see https://spatie.be/docs/laravel-medialibrary/v9/converting-images/defining-conversions
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('icon')
            ->width(300)
            ->height(300)
            ->sharpen(10)
            ->optimize();
    }
}
