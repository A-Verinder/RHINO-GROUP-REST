<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'first_name',
        'middle_name',
        'last_name',
        'suffex_name',
        'username',
        'email',
        'password',
        'photo',
        'type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the user's avatar.
     *
     * @return string
     */
    public function getAvatarAttribute(): string
    {
        return $this->photo ? 'user_photos/' . $this->photo : 'user_photos/default-avatar.png';; 
    }

    /**
    * Get the user's full name.
    *
    * @return string
    */
    public function getFullnameAttribute(): string
    {
        return trim($this->first_name . ' ' . $this->middle_name . ' ' . $this->last_name);
    }

    /**
    * Get the user's middle initial.
    *
    * @return string|null
    */
    public function getMiddleinitialAttribute(): ?string
    {
        return $this->middle_name ? strtoupper(substr($this->middle_name, 0, 1)) . '.' : null;
    }

}
