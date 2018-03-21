<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Daily extends Model
{
    //
    protected $table = 'daily';
    protected $fillable = ['releasetime','content'];
}
