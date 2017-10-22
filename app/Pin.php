<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pin extends Model
{

	protected $fillable = ['code', 'pin_collection_id'];
    public function collection(){
        return $this->belongsTo(PinCollection::class, 'pin_collection_id');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
