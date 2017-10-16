<?php

namespace App\Http\Controllers\Api;

use App\Plan;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlanController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
     * @param Request $request
     * @param User $user
     * @param Plan $plan
     */
    public function subscribe(Request $request, User $user, Plan $plan){
        
    }
}
