<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use Authenticatable;

    protected $fillable = [
        'school_name', 'address', 'email', 'phone_number', 'password', 'profile_picture',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $table = 'schools';
}
