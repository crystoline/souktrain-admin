<?php

namespace App\Http\Controllers\Admin;
use App\UserAccountWithdraw;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class WithdrawalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$this->authorize('browse-user-account_withdraw', Withdrawal::class);

        //$withdrawals = DB::table('user_account_withdraw') ->where('status', 'pending')->get();
	    $withdrawals = UserAccountWithdraw::where('status', 0)->get();

        return view( 'admin.withdraw.index', [ 'withdrawals' => $withdrawals ] );
    }
    public function indexPaid(){

	    $withdrawals = UserAccountWithdraw::where('status', 1)->get();
	    //if(!$withdrawals) return redirect()->route('admin.withdrawal.index');
	    $this->authorize('browse-user-account_withdraw', Withdrawal::class);
	    return view( 'admin.withdrawalpaid.index', [ 'withdrawals' => $withdrawals ] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(UserAccountWithdraw $withdraw)
    {
	    //$withdraw = UserAccountWithdraw::find($id);
	    $this->authorize('view-user-account_withdraw', $withdraw);
	    return view( 'admin.withdrawalpaid.show', [ 'withdraw' => $withdraw ] );

    }


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param UserAccountWithdraw $withdraw
	 *
	 * @return \Illuminate\Http\Response
	 * @internal param int $id
	 */
    public function edit(Request $request, UserAccountWithdraw $account_withdraw)
    {
    	//dd($request);
	    //$account_withdraw = UserAccountWithdraw::find($id);
	    $this->authorize('update-user-account_withdraw', $account_withdraw);

	    return view( 'admin.withdraw.edit', ['withdraw'=> $account_withdraw] );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserAccountWithdraw $withdraw)
    {
    	//$withdraw = UserAccountWithdraw::find($id);
	    $this->authorize('update-user-account_withdraw', $withdraw);

	    // dd($withdraw->user);

	    $validator = Validator::make(
	        $request->only( [ 'details' ] ),
	        [
	            'details'  => 'required',
		        //'transaction_fee'  => 'required'
	        ]
	    );

        if ( $validator->fails() ) {
            return redirect()->route('admin.withdrawal.edit', ['withdraw' => $id])
                ->withErrors( $validator )
                ->withInput();
        }
        $trans_fee = $request->input('transaction_fee');

        $pay = $withdraw->update([
        	'status' => 1,
	        'details' => $request->input('details'),
	        'transaction_fee' => $trans_fee
        ]);

        if($trans_fee){
	        $withdraw->user->accountTransaction($withdraw->userAccountType ,$trans_fee,  "Transaction fee for { $withdraw->userAccountType->name} withdrawal");
        }

        return redirect()->route( 'admin.withdrawal.index' );
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
