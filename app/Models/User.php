<?php

namespace App\Models;

use App\Models\Traits\Sluggable;
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
    protected $fillable = [
        'username',
        'password',
        'name',
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
    ];

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
     * Get the User's journal entries.
     */
    public function journalEntries(): HasMany {
        return $this->hasMany(JournalEntry::class);
    }

    /**
     * Get User's past, present, and future goals.
     *
     * @todo Refactor or remove as needed.
     *
     * @return \Illuminate\Support\Collection[]
     */
    public function getGoalsByTime(?Carbon $date = null): array {
        return ['past' => new Collection(), 'present' => new Collection(), 'future' => new Collection()];
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
