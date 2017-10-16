<?php

namespace App\Http\Controllers\Admin;

use App\Http\FileService;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){

        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $users = User::where('email', 'LIKE', "%$keyword%")
                ->orWhere('username', 'LIKE', "%$keyword%")
                ->paginate($perPage);
        } else {
            $users = User::paginate($perPage);
        }

        //$users->load('profile');
        return view('admin.user.index', compact('users'));
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user){
        $user->load('profile');
        return view('admin.user.show', ['user' => $user]);
    }

    public function create()
    {
	    $roles = Role::get();
        return view('admin.user.create', ['roles' => $roles]);
    }
	public function store(Request $request)
	{
		$this->validate($request, [
			'role_id' => 'required|exists:roles,id',
			//'name' => 'required|max:100|min:2',
			'email'  => 'required|email|unique:users,email',
			//'avatar' => 'required|max:100|min:2',
			'username' => 'required|unique:users,username',

	        'first_name' => 'required|max:100|min:2',
	        'last_name' => 'required|max:100|min:2',
	        'gender' => 'required|max:100|min:2',
		]);


		$profileDate =  $request->only(['gender', 'first_name', 'last_name']);
		$userData =  $request->only(['username', 'email', 'role_id']);
		$userData['password'] = bcrypt('password');

		if($file = $request->file('avatar')){
			$fileSaved = FileService::saveFile($file, 'public/images');
			$profileDate['picture_url'] = $fileSaved['name'];
			$userData['$userData'] = $fileSaved['name'];
		}

		$requestData = $request->all();
		$role = Role::find($request->input('role_id'));
		$role->users()->create($userData)->profile()->create($profileDate);

		Session::flash('flash_message', 'User was registered');

		return redirect()->route('admin.user');
	}
	public function edit(User $user)
	{
		$roles = Role::get();
		return view('admin.user.edit', compact(['user', 'roles']));
	}

	public function update(User $user, Request $request)
	{
		$this->validate($request, [
			'role_id' => 'required|exists:roles,id',
			//'name' => 'required|max:100|min:2',
			'email'  => 'required|email|unique:users,email,'.$user->id,
			//'avatar' => 'required|max:100|min:2',
			'username' => 'required|unique:users,username,'.$user->id,

			'first_name' => 'required|max:100|min:2',
			'last_name' => 'required|max:100|min:2',
			'gender' => 'required|max:100|min:2',
		]);
		$profileDate =  $request->only(['gender', 'first_name', 'last_name']);
		$userData =  $request->only(['username', 'email', 'role_id']);

		if($file = $request->file('avatar')){
			$fileSaved = FileService::saveFile($file, 'public/images');
			$profileDate['picture_url'] = $fileSaved['name'];
			$userData['$userData'] = $fileSaved['name'];
		}

		$user->profile()->update($profileDate);
		$user->update($userData);

		Session::flash('flash_message', 'User record was updated');

		return redirect()->route('admin.user');
	}
}
