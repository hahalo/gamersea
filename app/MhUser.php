<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MhUser extends Model
{
    //
    protected $connection = 'sqlsrv';
    protected $table = 'User';
}
