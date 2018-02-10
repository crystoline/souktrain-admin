<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\UserAccountType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller
{
	function payment(Request $request){

		$amount         = $request->input('amount');
		$email          = $request->input('email');
		$password    = $request->input('password');

		if(empty($email) or empty($password)){
			return ['status' => 'X1', 'message' => "Email and password are required"];
		}
		if($amount <= 0 ){
			return ['status' => 'X2', 'message' => "Total amount is invalid"];
		}
		$user = User::where(['email' => $email])->first();
		if(!$user or Hash::check($password, $user->password) === false){
			return ['status' => 'X3', 'message' => "Invalid Email or password"];
		}
		//$user = new User();
		$account = $user->accounts()->where(["name" => "Product", 'can_withdraw' => 0, 'can_sub' => 0, 'visibility' => 1])->first();

		if(!$account or $account->balance < $amount){
			$balance = !empty($account->balance)? number_format($account->balance, 2) : 0.00;
			return ['status' => 'X4', 'message' => "Insuficient Balance: N". $balance];
		}
		$account_type = UserAccountType::find($account->user_account_type_id);
		if(!$user->accountTransaction($account_type, -$amount, 'Purchase of Product')){
			return ['status' => 'X5', 'message' => "Transaction was not successful"];
		}

		return ['status' => '00', 'message' => 'Transaction was successful'];
	}
}
