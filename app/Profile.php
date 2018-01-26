<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed last_name
 * @property mixed first_name
 */
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
    public function getFullNameAttribute(){
    	return "{$this->first_name} {$this->last_name}";
    }


	public function accountInfo(){
		return $this->hasOne(AccountInfo::class);
	}
    public function profileUpdate()
    {
        return $this->hasOne(ProfileUpdate::class);
    }

    public function serviceCenter(){
		return $this->belongsTo(ServicCenter::class, 'service_center_id', 'id');
    }
}
