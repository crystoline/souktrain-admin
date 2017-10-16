<?php

namespace App\Http\Controllers\Api;

use App\Pin;
use App\User;
use App\UserAccountType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use  App\Tools\Utility;

class UserWalletController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function show(User $user)
    {
        return Utility::json_success($user->wallet->first() );
    }

    public function history(User $user)
    {
        return Utility::json_success($user->walletHistories);
    }


    public function fund(Request $request, User $user){
        $validator = Validator::make($request->only(['pin']),
        [
            'pin' => 'required|exists:pins,code'
        ]);
        if ($validator->fails()) {
            return  Utility::json_failure($error = $validator->errors()->first(), '001');
        }
        $pin  = Pin::where(['code' => $request->input('pin')])->get()->first();

        //var_dump($pin->user);
        //return json_encode($pin->user);
        if($pin->user){
            //dd($pin);
            $by = ($pin->user and $pin->user->id == $user->id)? 'you' : 'someone else';
            return Utility::json_failure("Pin already used by {$by}", 'P01');
        }

        if($user->fundWallet($pin)){
            return Utility::json_success('your wallet was funded with '.number_format($pin->collection->public_value));
        };
        return Utility::json_failure('unsuccessful');
    }

    public function transfer(Request $request, User $user){
        $validator = Validator::make($request->all(),
            [
                'account_type' => 'required|exists:user_account_types,id',
                'amount' => 'required|'
            ]);
        if ($validator->fails()) {
            return  Utility::json_failure($error = $validator->errors()->first(), '001');
        }
        $accountType = UserAccountType::find($request->input('account_type'));
        if(!$accountType){
            return Utility::json_failure(['error' => "Account does not exist"], 'ACC01');
        }
        $amount = $request->input('amount');
        if($amount <= 0 ){
            return Utility::json_failure(['error' => "Ammount is too small"], 'WAL01');
        }

        if($user->wallet()->first()->balance < $amount){
            return Utility::json_failure(['error' => "Wallet balance is too low"], 'WAL02');
        }

        try {
            // Begin a transaction
            DB::beginTransaction();
            $r1 = $user->debitWallet($amount, 'Fund transfer to account: '.$accountType->name);
            $r2 = $user->accountTransaction($accountType, $amount, "Fund transferred from wallet");
            // Commit the transaction
            DB::commit();
            return Utility::json_success('transfer complete');

        } catch (\Exception $e) {
            // An error occured; cancel the transaction...
            DB::rollback();
            //dd($accountType);
            return  Utility::json_failure(['error' => "Fund could not be transferred"]);
        }

    }
}
