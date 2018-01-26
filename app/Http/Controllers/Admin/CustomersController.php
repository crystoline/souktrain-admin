<?php

namespace App\Http\Controllers\Admin;

use App\Profile;
use Illuminate\Http\Request;

use App\Http\Controllers\Api\UserPlan;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
class CustomersController extends Controller
{
    //
    public function index() {
		$this->authorize('browse-user');
        $profiles = Profile::join('users', 'users.id', '=', 'profiles.user_id')
              ->select('profiles.*', 'users.email')
            ->orderBy( 'first_name', 'ASC' )
           ->paginate(100);
       // $profiles = Profile::orderBy( 'first_name', 'ASC' )->get();
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
       // $user_plan = new UserPlan();
       // $user_plan =   $user_plan->index(request()->segment(3));
        ;

        $profile_id = request()->segment(3);

         // dd($user_plan);
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
