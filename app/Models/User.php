<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Saving;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_no',
        'address',
        'birth_date',
        'password',
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

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
    
    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    public function savings(): HasMany
    {
        return $this->hasMany(Saving::class, 'user_id');
    }
    public function companies(): HasMany
    {
        return $this->hasMany(Company::class);
    }
    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }
    public function credits(): HasMany
    {
        return $this->hasMany(Credit::class);
    }
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }



    // portfolio
    public function seminar(): HasMany
    {
        return $this->hasMany(Seminar::class, 'user_id');
    } 
    public function experience(): HasMany
    {
        return $this->hasMany(Experience::class, 'user_id');
    }
    public function skill(): HasMany
    {
        return $this->hasMany(Skill::class, 'user_id');
    }
}
