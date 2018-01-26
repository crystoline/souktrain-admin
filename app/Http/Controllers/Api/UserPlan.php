<?php

namespace App\Http\Controllers\Api;

use App\Income;
use App\Plan;
use App\Tools\Utility;
use App\User;
use App\UserAccountType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserPlan extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $user->load('subscriptions.plan');
        return Utility::json_success($user->subscriptions);
    }

    /**
     * @param User $user
     * @param number $id
     * @return \Illuminate\Http\JsonResponse
     * @internal param Plan $plan
     */
    public function upLine(User $user, $id){
        $plan = Plan::find($id);
        $sub = $user->getSubscription($plan);
        if(!empty($sub->upLine) and $sub->upLine->getSubscription($plan)){
            return Utility::json_success($sub->upLine);
        }
        return Utility::json_success(null);
    }

	public function downLine(User $user, $id) {
		$plan = Plan::find( $id );
		//$user->getDownLines($plan);
		$children_name = request()->input( 'children' ) ?: 'down_line';

		return Utility::json_success( $user->getDownLines( $plan, $children_name ) );
	}
	public function downLine2(User $user, $id) {
		$plan = Plan::find( $id );

		$user_array = $user->toArray();

		$user_array['children'] = $user->getDownLines( $plan, 'children' );
		return Utility::json($user_array);
	}

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function subscribe(Request $request, User $user)
    {
        /**
         * 1. supply account_type wallet|account_id
         * 2. detect next plan. and cost
         * 3. check balance
         * 4. check if balance is enough
         * 5. check if account can subscribe
         * 6. debit account.
         * 7. do subscribe
         * 8. get uplines (1,2, 3,4), get earnings, and settle uplines
         * 9. get remaining balance, put into sharing tables
         * 10.
         *
         */
        //1. supply account_type wallet|account_id
        $first_sub =  false;
        $validator = Validator::make(
            $request->all(),
            [
                'account_type' => 'required', //wallet, or user_account_type_id
                'plan_id' => 'required'
            ]
        );
        if ($validator->fails()) {
            return  Utility::json_failure($error = $validator->errors()->first(), '001');
        }
        $account_type = $request->input('account_type');
        $plan_id = $request->input('plan_id');

        $user_subscription = $user->subscriptions()->orderBy('id', 'desc')->first();

        //2.  detect next plan. and cost
        if($user_subscription and $user_subscription->plan){
            $next_plan = Plan::where('order', '>',$user_subscription->plan->order )->orderBy('order', 'asc')->first();

        }else{
            $next_plan = Plan::where('order', '=',1 )->first();
            $first_sub = true;
        }


        if(!$next_plan) return Utility::json_failure('No plan to subscribe', 'P05');

        if($next_plan->id != $plan_id)
            return Utility::json_failure('You can\'t subscribe to this plan', 'P06');



        if($account_type == 'wallet'){
            //3. check balance
            //4. check if balance is enough
            $wallet = $user->wallet->toArray();
            if(!$wallet or !$wallet[0] or
                !$wallet[0]['balance'] or
                $wallet[0]['balance'] <  $next_plan->price ){

                return Utility::json_failure('Wallet balance too low');
            }
            DB::beginTransaction();

            if(!$user->debitWallet($next_plan->price, "Subscription for ".$next_plan->name)){
                DB::rollBack();
                return Utility::json_failure('Wallet error');
            }

        }else{

            $account = $user->getAccount($account_type);

            //3. check balance
            //4. check if balance is enough
            if(@!$account or !$account->balance or $account->balance < $next_plan->price)
                return Utility::json_failure('Account balance too low');

            //5. check if account can subscribe

            if(!$account->can_sub){
                Utility::json_failure('Selected account can not subscribe');
            }

            //6. debit account.
            DB::beginTransaction();

            if(!$user->accountTransaction(
                UserAccountType::find($account->user_account_type_id) ,
                $next_plan->price,
                "Subscription for ".$next_plan->name,
                $next_plan->id
            )){
                DB::rollBack();
                return Utility::json_failure('Account error');
            }


        }

        /* 7. do subscribe
        * 8. get uplines (1,2, 3,4), get earnings, and settle uplines
        * 9. get remaining balance, put into sharing tables
        * 10.
        */
        if(!$user->doSubscription($next_plan,$first_sub)){
            DB::rollBack();
            return Utility::json_failure('Subscription failed');
        }
	    //DB::rollBack();
        DB::commit();
        return Utility::json_success('Subscription successful');
    }

    /**
     * @param User $user
     * @param Plan $plan
     * @param bool $first
     * @return bool
     */


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
