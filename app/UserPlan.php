<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPlan extends Model
{
    protected $fillable = [
        'user_id',
        'plan_id',
        'upline_id'
    ];
    protected $hidden = [
        'plan_id'
    ];
    protected $with = [
        'plan'
    ];

    public function plan(){
        return $this->belongsTo(Plan::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

    /*public function userTree(){
        return $this->hasOne(UserTree::class);
    }*/

    public function upLine(){
        return $this->hasOne(User::class, 'id', 'upline_id');
    }




}
