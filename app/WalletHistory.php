<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class WalletHistory extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'description'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
