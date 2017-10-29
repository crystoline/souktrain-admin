@include('admin.notification')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default card-view">
            <div class="panel-heading">
                <h3 class="panel-title txt-dark">Edit User ({{ $user->email }})</h3>
                <div class="pull-right">

                    <a href="{{ route('admin.user.index') }}" data-ajax="true" class="btn btn-xs btn-primary">
                        <i class="fa fa-list"></i> User Account
                    </a>
                </div>
            </div>
            <div class="panel-body">

                <form action="{{ route('admin.user.update', ['user' => $user->id]) }}" method="post" data-ajax="true" style="max-width: 400px">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="form-group{{ $errors->has('username')? 'has-error': '' }}">
                        <label>Username</label>
                        <input name="username" class="form-control" required value="{{ $user->username }}">
                        @if ($errors->has('username'))
                        <span class="help-block">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('email')? 'has-error': '' }}">
                        <label>Email</label>
                        <input name="email" class="form-control" required value="{{ $user->email }}">
                        @if ($errors->has('email'))
                            <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('role_id')? 'has-error': '' }}">
                        <label>Role</label>
                        <select name="role_id" class="form-control" required value="{{ $user->role_id }}">
                            @foreach(\App\Role::orderBy('name', 'ASC')->get() as $role)
                            <option @if($role->id == $user->role_id) selected @endif value="{{$role->id}}">{{ $role->display_name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('role_id'))
                            <span class="help-block">
                            <strong>{{ $errors->first('role_id') }}</strong>
                        </span>
                        @endif
                    </div>

                    <button class="btn btn-sm btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

