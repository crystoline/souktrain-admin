
@include('admin.notification')
<div class="panel panel-default">
    <div class="panel-heading">
        <h3>Roles</h3>
    </div>
    <div class="panel-body">
        <div class="pull-right">

            <a href="{{ route('admin.role.create') }}" data-ajax="true" class="btn btn-xs btn-info">
                <i class="fa fa-plus-circle"></i> Create Role
            </a>
            <a href="{{ route('admin.role.index') }}" data-ajax="true" class="btn btn-xs btn-primary">
                <i class="fa fa-list"></i> Role List
            </a>
        </div>
        <form data-ajax="true" data-temp="true" method="post" action="{{ route('admin.role.update', ['role' => $role->id]) }}" style="max-width: 400px">
            {{ csrf_field() }}
            {{ method_field('PUT') }}

            <div class="form-group {{ $errors->has('name')? 'has-error': '' }}">
                <laable for="name">Name</laable>
                <input type="text" id="name" name="name" value="{{ $role->name }}" class="form-control">
                @if($errors->has('name'))
                    <span>{{ $errors->first('name') }}</span>
                @endif
            </div>

            <div class="form-group {{ $errors->has('display_name')? 'has-error': '' }}">
                <laable for="display_name">Display Name</laable>
                <input type="text" id="display_name" name="display_name" value="{{ $role->display_name }}" class="form-control">
                @if($errors->has('display_name'))
                    <span>{{ $errors->first('display_name') }}</span>
                @endif
            </div>
            <button class="btn btn-xs btn-primary"><i class="fa fa-save"></i> Submit</button>
        </form>
<hr>
        <h4>Permissions</h4>



            @php
                $groups = \App\Permission::groups();
                $role_permission_ids = $role->permissions->pluck('id')->toArray();

            @endphp
        @if($groups)
            <form method="post" data-ajax="true" action="{{ route('admin.role.permission.update', ['role' => $role->id]) }}">
                {{ csrf_field() }}

                <a for="checkbox_all" href="#"
                   onclick="$(this).closest('form').find('input').prop({checked: true}); return false">
                    <i class="fa fa-check"></i>
                    Check all
                </a>

                <div class="row">
                @foreach($groups as $group)
                        @php

                            $permissions = \App\Permission::groupPermissions($group->name);
                            $group_permission_ids = $permissions->pluck('id')->toArray();
                            $all_set = count(array_intersect($group_permission_ids, $role_permission_ids)) == count($group_permission_ids);
                        @endphp
                    <div class="col-md-4" style="min-height: 200px">
                        <fieldset style="margin-top: 20px">
                            <legend>

                                    <div class="checkbox checkbox-info">

                                    <input id="{{ $group->name }}" @if($all_set) checked @endif type="checkbox" onclick="$(this).closest('fieldset').find('input:checkbox').prop({'checked':$(this).prop('checked')})" >

                                        <label for="{{$group->name}}"><b>{{ strtoupper($group->name)}}</b></label>
                                    </div>

                            </legend>

                            @foreach($permissions as $permission)
                                <div class="checkbox checkbox-success">
                                    <input id="checkbox_{{ $permission->id }}"
                                           @if(in_array($permission->id, $role_permission_ids))
                                           checked
                                           @endif
                                           type="checkbox" value="{{ $permission->id }}" name="permissions[]">

                                    <label for="checkbox_{{ $permission->id }}">
                                        {{ $permission->name }}
                                    </label>
                                </div>

                            @endforeach
                        </fieldset>
                    </div>
                @endforeach
                </div>
                <button type="submit" class="btn btn-xs btn-danger pull-right"><i class="fa fa-lock"></i> Update Permissions</button>
            </form>
        @endif

    </div>
</div>
