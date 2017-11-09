<?php

namespace App\Providers;

use App\Permission;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $permissions = Permission::get();

	    foreach ($permissions as $permission)
	    {
		    Gate::define($permission->name, function(User $user, $model) use ($permission)
		    {

		    	if(!empty($model->user_id) and $user->id == $model->user_id){
		    		return true;
			    }
			    return $user->hasPermission($permission->name);
		    });
	    }

        //
    }
}
