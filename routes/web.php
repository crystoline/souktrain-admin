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

//Route::get('/_7admin', "Admin\DashboardController@index");

Route::get('/home', 'HomeController@index')->name('home');



Route::group(['prefix' => '/_7admin', 'namespace' => 'Admin', 'as' => 'admin.'], function (){
	Route::get('/', [ 'uses' => "DashboardController@index", 'as' => 'dashboard']);

	Route::resource('plan', 'PlanController');
	Route::resource('plan-condition', 'PlanConditionController');

	Route::resource('income', 'IncomeController');
	Route::resource('settlement', 'SettlementController');
	Route::resource('withdrawal', 'WithdrawalController');
    Route::resource('withdrawalpaid', 'WithdrawlPaidController');
    Route::resource('profiles', 'CustomersController');
    Route::resource('service_center', 'ServiceCenterController');

});

