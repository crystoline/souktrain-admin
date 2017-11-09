<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicCenter extends Model
{
    public function user(){
        return $this->BelongsTo(User::class);
    }
    public function myAction(){
        $this->user;
    }
}
