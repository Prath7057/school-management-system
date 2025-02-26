<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'name', 'email', 'class', 'age', 'gender',
        'profile_picture', 'country', 'state', 'city',
        'zip_code', 'school_id', 'barcode'
    ];
    //
    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
