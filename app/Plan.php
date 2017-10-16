<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
	protected $fillable = ['name', 'price', 'order'];


    public function next(){
        return $this->belongsTo(Plan::class);
    }
    public function nextId(){
        return $this->next();
    }

    public function conditions(){
        return $this->hasMany(PlanCondition::class);
    }

}
