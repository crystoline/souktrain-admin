<?php

namespace App\Http\Controllers\Admin;

use App\Plan;
use App\PlanCondition;
use App\UserAccountType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PlanConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$this->authorize('browse-plan_condition', PlanCondition::class);
	    $plans_condition  = PlanCondition::orderBy('plan_id', 'ASC')
	                                     ->orderBy('level', 'ASC')
	                                     ->with(['plan', 'userAccountType'])->get();

        return view('admin.plan-condition.index', ['plans_conditions' => $plans_condition]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
	    $this->authorize('create-plan_condition', PlanCondition::class);

        return view('admin.plan-condition.create', [
        	'plans'         => Plan::orderBy('name', 'ASC')->get(),
	        'account_types' => UserAccountType::orderBy('name', 'ASC')->get(),
	        'conditions'    => PlanCondition::orderBy('plan_id', 'ASC')->orderBy('level', 'ASC')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	    $this->authorize('create-plan_condition', PlanCondition::class);

	    $validator = Validator::make(
		    $request->all( ),
		    [
			    'title'  => 'required|unique:plan_conditions,title',
			    'plan_id' => 'required',
			    'level' => 'required',
			    'min' => 'required',
			    'limits' => 'required',
			    'action' => 'required',
		    ]
	    );

	    if ( $validator->fails() ) {
		    return redirect()->route( 'admin.plan-condition.create' )
		                     ->withErrors( $validator )
		                     ->withInput();
	    }

	    $cond = PlanCondition::create($request->all());

	    return redirect()->route('admin.plan-condition.index');

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
    public function edit(PlanCondition $plan_condition)
    {
	    $this->authorize('update-plan_condition', $plan_condition);

	    return view('admin.plan-condition.edit', [
		    'plans'         => Plan::orderBy('name', 'ASC')->get(),
		    'account_types' => UserAccountType::orderBy('name', 'ASC')->get(),
		    'conditions'    => PlanCondition::orderBy('plan_id', 'ASC')->orderBy('level', 'ASC')->get(),
		    'plan_condition' => $plan_condition
	    ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PlanCondition $plan_condition)
    {
	    $this->authorize('update-plan_condition', $plan_condition);
	    $validator = Validator::make(
		    $request->all( ),
		    [
			    'title'  => 'required|unique:plan_conditions,title,'.$plan_condition->id,
			    'plan_id' => 'required',
			    'level' => 'required',
			    'limits' => 'required',
			    'action' => 'required'
		    ]
	    );

	    if ( $validator->fails() ) {
		    return redirect()->route( 'admin.plan-condition.edit', [ 'plan_condition' => $plan_condition->id] )
		                     ->withErrors( $validator )
		                     ->withInput();
	    }

	    $cond = $plan_condition->update($request->all());

	    return redirect()->route('admin.plan-condition.index');
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
