<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $fillable = ["name", "password", "remember_token" , "api_token" , "fatherlastname", "motherlastname", "email","affair", "names"];
}
