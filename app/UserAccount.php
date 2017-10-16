<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function userId(){
        return $this->belongsTo(User::class);
    }

    public function userAccountType(){
        return $this->belongsTo(UserAccountType::class);
    }

    public function userAccountTypeId(){
        return $this->belongsTo(UserAccountType::class);
    }
}
