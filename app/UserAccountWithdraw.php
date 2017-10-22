<?php
/**
 * Created by PhpStorm.
 * User: jyde
 * Date: 10/18/2017
 * Time: 10:00 PM
 */

namespace App;
use Illuminate\Database\Eloquent\Model;

class UserAccountWithdraw extends Model
{
	protected $fillable = [
		'status',
		'details',
		'transaction_fee'
	];
	protected $table = 'user_account_withdraw';
	public function user(){
		return $this->BelongsTo(User::class, 'user_id', 'id');
	}

	public function userAccountType(){
		return $this->BelongsTo(userAccountType::class, 'user_account_type_id', 'id');
	}
}