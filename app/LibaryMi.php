<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LibaryMi extends Model
{
    //
    protected $connection = 'mysql2';
    protected $table = 'mi_libary';
    protected $fillable = ['username','email'];
    protected  $hidden =['password'];
}