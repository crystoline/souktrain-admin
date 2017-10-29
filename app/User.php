<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email','username', 'password', 'avatar', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //public $wallet_balance = 0;

    public  function profile(){
        return $this->hasOne(Profile::class);
    }
    public  function role(){
        return $this->belongsTo(Role::class);
    }

    public function initialize(){
        if(!$this->profile){
            $this->profile()->create([
                'status' => 1
            ]);
        }
        if(!$this->role_id){
            $this->role_id = 2;
            $this->save();
        }
    }


    /**
     * @param $plan_id
     * @return null|UserPlan
     */
    public function getSubscription(Plan $plan){
        return $this->subscriptions()->where(['plan_id' => $plan->id])->get()->first()->load(['user', 'upLine', 'plan' ]);
        $subs = $this->subscriptions;
        if($subs){
            foreach($subs as $sub){
                if(@$sub->plan_id == $plan_id)
                    return $sub;
            }
        }
        return null;
    }


    public function subscriptions(){
        return $this->hasMany(UserPlan::class);
    }

   /* public function downTree(){
        $r = $this->hasMany(UserTree::class, 'upline_id', 'id');
        return $r;
    }*/

    /*
     * Plans having  down line
     */
    public function downLine(){
        $r = $this->hasMany(UserPlan::class,  'upline_id', 'id');
        //dd($r->getResults());
        return $r;
    }
    public function getDownLines(Plan $plan,$limit=4, $call=0){
        if($call == $limit) return [];
        $downLines = [];
        $result = UserPlan::where(['upline_id' => $this->id, 'plan_id' => $plan->id])->get()->load(['user.profile']);

        if($result){
            foreach ($result as $i =>$sub){

                $user = $sub->user->toArray();
                $user['down_line'] = $sub->user->getDownlines($plan,$limit,$call++);
                $downLines[] = $user;

            }
        }
        return $downLines;

    }
    private function downlinesForLevel($plan, $level=1){
    	$down_lines = $this->getDownLines($plan);

    	if($level > 1){

		    $down_lines2 = [];

		    if(is_array($down_lines)){

			    foreach ($down_lines as $w =>$down_line){

				    $down_lines2[] = $down_line['down_line'];

				    if($level > 2){

					    $down_lines3 = [];

					    if(is_array($down_lines2)){

						    foreach ($down_lines2 as $x => $down_line2){

							    $down_lines3[] = $down_line2['down_line'];

							    if($level > 3){

								    $downlines4 = [];

								    if(is_array($down_lines3)){

									    foreach ($down_lines3 as $x => $down_line3){

										    $down_lines4[] = $down_line3['down_line'];

									    }

								    }

							    }

						    }

					    }

				    }

			    }
		    }

	    }

	    switch($level){
		    case 1: return $down_lines;
		    case 2: return $down_lines2;
		    case 3: return $down_lines3;
		    case 4: return $down_lines4;
		    default: return [];
	    }



    }



    public function getTreeAttribute(){
        $data = User::find($this->id)->load([
            'downLine.user.downLine.user.downLine.user.downLine.user',
            'downLine.plan',
            'downLine.user.downLine.plan',
            'downLine.user.downLine.user.downLine.plan',
            'downLine.user.downLine.user.downLine.user.downLine.plan',
        ]);
        //return $data->downLine;
        if($userPlans = $data->downLine){
            $formatted = [];
            $this->processTree($userPlans, $formatted,$this->id);
            //print json_encode($formatted); die();

            return $formatted;
        }
        return null;
    }

    private function processTree($userPlans, &$formatted,  $upLineID){

        foreach($userPlans as $userPlan){
            //dd($userPlan);
            if(empty($formatted[$userPlan->plan->id])){
                $formatted[$userPlan->plan->id]['plan_id'] = $userPlan->plan->id;
                $formatted[$userPlan->plan->id]['name'] = $userPlan->plan->name;
            }

           @ $formatted[$userPlan->plan->id]['down_lines'][$userPlan->user->id] =  array('up_line'=>$upLineID,'user'=>$userPlan->user);
            if(!empty( $userPlan->user->downLine)){
                $this->processTree($userPlan->user->downLine, $formatted,$userPlan->user->id);
            }
        }

    }



    public function wallet()
    {
        return $this->walletHistories()->selectRaw('user_id, sum(amount) as balance')->groupBy('user_id');
    }
    public function walletHistories(){
        return $this->hasMany(WalletHistory::class);
    }
    public function getAccount($account_type_id){
        $accounts = $this->accounts;
        if($accounts and isset($accounts)){
            foreach($accounts as $account){
                if($account->user_account_type_id == $account_type_id)
                    return $account;
            }
        }
        return null;
    }
    public function accounts()
    {
        return $this->accountHistories()
            ->selectRaw('user_id, can_sub, can_withdraw, user_account_types.name, user_account_type_id, sum(amount) as balance')
            ->leftJoin('user_account_types', 'user_account_types.id', 'user_account_histories.user_account_type_id')

            ->groupBy(['user_id', 'can_sub', 'can_withdraw', 'name', 'user_account_type_id']);

        return $this->accountHistories()
            ->selectRaw('user_account_types.name as type, sum(amount) as balance')
            ->join('user_account_types', 'user_account_types.id', 'user_id', 'user_account_histories.user_account_type_id')
            ->groupBy(['name', 'user_account_type_id', 'user_id']);

    }
    public function accountHistories(){
        return $this->hasMany(UserAccountHistory::class);
    }
    public function getAccountHistory($account_type_id){
        return  $this->accountHistories()->where(['user_account_type_id' => $account_type_id])->get();
    }

    public function fundWallet(Pin $pin, $msg = 'Wallet funding'){
        $result = $this->walletHistories()->create([
            'amount' => $pin->collection->public_value,
            'description' => $msg
        ]);

        if($result){
            $pin->user_id = $this->id;
            $pin->save();
            return $result;
        }
    }

    /**
     * @param $amount
     * @param $msg
     */
    public function debitWallet($amount, $msg){
        if($amount == 0) return false;
        if($amount > 0) $amount  = -$amount;
        return $result = $this->walletHistories()->create([
            'amount' => $amount,
            'description' => $msg
        ]);
    }
	public function creditWallet($amount, $msg){
		if($amount <= 0) return false;
		if($amount < 0) $amount  = -$amount;
		return $result = $this->walletHistories()->create([
			'amount' => $amount,
			'description' => $msg
		]);
	}

    /**
     * @param UserAccountType $account_type
     * @param $amount
     * @param string $msg
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function accountTransaction(UserAccountType $account_type ,$amount,  $msg, $plan_id = 0){

        return $this->accountHistories()->create([
            'user_account_type_id' => $account_type->id,
            'amount' => $amount,
            'description' => $msg,
            'plan_id' => $plan_id,
            'user_id' => $this->id
        ]);
    }

    public function plan_conditions(){
    	return $this->hasMany(UserPlanCondition::class);
    }

    public function shouldSatisfy(PlanCondition $planCondition)
    {
	    if($planCondition->condition_id){
		    if($this->shouldSatisfy($planCondition->condition)){
			    print '|-'.$planCondition->condition->title."-|\n";
			    return false;
		    }

	    }elseif($planCondition->limits == 0){
			return true;
	    }

    	$user_plan_condition = $this->plan_conditions()->where( 'plan_condition_id', $planCondition->id)->get()->toArray();
    	if($user_plan_condition ){
		    return false;

	    }


	    return true;

    }

    public function checkCondition(PlanCondition $planCondition){
    	if($planCondition->min == 0 and $planCondition->limits == 0){
    		return true;
	    }else{
    		$downlines = $this->downlinesForLevel($planCondition->plan, $planCondition->level);
		    $count = count($downlines);
    		if($count >= $planCondition->min and  $count <= $planCondition->limits){
    			if($count >= $planCondition->limits){
				    $this->plan_conditions()->create([ 'plan_condition_id' => $planCondition->id]);
			    }
    			return true;
		    }

	    }
    	return false;
    }

    public function satisfy(PlanCondition $planCondition)
    {
    	if(!$this->checkCondition($planCondition)) return false;


    	switch ($planCondition->action){
		    case 'credit_account':
		    	if($planCondition->user_account_type_id and
			       $accountType = UserAccountType::find($planCondition->user_account_type_id)){
		    		$r = $this->accountTransaction(
		    			$accountType,
					    $planCondition->amount,
					    'Earning from Downline Upgrade',
					    $planCondition->plan_id
				    );
		    		//var_dump($r);
				    return ['status' => true, 'amount' => $planCondition->amount];
			    }
		    	break;
		    case 'credit_wallet':
		    	$this->creditWallet($planCondition->amount, 'Earning from Downline Upgrade');
		    	return ['status' => true, 'amount' => $planCondition->amount];
			    break;
		    case 'upgrade':
			    $user_subscription = $this->subscriptions()->orderBy('id', 'desc')->first();

			    if($user_subscription){
				    $next_plan = Plan::where('order', '>',$user_subscription->plan->order )->orderBy('order', 'asc')->first();
				    $user_account = $this->accounts()->where(['can_sub' => 1])->first();

				    if($next_plan and $next_plan->amount < $user_account->balance){
				    	$amount = $next_plan->amount;
					    $accountType = UserAccountType::find($user_account->id);
					    $this->accountTransaction(
						    $accountType,
						    -$amount,
						    'Automatic Upgrade to '.$next_plan->name,
						    $next_plan->plan_id
					    );
						$this->doSubscription($next_plan);
						return ['status' => true];
					}
			    }
			    break;
	    }

        return false;
    }


	/**
	 * @param User $user
	 * @param Plan $plan
	 * @param bool $first
	 *
	 * @return bool
	 */
	public function doSubscription( Plan $plan, $first=false){
		//dd(\App\UserPlan::where(['user_id'=>$user->id, 'plan_id'=>$plan->id]));
		$check_plan = \App\UserPlan::where(['user_id'=>$this->id, 'plan_id'=>$plan->id])->get()->first();
		if($check_plan) {//user already subscribed
			return false;
		}
		$ref = null;

		if($first and $this->profile
		              and $this->profile->referral_id
		                  and $upline_user =  User::find($this->profile->referral_id)
		                      and $upline_user->getSubscription($plan) ){// Up_line has subscribed to the first plan already

			$ref = $this->profile->referral_id ;
			//dd($ref);
		}elseif(!$first){
			//dd('no');
			if($prev_plan = \App\UserPlan::where(['user_id'=>$this->id ])->orderBy('id', 'desc')->get()->first()){
				if($upline_user =  User::find($prev_plan->upline_id) and $upline_user->getSubscription($plan->id) ){
					// Upline in last sub has subscribed to the new plan already
					$ref =  $prev_plan->upline_id;
				}
			}

		}
		#7. do subscription
		if(!$this->subscriptions()->create([
			'plan_id' => $plan->id,
			'upline_id' => $ref,
		])){
			return false;
		};


		//8. get uplines (1,2, 3,4), run upline conditions
		$u_suser = $this;
		$total_amount = $plan->price;
		for($i=1; $i <= 4; $i++){ //loop
			if(!$u_sub = $u_suser->getSubscription($plan)
			   or !$u_sub->upline_id or
			   !($u_suser = User::find($u_sub->upline_id)) ){
				//var_dump($this->getSubscription($plan));
				//print "\n";
				break;
			}

			$conditions = $plan->conditions()->where(['level'=>$i, 'plan_id' => $plan->id])->get();
			//var_dump($conditions);
			//if(is_array($conditions)){

				foreach($conditions/*->orderBy('order')->get()*/ as $condition){

					if( $u_suser->shouldSatisfy($condition, $i)){
						print $condition->title."\n";
						if($result = $u_suser->satisfy($condition, $i)){
							if(!empty($result['amount'])){
								$total_amount -= $result['amount']; //subtract amount up_line received
							}
							//var_dump($result);
						}
					}else{
						//print $condition->name."\n";
					}
				}
			//}


		}
		var_dump($total_amount);

		#9. get remaining balance, put into sharing tables
		$beneficiaries = config('souktrain.beneficiaries', [
			'souktrain' => [ 'ratio' => 0.7, ],
			'netronit' => [ 'ratio' => 0.3, ]
		]);
		/*$sharing_formular = array(
			'souktrain' => 0.7,
			'netronit'  => 0.3
		);*/
		foreach ($beneficiaries as $name => $beneficiary){
			$ratio = $beneficiary['ratio'];
			$income = new Income([]);
			$income = Income::create([
				'beneficiary'   => $name,
				'amount'        => $total_amount * $ratio,
				'description'   => 'Subscription: '.$plan->name
			]);
			if(!$income) return false;
		}
		return true;

	}
}
