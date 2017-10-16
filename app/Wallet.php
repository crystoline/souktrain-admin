<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Wallet extends Model
{
    protected $fillable = [
       'created_at'
    ];
    public function user(){
        return $this->BelongsTo(User::class);
    }
    public function userId(){
        return $this->user();
    }
    /*public function walletHistories(){
        return $this->hasMany(WalletHistory::class);
    }

    public function getNetBalanceAttribute(){

    }*/



}
