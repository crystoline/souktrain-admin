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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.role.index', ['roles' => Role::orderBy('name', 'ASC')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
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
    public function destroy($id)
    {
        //
    }


	/**
	 * @param Request $request
	 * @param Role $role
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
    public function updatePermissions(Request $request, Role $role){

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
}
