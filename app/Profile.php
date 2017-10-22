<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'oauth_provider',
        'oauth_uid',
        'first_name',
        'last_name',
        'gender',
        'locale',
        'email',
        'picture_url',
        'profile_url',
        'created_at',
        'updated_at',
        'status',
        'my_id',
        'referral_id'
    ];

    public function user(){
        return $this->BelongsTo(User::class);
    }

	public function accountInfo(){
		return $this->hasOne(AccountInfo::class);
	}
}
