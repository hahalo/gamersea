<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMhSynthesisSkillBonusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('mh_synthesis_skill_bonus',function(Blueprint $table){
            $table->increments('id');
            $table->integer('classrestriction');
            $table->string('skillid',255);
            $table->string('skillname',255);
            $table->string('descid',255);
            $table->string('grade',255);
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
