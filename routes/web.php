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

Auth::routes();

Route::get('/testtest', "TestController@index");

Route::get('/test2', "TestController@user");
Route::get('/home', 'HomeController@index')->name('home');



Route::group(['prefix' => '/_7admin', 'namespace' => 'Admin', 'as' => 'admin.'], function (){
	Route::get('/', [ 'uses' => "DashboardController@index", 'as' => 'dashboard']);

	Route::post('role/permission/{role}', ['uses' => 'RoleController@updatePermissions', 'as' => 'role.permission.update']);
	Route::resource('role', 'RoleController');

	Route::resource('user', 'UserController');

	Route::resource('plan', 'PlanController');
	Route::resource('plan-condition', 'PlanConditionController');

	Route::get('/income/owner/{owner}', ['uses' => 'IncomeController@ownerIncome', 'as' => 'income.owner']);
	Route::post('/income/{owner}/settlement/create', ['uses' => 'IncomeController@makeSettlement', 'as' => 'income.settlement.create']);
	Route::resource('income', 'IncomeController');

	Route::resource('settlement', 'SettlementController');
	Route::resource('withdrawal', 'WithdrawalController');
    Route::resource('withdrawalpaid', 'WithdrawlPaidController');
    Route::resource('profiles', 'CustomersController');
    Route::resource('service_center', 'ServiceCenterController');

	Route:: resource('pin-request', 'PinRequestController');
	Route:: post('pin-request/{pin_request}/send', 'PinRequestController@send')->name('pin-request.send');

});

Route::group(['prefix' => 'agent', 'namespace' => 'Agent', 'as' => 'agent.'] , function (){

	Route:: resource('pin-request', 'PinRequestController');
});

