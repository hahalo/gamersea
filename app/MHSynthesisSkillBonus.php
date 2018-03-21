<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MHSynthesisSkillBonus extends Model
{
    //
    protected $table = 'mh_synthesis_skill_bonus';
    protected $fillable = ['classrestriction','skillid','skillname','descid','grade'];
}
