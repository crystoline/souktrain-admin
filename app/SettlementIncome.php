<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettlementIncome extends Model
{
    protected $fillable = [
    	'income_id',
	    'settlement_id'
    ];

    public function income()
    {
    	return $this->belongsTo(Income::class);
    }
	public function settlement()
	{
		return $this->belongsTo(Income::class);
	}
}
