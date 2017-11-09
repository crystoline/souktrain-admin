<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
	use AuthenticatesUsers;

	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	protected $redirectTo = '/home';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->redirectTo = route('admin.dashboard');
		$this->middleware('guest')->except('logout');
	}
	public function showLoginForm()
	{
		return view('admin.login');
	}

	public function logout(Request $request)
	{
		$this->guard()->logout();

		$request->session()->flush();

		$request->session()->regenerate();

		return redirect()->route('admin.login');
	}
}
