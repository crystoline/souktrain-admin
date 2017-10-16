<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPlanCondition extends Model
{
    protected $fillable = ['plan_condition_id', 'user_id'];
}
