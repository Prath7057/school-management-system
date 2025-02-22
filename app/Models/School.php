<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use App\Notifications\SchoolResetPasswordNotification;
use App\Notifications\SchoolVerifyEmailNotification;

class School extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'address', 'email', 'phone', 'password', 'profile_picture', 'email_verified_at'];

    protected $hidden = ['password'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new SchoolResetPasswordNotification($token));
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new SchoolVerifyEmailNotification());
    }
}
