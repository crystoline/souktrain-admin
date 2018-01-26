<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicCenter extends Model
{
    public function income(){
    	return $this->hasMany(ServicCenterIncome::class);
    }
}
