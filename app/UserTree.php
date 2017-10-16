<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTree extends Model
{
    public function upline(){
        return $this->hasOne(User::class, 'id', 'upline_id');
    }
    protected $hidden = [
        'id',
        'user_plan_id',
        'upline_id'
    ];

    public function userPlan()
    {
        return $this->belongsTo(UserPlan::class);
    }
}
