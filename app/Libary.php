<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Libary extends Model
{
    //
    protected $connection = 'mysql2';
    protected $table = 'csdn_libary';
    protected $fillable = ['username','email'];
    protected  $hidden =['password'];
}