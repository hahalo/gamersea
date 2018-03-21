<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MhQueuedItem extends Model
{
    //
    protected $connection = 'sqlsrv';
    protected $table = 'QueuedItem';
    protected $fillable = ['CID','ItemClassEx','Count','IsCharacterBinded','MailTitle','MailContent'];
}
