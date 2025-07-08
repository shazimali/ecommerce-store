<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\ResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as PasswordsCanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements CanResetPassword
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, PasswordsCanResetPassword;


    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'password',
        'address',
        'billing_address',
        'phone',
        'facebook_id',
        'google_id',
        'city',
        'avatar',
        'profile_image',
        'country_id',
        'type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    public function country(): HasOne
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }
}
