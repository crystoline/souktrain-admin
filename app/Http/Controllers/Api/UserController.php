<?php

namespace App\Http\Controllers\Api;

use App\Tools\Utility;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  Utility::json_success(
            User::get()->load([
                'subscriptions.plan',
                'subscriptions.userTree.upline.subscriptions.userTree.upline.subscriptions.userTree.upline.subscriptions.userTree.upline',
                'downTree.userPlan.user.downTree.userPlan.user.downTree.userPlan.user.downTree.userPlan.user',
                'downTree.userPlan.plan',
                'downTree.userPlan.user.downTree.userPlan.plan',
                'downTree.userPlan.user.downTree.userPlan.user.downTree.userPlan.plan',
                'downTree.userPlan.user.downTree.userPlan.user.downTree.userPlan.user.downTree.userPlan.plan',
            ])
        );
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
     * @param User $user
     * @return string
     */
    public function show(User $user)
    {

        $data =  $user->load([
            'profile', 'wallet','accounts','role',
            'subscriptions.plan',
            'subscriptions.upLine.subscriptions.upLine.subscriptions.upLine.subscriptions.upLine'
        ])->toArray();
        $data['down_line'] = $user->tree;
        return Utility::json_success($data);

        return  Utility::json_success($user->load([
            'profile', 'wallet','accounts','role',
            'subscriptions.plan',
            'subscriptions.userTree.upLine.subscriptions.userTree.upLine.subscriptions.userTree.upLine.subscriptions.userTree.upLine',

            //'subscriptions.upLine.subscriptions.upLine.subscriptions.upLine.subscriptions.upLine',
            //'subscriptions.downLine',
            'downTree.userPlan.user.downTree.userPlan.user.downTree.userPlan.user.downTree.userPlan.user',
            'downTree.userPlan.plan',
            'downTree.userPlan.user.downTree.userPlan.plan',
            'downTree.userPlan.user.downTree.userPlan.user.downTree.userPlan.plan',
            'downTree.userPlan.user.downTree.userPlan.user.downTree.userPlan.user.downTree.userPlan.plan',
        ]) );
        $user->load(['profile', 'wallet', 'accounts.accountHistories']);
        return  Utility::json_success($user );
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
}
