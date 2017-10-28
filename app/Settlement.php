<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settlement extends Model
{
    protected $fillable = [
    	'name', 'status'
    ];

    public function settlementIncomes(){
    	return $this->hasMany(SettlementIncome::class);
    }

	public function statusToString()
	{
		switch ($this->status){
			case '-1': return 'Pending';
			case '0': return 'Approved';
			case '1': return 'Confirm';
			default: return 'Unknown';
		}
	}

	public function statusToColor()
	{
		switch ($this->status){
			case '-1': return 'warning';
			case '0': return 'success';
			case '1': return 'primary';
			default: return 'default';
		}
	}
}
