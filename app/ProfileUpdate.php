<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfileUpdate extends Model

{
    protected $table = 'profile_update';
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
