<?php

namespace App\Http\Controllers\Admin;

use App\Plan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PlanController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$this->authorize('browse-plan', Plan::class);
		$plan = Plan::orderBy( 'order', 'ASC' )->get();
		///session()->flush();
		return view( 'admin.plan.index', [ 'plans' => $plan ] );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$this->authorize('create-plan', Plan::class);

		return view( 'admin.plan.create' );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( Request $request ) {
		$this->authorize('create-plan', Plan::class);

		$validator = Validator::make(
			$request->only( [ 'name', 'price', 'order' ] ),
			[
				'name'  => 'required|unique:plans,name',
				'price' => 'required',
				'order' => 'required'
			]
		);

		if ( $validator->fails() ) {
			return redirect()->route( 'admin.plan.create' )
			                 ->withErrors( $validator )
			                 ->withInput();
		}

		$plan = Plan::create( $request->only( [ 'name', 'price', 'order' ] ) );

		session()->flash( 'notify-msg', 'plan was created' );

		return redirect()->route( 'admin.plan.index' );

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show( Plan $plan ) {
		$this->authorize('view-plan', $plan);

		return view('admin.plan.show', ['plan' => $plan]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit( Plan $plan ) {
		$this->authorize('update-plan', $plan);

		return view('admin.plan.edit', ['plan' => $plan]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( Request $request,  Plan $plan ) {

		$this->authorize('update-plan', $plan);

		$validator = Validator::make(
		$request->only( [ 'name', 'price', 'order' ] ),
			[
				'name'  => 'required|unique:plans,name,'.$plan->id,
				'price' => 'required',
				'order' => 'required'
			]
		);

		if ( $validator->fails() ) {
			return redirect()->route( 'admin.plan.edit', ['plan' => $plan->id] )
			                 ->withErrors( $validator )
			                 ->withInput();
		}

		$plan->update( $request->only( [ 'name', 'price', 'order' ] ) );
		session()->flash( 'notify-msg', 'plan was updateded' );

		return redirect()->route( 'admin.plan.index' );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( $id ) {
		//
	}
}
