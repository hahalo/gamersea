<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MhCharacterInfo extends Model
{
    //
    protected $connection = 'sqlsrv';
    protected $table = 'CharacterInfo';
}
