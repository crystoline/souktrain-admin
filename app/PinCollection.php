<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PinCollection extends Model
{
     protected $table = "pin_collections";

     protected $fillable = [
         'name',
         'real_value',
         'public_value'
     ];

     public function pins(){
          return $this->hasMany(Pin::class);
     }
}
