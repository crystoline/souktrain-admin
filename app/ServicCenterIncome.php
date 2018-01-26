<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicCenterIncome extends Model
{
    protected $fillable = [
    	'servic_center_id', 'amount' ,'description'
    ];

    public function ServicCenter(){
    	$this->belongsTo(ServicCenter::class);
    }
}
