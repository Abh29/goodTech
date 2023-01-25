<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
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
    ];

    public function canCreateFeed() : bool {
        if (!auth() || auth()->user()->role_id != Role::IS_CLIENT)
            return false;
        return auth()->user()->latestFeedback->created_at->diffInHours(now()) > 23;
    }

    public function feedbacks() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Feedback::class, 'user_id');
    }

    public function latestFeedback() {
        return $this->hasOne(Feedback::class, 'user_id')->latestOfMany();
    }

}
