<?php

namespace App\Http\Controllers\Api;

use App\Tools\Utility;
use App\User;
use App\UserAccountType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        return Utility::json_success($user->accounts);
    }


    /**
     * Display the specified resource.
     *
     * @param User $user
     * @param $account_type_id
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function show(User $user, $account_type_id)
    {
        return Utility::json_success($user->accounts()->where(['user_account_type_id' => $account_type_id])->get()->first());
    }


    /**
     * @param User $user
     * @param int $account_type_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function history(User $user, $type)
    {
        return Utility::json_success($user->getAccountHistory($type));
    }

    public function transfer(Request $request, User $user){
        $validator = Validator::make($request->all(),
            [
                'from_account_type' => 'required|exists:user_account_types,id',
                'to_account_type' => 'required|exists:user_account_types,id',
                'amount' => 'required|'
            ]);
        if ($validator->fails()) {
            return  Utility::json_failure($error = $validator->errors()->first(), '001');
        }
        $toAccountType      = UserAccountType::find($request->input('to_account_type'));
        $fromAccountType    = UserAccountType::find($request->input('from_account_type'));

        $amount = $request->input('amount');

        $account1 = $user->accounts()->where(['user_account_type_id' => $request->input('from_account_type')])->first();
        if(!$account1 or $account1->balance < $amount){
            return Utility::json_failure(['error' => "Wallet balance is too low"], 'WAL02');
        }

        try {
            // Begin a transaction
            DB::beginTransaction();
            $r1 = $user->accountTransaction($fromAccountType, -$amount, "Fund transferred to ".$toAccountType->name);
            $r2 = $user->accountTransaction($toAccountType, $amount, "Fund transferred from ".$fromAccountType->name);
            // Commit the transaction
            DB::commit();
            return Utility::json_success('transfer complete');

        } catch (\Exception $e) {
            // An error occurred; cancel the transaction...
            DB::rollback();
            //dd($accountType);
            return  Utility::json_failure(['error' => "Fund could not be transferred"]);
        }
    }


}
