

<div class="panel panel-default">
    <div class="panel-heading">
        <h3>Roles</h3>
    </div>
    <div class="panel-body">
        <div class="pull-right">

            <a href="{{ route('admin.role.create') }}" data-ajax="true" class="btn btn-xs btn-info">
                <i class="fa fa-plus-circle"></i> Create Role
            </a>
        </div>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Title</th>
                    <th>Users</th>
                    <th>Date Created</th>
                    <th>Date Modified</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as  $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->display_name }}</td>
                    <td>{{ $role->users->count() }}</td>
                    <td>{{ $role->created_at }}</td>
                    <td>{{ $role->updated_at }}</td>
                    <td>
                        <a data-ajax="true" href="{{ route('admin.role.edit', ['role' => $role->id]) }}" class="btn btn-xs btn-info">Edit</a>
                    </td>
                </tr>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
