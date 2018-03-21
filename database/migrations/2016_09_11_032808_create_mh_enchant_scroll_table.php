<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMhEnchantScrollTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('mh_enchant_scroll',function(Blueprint $table){
            $table->increments('id');
            $table->string('name',50);
            $table->string('code',50);
            $table->string('type',50);
            $table->integer('leavel');
            $table->string('part',50);
            $table->string('use',200);
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
