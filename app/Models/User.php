<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Goal[] $goals
 * @property-read int|null $goals_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\JournalEntry[] $journalEntries
 * @property-read int|null $journal_entries_count
 */
final class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * @inheritdoc
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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
     * @return \App\Models\Goal[]
     */
    public function getGoalsByTime(?Carbon $date = null): array {
        $now = $date ?? Carbon::now();
        $goals = ['past' => new Collection(), 'present' => new Collection(), 'future' => new Collection()];
        Goal::all()->where('user_id', Auth::user()->id)
            ->each(function ($item) use(&$goals, $now) {
                if ($item->to && $now->isAfter($item->to)) {
                    $goals['past'][$item->id] = $item;
                }
                elseif ($item->from && $now->isBefore($item->from)) {
                    $goals['future'][$item->id] = $item;
                }
                elseif (
                    empty($item->from)
                    || empty($item->to)
                    || $now->isBetween($item->from, $item->to)
                ) {
                    $goals['present'][$item->id] = $item;
                }
            });
        return $goals;
    }
}
