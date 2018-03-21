<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    //
    protected $table = 'music';
    protected $fillable = ['musicname','singer','singerpic','musicurl'];
}
