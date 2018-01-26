<?php

namespace App\Http\Controllers;

use App\Profile;
use Illuminate\Http\Request;

class TestController extends Controller
{
    function index(){
        $profiles = Profile::get();
        print ($profiles->load('user'));
    }

    function user(){
        $profile = Profile::find(1);
        return $profile->load(['user.subscriptions', 'profileUpdate']);
    }
}
