<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::any('/auth', function (Request $request){
	$username = $request->input('username');
	$password = $request->input('password');
	$user = \App\User::where('email', $username)->orWhere('username', $username)->get()->first();

	$response = [];

	if($username and  $user and \Illuminate\Support\Facades\Hash::check($password, $user->password)){
		$response = [
			'username' => $username,
			'token'     => $user->api_token
		];

	}

	return response()->json($response)->header('Access-Control-Allow-Origin','*');

});


Route::get('/route',function(){

	$routes= (array) app('router')->getRoutes();
	//dd($routes["\x00*\x00actionList"]);

	$myApiRoute = [];
	foreach($routes["\x00*\x00actionList"] as $action => $item){
		if (strpos($action,'App\Http\Controllers\Api' ) > -1){
			$myApiRoute[$action] = $item;
		}
	}
	//dd($myApiRoute);
	return view('api.route', ['myApiRoute' => $myApiRoute]);
});


Route::group(['namespace'=>'Api', /*'middleware' => ['auth:api']*/],function() {
	//Route::get('/users', ['as' => 'api.users', 'uses' => 'UserController@index']);

	Route::group(['prefix' => '/users/{user}/', 'middleware' => [App\Http\Middleware\Api\UserMiddleware::class] ], function () {
		Route::get('/', ['as' => 'api.user', 'uses' => 'UserController@show']);
		Route::get('/wallet', ['as' => 'api.user.wallet', 'uses' => 'UserWalletController@show']);
		Route::get('/wallet/history', ['as' => 'api.user.wallet.history', 'uses' => 'UserWalletController@history']);
		Route::post('/wallet/fund', ['as' => 'api.user.wallet.fund', 'uses' => 'UserWalletController@fund']);//post
		Route::post('/wallet/fund-transfer', ['as' => 'api.user.wallet.transfer', 'uses' => 'UserWalletController@transfer']);

		Route::get('/accounts', ['as' => 'api.user.wallet', 'uses' => 'UserAccountController@index']);
		Route::get('/account/view/{type}', ['as' => 'api.user.account.view', 'uses' => 'UserAccountController@show']);
		Route::get('/account/history/{type}', ['as' => 'api.user.account.history', 'uses' => 'UserAccountController@history']);
		Route::post('/account/fund-transfer', ['as' => 'api.user.account.transfer', 'uses' => 'UserAccountController@transfer']);

		Route::get('/plan', ['as' => 'api.user.plan', 'uses' => 'UserPlan@index']);
		Route::post('/plan/subscribe', ['as' => 'api.user.plan.subscribe', 'uses' => 'UserPlan@subscribe']); //post
		Route::get('/plan/{plan}/down-line', ['as' => 'api.user.plan.down-line', 'uses' => 'UserPlan@downLine']);Route::get('/plan/{plan}/down-line2', ['as' => 'api.user.plan.down-line2', 'uses' => 'UserPlan@downLine2']);
		Route::get('/plan/{plan}/up-line', ['as' => 'api.user.plan.up-line', 'uses' => 'UserPlan@upLine'])->where(['user' => '[0-9]+']);

	});
	Route::post('store/payment', 'StoreController@payment');
});

Route::any('/dump',function(Request $request){
	return json_encode($request->all());
});

