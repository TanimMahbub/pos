<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class user extends Model {
    protected $fillable = ['firstName','lastName','email','mobile','password','otp'];
    protected $attributes = [
        'otp' => '0'
    ];
}