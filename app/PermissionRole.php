<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    protected $table = 'permission_role';

    public function role(){
    	return $this->hasOne(Role::class);
    }
	public function permission(){
		return $this->hasOne(Permission::class);
    }
}
