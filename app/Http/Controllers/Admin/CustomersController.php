<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Profile;
use App\Http\Controllers\Controller;

class CustomersController extends Controller
{
    //
    public function index() {
        $profiles = Profile::orderBy( 'first_name', 'ASC' )->get();
        return view( 'admin.profile.index', [ 'profiles' => $profiles] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request ) {


    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
    $profile_id = request()->segment(3);

       return view('admin.profile.show', ['profile_id' => $profile_id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit( $id ) {

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