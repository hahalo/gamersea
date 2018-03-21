<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlbumLike extends Model
{
    //
    protected $table = 'album_like';
    protected $fillable = ['id','userid','albumid'];
}
