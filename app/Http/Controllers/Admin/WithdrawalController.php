<?php

namespace App\Http\Controllers\Admin;
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
        $withdrawals = DB::table('user_account_withdraw') ->where('status', 'pending')->get();

        return view( 'admin.withdraw.index', [ 'withdrawals' => $withdrawals ] );
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
    public function show($id)
    {


    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $withdraw_id = request()->segment(3);
        // echo $withdraw_id;
        return view( 'admin.withdraw.edit', ['withdraw_id'=> $withdraw_id] );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)

    {   $validator = Validator::make(
        $request->only( [ 'details' ] ),
        [
            'details'  => 'required'

        ]
    );

        if ( $validator->fails() ) {
            return redirect()->route('admin.withdrawal.edit', ['withdraw' => $id])
                ->withErrors( $validator )
                ->withInput();
        }

     echo  $id = request()->segment(3);
       $pay = DB::table('user_account_withdraw')
            ->where('id', $id)
            ->update(['status' => 'paid','details' => $request->details,'updated_at' =>date("Y-m-d H:i:s")]);
       var_dump($pay);
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
