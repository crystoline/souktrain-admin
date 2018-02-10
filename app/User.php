<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

/**
 * @property mixed id
 */
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
	protected $with = [
		'wallet','profile', 'accounts', 'subscriptions'
	];
    //public $wallet_balance = 0;

    public  function profile(){
        return $this->hasOne(Profile::class);
    }
    public  function role(){
        return $this->belongsTo(Role::class);
    }


	/**
	 * @param string $permission
	 *
	 * @return bool
	 */
    public function hasPermission($permission)
    {
    	$role = $this->role;
    	if($role){
		    $permissions = $role->permissions->pluck('key')->toArray();
		    if(in_array($permission, $permissions)){
		    	return true;
		    }
		    //dd($permissions);
	    }

	    return false;
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
        $subscription = $this->subscriptions()->where(['plan_id' => $plan->id])->get()->first();
        if(empty($subscription)) return null;
	    return $subscription->load(['user', 'upLine', 'plan' ]);

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
    public function getDownLines(Plan $plan, $children_name = 'down_line',$limit=4, $call=0){
        if($call == $limit) return [];
        $downLines = [];
        $result = UserPlan::where(['upline_id' => $this->id, 'plan_id' => $plan->id])->get()->load(['user.profile']);

        if($result){
            foreach ($result as $i =>$sub){

                $user = $sub->user->toArray();
                $user[$children_name] = $sub->user->getDownlines($plan, $children_name,$limit,$call+1);
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
            ->selectRaw('user_id, can_sub, visibility, can_withdraw, user_account_types.name, user_account_type_id, sum(amount) as balance')
            ->leftJoin('user_account_types', 'user_account_types.id', 'user_account_histories.user_account_type_id')

            ->groupBy(['user_id', 'can_sub', 'visibility', 'can_withdraw', 'name', 'user_account_type_id']);

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

    public function shouldSatisfy(PlanCondition $planCondition, $is_main = true)
    {
	    $user_plan_condition = $this->plan_conditions()->where( 'plan_condition_id', $planCondition->id)->get()->toArray();
	   // print 'dkodjsdiosdj';
	    if($user_plan_condition ){
		    //print $planCondition->amount."\n";
		    return false;
	    }elseif($planCondition->condition_id){

		    if($this->shouldSatisfy($planCondition->condition, false)){
			    //print '|-'.$planCondition->title.$planCondition->condition_id."-|\n";
			    return false;
		    }
	    }
	    //print $planCondition->title."\n";
	    return $this->checkCondition( $planCondition, $is_main);
    }

    public function checkCondition(PlanCondition $planCondition, $is_main = true){
	    //print $planCondition->amount."\n";
    	if($planCondition->min == 0 and $planCondition->limits == 0){
    		return true;
	    }
	    else{
    		$downlines = $this->downlinesForLevel($planCondition->plan, $planCondition->level);
		    $count = count($downlines);

		    if ($planCondition->limits == 0){ //min to unlimited
			    if($count >= $planCondition->min){
				    return true;

			    }
		    }elseif ($planCondition->min == 0){

			    if($count > $planCondition->limits){
				    return false;
			    }elseif($is_main and $count == $planCondition->limits){
				    $this->plan_conditions()->create([ 'plan_condition_id' => $planCondition->id]);//done
			    }
			    return true;

		    }else{
			    if($count >= $planCondition->min and  $count <= $planCondition->limits){
				    //print  $planCondition->title.' MAX. = '.$planCondition->limits."\n";
				    //var_dump($is_main);
				    if($count > $planCondition->limits){
					    return false;
				    }elseif($is_main and $count == $planCondition->limits){
					    $this->plan_conditions()->create([ 'plan_condition_id' => $planCondition->id]);//done
				    }
				    return true;

			    }
		    }


	    }
    	return false;
    }

    public function satisfy(User $user, PlanCondition $planCondition)
    {
		$data = ['status' => false];
		//print $planCondition->action."\n";
    	switch ($planCondition->action){
		    case 'credit_account':;
		    case 'credit_wallet':;
		    case 'upgrade':;
		    case 'credit_service_center':
		    $data = $this->do_action($planCondition, $user);
			    //$this->checkCondition($planCondition);
		    	break;
		    case 'matrix3_2_ps_level_1': //log only
		    case 'matrix_pt_level_1_log':
		    	$r = $this->log_matrix($user, $planCondition);
			    //var_dump($r);
		    	break;
		    case 'matrix6_1_pt_level_1':
		    	//register 6by1 upline
			    $amount = self::matrixLevel2(6,1, $this, $user, $planCondition)?$planCondition->amount: 0;
			    $data =  ['status' => true, 'amount' =>$amount];
			    break;
		    case 'matrix3_2_ps_level_2':

			    $amount = self::matrixLevel2(3,2, $this, $user, $planCondition)?$planCondition->amount: 0;
			    $data =  ['status' => true, 'amount' =>$amount];
			    break;
		    case 'matrix6_2_pt_level_2':
		        $amount = self::matrixLevel2(6,2, $this, $user, $planCondition)?$planCondition->amount: 0;
			    $data =  ['status' => true, 'amount' =>$amount];
		        break;

		    default: $data =  ['status' => true];
	    }


        return $data;
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
				if($upline_user =  User::find($prev_plan->upline_id) and $upline_user->getSubscription($plan) ){
					// Upline in last sub has subscribed to be in the new plan already
					$ref =  $prev_plan->upline_id;
				}

			}
			if (!empty($upline_user) and empty($ref) ){ // check next/second upline
				if($prev_plan2 = \App\UserPlan::where(['user_id'=>$upline_user->id ])->orderBy('id', 'desc')->get()->first()){
					if($upline_user2 =  User::find($prev_plan2->upline_id) and $upline_user2->getSubscription($plan) ){
						// Upline in last sub has subscribed to be in the new plan already
						$ref =  $prev_plan2->upline_id;
					}
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

			$conditions = $plan->conditions()->where(['level'=>$i, 'plan_id' => $plan->id])
			                                 ->orderBy('condition_id', 'ASC')->get();
			//print json_encode($conditions);
			//if(is_array($conditions)){

				foreach($conditions/*->orderBy('order')->get()*/ as $condition){

					if( $u_suser->shouldSatisfy($condition, $i)){
						//print "{$condition->title} : {$condition->action} {$condition->min}//{$condition->limit}: {$condition->amount}\n";
						if($result = $u_suser->satisfy($this, $condition, $i)){
							if(!empty($result['amount'])){
								$total_amount -= $result['amount']; //subtract amount up_line received
							}
							//print $condition->title."\n";
							//var_dump($result);
						}

					}else{
						//print $condition->title."\n";
					}
				}
			//}


		}
		//var_dump($total_amount);

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
			$income = Income::create([
				'beneficiary'   => $name,
				'amount'        => $total_amount * $ratio,
				'description'   => 'Subscription: '.$plan->name
			]);
			if(!$income) return false;
		}
		return true;

	}

	public static function matrixLevel2($matrix,$level, User $upline, User $user, PlanCondition $planCondition){

		$max_size =self::countMatrix($level, $matrix);

		$value = self::log_matrix_income($upline, $user, $planCondition, $max_size)? true: false;

		//$upline->log_matrix($user, $planCondition,$level, $matrix);


		$downlines_l1 = self::get_downline($planCondition, $upline, 1)? : array();
		$downlines_l2 = array();
		$downlines_l2_complete_6 = array();
		//print json_encode($downlines_l1);
		//print count($downlines_l1);
		if(count($downlines_l1)){
			//print "ROund ++++ \n";
			foreach ($downlines_l1 as $index => $matrix_log){

				$downlines_l2[$index] =  self::get_downline($planCondition, $matrix_log->user, 1);
				if(count($downlines_l2[$index]) >= $matrix){
					//print count($downlines_l2[$index]);
					//print ": {$matrix} hello \n";
					$downlines_l2_complete_6[$index] = $downlines_l2[$index];
				}
			}
			$complete_count = count($downlines_l2_complete_6);
			//print ($complete_count)."\n"; die();
			if($complete_count >= $matrix){ // level complete
				$pay_logs = self::get_matrix_income($upline, $planCondition);
				foreach ($pay_logs as $i => $pay_log){
					//print number_format($pay_log->amount).' : '.$planCondition->title."\n";
					$upline->do_action($planCondition, $user, $pay_log->amount);
					$pay_log->status = 1;
					$pay_log->save();

					//end this condition
				}
				$upline->plan_conditions()->create([ 'plan_condition_id' => $planCondition->id]);
			}
		}

		return $value;
	}
	public function do_action(PlanCondition $planCondition, User $suscriber, $matrix_amount = 0){
		$data =  ['status' => false];
		$action = $planCondition->sub_action? : $planCondition->action;
		//print "{$planCondition->title} : {$planCondition->action}/({$planCondition->sub_action}) {$planCondition->min}//{$planCondition->limit}: {$planCondition->amount}\n";
		switch ($action) {
			case 'credit_account':
				if ( $planCondition->user_account_type_id and
				     $accountType = UserAccountType::find( $planCondition->user_account_type_id ) ) {
					$r = $this->accountTransaction(
						$accountType,
						$matrix_amount? :$planCondition->amount,
						"Earning from Downline ({$suscriber->username}) Upgrade to {$planCondition->plan->name} ",
						$planCondition->plan_id
					);
					$data = [ 'status' => true, 'amount' => $matrix_amount? 0 :$planCondition->amount ];
				}
				break;
			case 'credit_wallet':
				$this->creditWallet( $matrix_amount? :$planCondition->amount,
					"Earning from Downline ({$suscriber->username}) Upgrade to {$planCondition->plan->name} " );
				$data = [ 'status' => true, 'amount' => $matrix_amount? 0:$planCondition->amount ];
				break;
			case 'upgrade':
				//print 'dhdhdh';
				$user_subscription = $this->subscriptions()->orderBy( 'id', 'desc' )->first();

				if ( $user_subscription ) {
					$next_plan    = Plan::where( 'order', '>', $user_subscription->plan->order )->orderBy( 'order', 'asc' )->first();
					$accountType = UserAccountType::where( [ 'can_sub' => 1 ] )->get()->first();
					$user_account = $this->accounts()->where( [ 'can_sub' => 1 ] )->get()->first();

					//var_dump( $user_account->balance);
					if ( $next_plan and $next_plan->price <= $user_account->balance ) {
						$amount      = $next_plan->price;
						//$accountType = UserAccountType::find( $user_account->id );
						$this->accountTransaction(
							$accountType,
							-$amount,
							'Automatic Upgrade to ' . $next_plan->name,$next_plan->id
						);
						if($this->doSubscription( $next_plan )){
							//print 'OK';
						};
					}
				}
				$data = [ 'status' => true ];
				break;
			case 'credit_service_center':
				$service_center = $this->profile->serviceCenter;
				if ( $service_center and $planCondition->amount ) {
					$amount = $matrix_amount? :$planCondition->amount;
					$service_center_income = $service_center->income()->create( [
						'amount'      => $amount,
						'description' => 'Reward from member upgrade to ' . $planCondition->plan->name
					] );
					if ( $service_center_income ) {
						$data = [ 'status' => true, 'amount' => $matrix_amount? 0 :$planCondition->amount ];
					}
				}
				break;
				default: $data =  ['status' => true];
				break;


		}
		//print $planCondition->action." ====\n";
		return $data;
	}
	private function log_matrix(User $user, PlanCondition $plan_condition)
	{

		return MatrixLog::create([
			'user_id'   => $user->id,
			'upline_id' => $this->id,
			'plan_id' => $plan_condition->plan_id,
			'level' => $plan_condition->level
		]);
	}

	private static function check_matrix($plan_condition, $upline_id, $size) {
		$matrix = self::get_matrix($plan_condition, $upline_id);
		$count = count($matrix);
		if($count == $size){
			return $matrix;
		}
	}


	private static function get_matrix(PlanCondition $plan_condition,$upline_id){
		$first_upline_log = MatrixLog::where([
			'upline_id' => $upline_id,
			'plan_condition_id' => $plan_condition->id
		]);
	}

	private static function get_upline(PlanCondition $plan_condition,User $downline_id, $level=1){
		return MatrixLog::where([
			'user'      => $downline_id,
			'plan_id'   => $plan_condition->plan->id,
			'level'     => $level
		]);

	}

	private static function get_downline(PlanCondition $plan_condition,User $upline, $level=1){
		return MatrixLog::where([
			'upline_id' => $upline->id,
			'plan_id'   => $plan_condition->plan->id,
			'level'     => $level
		])->get();

	}


	private static function log_matrix_income(User $upline, User $user, PlanCondition $plan_condition, $max=0)
	{
		$matrix_income = self::get_matrix_income($upline, $plan_condition);
		//print ($max). "\n";
		if(count($matrix_income) >= $max){
			return null;
		}

		return MatricIncomes::create([
			'user_id'           => $user->id,
			'upline_id'         => $upline->id,
			'plan_condition_id' => $plan_condition->id,
			'amount'            => $plan_condition->amount,
			'action'            => $plan_condition->action,
		    'status'            => 0,
		]);
	}

	/**
	 * @param User $upline
	 * @param PlanCondition $plan_condition
	 *
	 * @return MatricIncomes
	 */
	private static function get_matrix_income(User $upline, PlanCondition $plan_condition)
	{
		$matrix_income = MatricIncomes::where(['upline_id' => $upline->id, 'plan_condition_id' => $plan_condition->id])->get();
		return $matrix_income;
	}

	private static function countMatrix($level=1, $size=0)
	{
		//print $level ^ $size;
		return $size**$level;
		$val = 1;
		for ($i=1; $i <=$level; $i++){
			$val *= $level;
			if($level== $i){
				//return $val;
			}
		}

		return 0;
	}
}
