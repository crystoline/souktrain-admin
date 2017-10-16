<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAccountHistory extends Model
{
    protected $fillable = [
        'user_account_type_id',
        'amount',
        'description',
        'plan_id',
        'user_id'
    ];
}
