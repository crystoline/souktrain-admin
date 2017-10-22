<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PinRequest extends Model
{
    protected $fillable = [
    	'email',
	    'pin_collection_id',
	    'count', 'cost', 'value',
	    'status',
	    'ref_no',
	    'sent_date'
    ];


    public function pinCollection(){
    	return $this->belongsTo(PinCollection::class);

    }

    public function pins(){
    	return $this->hasMany(Pin::class);
    }
}
