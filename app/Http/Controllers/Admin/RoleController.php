<?php

namespace App\Http\Controllers\Admin;

use App\Permission;
use App\Plan;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
	public function __construct() {
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	    $this->authorize('browse-role', Role::class);
        return view('admin.role.index', ['roles' => Role::orderBy('name', 'ASC')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
	    $this->authorize('create-role', Role::class);
        return view('admin.role.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	    $this->authorize('create-role', Role::class);
	    $validator =  Validator::make($request->all(),[
		    'name'          => 'required|unique:roles,name',
		    'display_name'  => 'required'
	    ]);

	    if($validator->fails()){
		    return redirect()->route('admin.role.create')
		                     ->withErrors($validator)->withInput();
	    }
	    $role = Role::create( $request->only( [ 'name', 'display_name']) );

	    session()->flash('message', $role->display_name.': Role was updated');
	    return redirect()->route('admin.role.edit', ['role'=> $role->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
	    $this->authorize('update-role', $role);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
	    $this->authorize('update-role', $role);
    	//dd(Permission::groupPermissions(''));
        return view('admin.role.edit', ['role' => $role]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
	    $this->authorize('update-role', $role);

	    $validator =  Validator::make($request->all(),[
		    'name'          => 'required|unique:roles,name,'.$role->id,
		    'display_name'  => 'required'
	    ]);

	    if($validator->fails()){
		    return redirect()->route('admin.role.edit', ['role'=> $role->id])
		                     ->withErrors($validator)->withInput();
	    }
	    $role->update( $request->only( [ 'name', 'display_name']) );

	    session()->flash('message', $role->display_name.': Role was updated');
	    return redirect()->route('admin.role.edit', ['role'=> $role->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
	    $this->authorize('delete-role', $role);
    }


	/**
	 * @param Request $request
	 * @param Role $role
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
    public function updatePermissions(Request $request, Role $role){
	    $this->authorize('update-role', $role);

    	$validator =  Validator::make($request->all(),[
		    //'permissions' => 'required',
		    'permissions.*'=> 'exists:permissions,id'
	    ]);

    	if($validator->fails()){
    		return redirect()->route('admin.role.edit', ['role'=> $role->id])
			    ->withErrors($validator)->withInput();
	    }
		//dd($request->input('permissions'));
	    $role->permissions()->sync($request->input('permissions'));

    	session()->flash('message', $role->name.': Permissions were updated');
	    return redirect()->route('admin.role.edit', ['role'=> $role->id]);
    }
//	protected function resourceAbilityMap()
//	{
//		return [
//			'index' => 'browse',
//			'show' => 'view',
//			'create' => 'create',
//			'store' => 'create',
//			'edit' => 'update',
//			'update' => 'update',
//			'updatePermissions' =>'update',
//			'destroy' => 'delete',
//		];
//	}

}
