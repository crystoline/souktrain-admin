<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatrixLog extends Model
{
    protected $fillable = [
	    'user_id',
	    'upline_id',
	    'plan_id',
	    'level'
    ];

    public function user(){
    	return $this->hasOne(User::class,'id', 'user_id');
    }

	public function upline(){
		return $this->hasOne(User::class, 'id', 'upline_id');
	}

	public function planCOndition(){
		return $this->hasOne(PlanCondition::class);
	}

}
