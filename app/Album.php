<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    //
    protected $table = 'album';
    protected $fillable = ['title','maxpic','minpic','md5','share','email','gmt','lastmodefieddate'];
}
