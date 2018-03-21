<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MhGmItem extends Model
{
    //
    protected $connection = 'sqlsrv';
    protected $table = 'GMItem';
}
