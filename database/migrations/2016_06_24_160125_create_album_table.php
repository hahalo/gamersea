<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('album',function(Blueprint $table){
            $table->increments('id');
            $table->string('title');
            $table->string('maxpic');
            $table->string('minpic');
            $table->string('md5','50');
            $table->tinyInteger('share');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
