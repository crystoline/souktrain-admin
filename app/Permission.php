<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Permission extends Model
{
	/**
	 * To be called as a static method
	 */
	public function roles(){
		return $this->belongsToMany(Role::class);
	}
    public static function groups(){
	    return self::selectRaw('DISTINCT table_name as `name` ')->orderBy('name', 'ASC')->get();
    }

	public static function groupPermissions($group){
		return self::selectRaw(' DISTINCT `key` as name, id')
		           ->where('table_name', $group)
		           ->orderBy('name', 'ASC')->get();
	}

}
