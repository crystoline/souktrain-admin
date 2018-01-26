<?php

namespace App\Http\Controllers\Admin;

use App\Settlement;
use App\SettlementIncome;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettlementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	    $this->authorize('browse-settlement', Settlement::class);

	    return view('admin.settlement.index', [
        	'settlements' => Settlement::orderBy('status', 'ASC')->paginate(100)
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
    public function update(Request $request, Settlement $settlement)
    {
	    $this->authorize('update-settlement', $settlement);
        switch ($settlement->status){
	        case '-1' : $settlement->status = '0'; break;
	        case '0' : $settlement->status = '1'; break;
        }
        if($settlement->isDirty()){
        	$settlement->save();
        }
        session()->flash('message', "Settlement {$settlement->name} Status changed");
        return redirect()->route('admin.settlement.index');
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
