<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get( '/cmdtool', [ 'as' => 'cmdtool', 'uses' => 'CmdToolController@index' ] );
Route::post( '/cmdtool', [ 'uses' => 'CmdToolController@exec' ] );


Route::get('/testtest', "TestController@index");


//Auth::routes();
// Password Reset Routes...
Route::post('password/email', [ 'as' => 'password.email', 'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail' ]);
Route::get('password/reset', [ 'as' => 'password.request', 'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm' ]);
Route::post('password/reset', [ 'as' => '', 'uses' => 'Auth\ResetPasswordController@reset' ]);
Route::get('password/reset/{token}', [ 'as' => 'password.reset', 'uses' => 'Auth\ResetPasswordController@showResetForm' ]);

// Registration Routes...
Route::get('register', [ 'as' => 'register', 'uses' => 'Auth\RegisterController@showRegistrationForm' ]);
Route::post('register', [ 'as' => '', 'uses' => 'Auth\RegisterController@register' ]);
Route::get('login', [ 'as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm' ]);
Route::post('login', [ 'as' => 'login.post', 'uses' => 'Auth\LoginController@login' ]);
Route::any('logout', [ 'as' => 'logout', 'uses' => 'Auth\LoginController@logout' ]);


Route::get('/test2', "TestController@user");
Route::get('/home', 'HomeController@index')->name('home');



Route::group(['prefix' => '/_7admin', 'namespace' => 'Admin', 'as' => 'admin.'], function (){

	Route::get('login', [ 'as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm' ]);
	Route::post('login', [ 'as' => 'login.post', 'uses' => 'Auth\LoginController@login' ]);
	Route::any('logout', [ 'as' => 'logout', 'uses' => 'Auth\LoginController@logout' ]);

	Route::group(['middleware'=> [\App\Http\Middleware\AdminOnlyMiddleware::class ]], function (){
		Route::get('/', [ 'uses' => "DashboardController@index", 'as' => 'dashboard']);

		Route::post('role/permission/{role}', [
				'uses' => 'RoleController@updatePermissions',
				'as' => 'role.permission.update'
		]);
		Route::resource('role', 'RoleController');
		Route::resource('user', 'UserController');
		Route::resource('plan', 'PlanController');
		Route::resource('plan-condition', 'PlanConditionController');
		Route::get('/income/owner/{owner}', ['uses' => 'IncomeController@ownerIncome', 'as' => 'income.owner']);
		Route::post('/income/{owner}/settlement/create', ['uses' => 'IncomeController@makeSettlement', 'as' => 'income.settlement.create']);
		Route::resource('income', 'IncomeController');
		Route::resource('settlement', 'SettlementController');
		Route::get('withdrawal-paid', 'WithdrawalController@indexPaid')->name('withdrawalpaid.index');
		Route::resource('withdrawal', 'WithdrawalController');
		Route::resource('profiles', 'CustomersController');
		Route::resource('service_center', 'ServiceCenterController');
		Route:: resource('pin-request', 'PinRequestController');
		Route:: post('pin-request/{pin_request}/send', 'PinRequestController@send')->name('pin-request.send');
	});

});

Route::group(['prefix' => 'agent', 'namespace' => 'Agent', 'as' => 'agent.'] , function (){
	Route:: resource('pin-request', 'PinRequestController');
});

