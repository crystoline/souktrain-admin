<?php

namespace App\Http\Controllers\Admin;

use App\Income;
use App\Settlement;
use App\SettlementIncome;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$this->authorize('browse-income', Income::class);
    	return view('admin.income.index');
        //return json_encode(Income::get());
    }


    public function ownerIncome($owner)
    {
	    return view('admin.income.owner',[
	    	'incomes'   => Income::where('beneficiary', $owner)
		                   ->whereNotIn('id', SettlementIncome::get()->pluck('income_id'))
		                   ->paginate(100),
		    'owner'     => $owner
		 ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

    public function makeSettlement(Request $request, $owner)
    {
	    $this->authorize('manage-income', Income::class);
    	$data = ($request->input('income_ids'));
    	//dd($data);
		$validator= Validator::make($request->all(), [
			'income_ids' => 'required',
			'income_ids.*income_id' => 'exists:incomes,id',
		],[
			'exists' => ':value does not exists'
		]);

		if($validator->fails()){
			return redirect()->route('admin.income.owner', ['owner' => $owner])->withErrors($validator)->withInput();
		}

		$settlement =  Settlement::create([
			'name' => $owner.' - '.date('Y-m-d H:i:s'),
			//'status' => '-1'
		]);
		$settlement->settlementIncomes()->createMany($data );

	    session()->flash('message', 'Settlement was created');
	    return redirect()->route('admin.income.owner', ['owner' => $owner]);
    }
}
