<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed plan_id
 * @property mixed level
 * @property mixed title
 * @property mixed action
 */
class PlanCondition extends Model
{
	protected $fillable = [

		'plan_id',
		'condition_id',
		'level',
		'min',
		'limits',
		'amount',
		'user_account_type_id',
		'action',
		'sub_action',
		'title'
	];

    public function plan(){
        return $this->belongsTo(Plan::class);
    }
    public function planId(){
        return $this->plan();
    }
    public function getConditionAttribute(){
    	//dd(PlanCondition::find($this->condition_id));
	    if($this->condition_id){
	    	return PlanCondition::find($this->condition_id);
	    }
	    //return new PlanCondition();
        //return $this->hasOne(PlanCondition::class, 'id','condition_id');
        //return null;//PlanCondition::get();
    }
    /*public function conditionId(){
        return $this->condition();
    }*/

    public function userAccountType(){
        return $this->belongsTo(UserAccountType::class);
    }

    public function userAccountTypeId(){
        return $this->userAccountType();
    }
     
}
