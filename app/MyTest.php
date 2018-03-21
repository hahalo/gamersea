<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MyTest extends Model
{
    //
    protected $connection = 'sqlsrv';
    protected $table = 'User';
 //   protected $fillable = ['title','maxpic','minpic','md5','share','email','gmt','lastmodefieddate'];
}
