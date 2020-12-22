<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * @inheritdoc
     */
    protected array $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * @inheritdoc
     */
    protected array $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @inheritdoc
     */
    protected array $casts = [
        'email_verified_at' => 'datetime',
    ];
}
