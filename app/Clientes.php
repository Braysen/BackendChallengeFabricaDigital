<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    protected $fillable = ["name", "fatherlastname", "motherlastname", "email","affair", "names"];
}
