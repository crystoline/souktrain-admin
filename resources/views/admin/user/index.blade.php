

<div class="panel panel-default">
    <div class="panel-heading">
        <h3>Users</h3>

    </div>
    <div class="panel-body">
        <form action="{{ route('admin.user.index') }}" class="pull-right" data-ajax="true">
            {{ csrf_field() }}
            <label><input class="form-control" name="search" placeholder="" required value="{{ old('search') }}"></label>
            <button class="btn btn-info" type="submit"><i class="fa fa-search"></i> Find</button>
        </form>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Date Created</th>
                    <th>Date Modified</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as  $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ @$user->role->name }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>{{ $user->updated_at }}</td>
                    <td>
                        @if($user->profile)
                            <a data-ajax="true" href="{{ route('admin.profiles.show', ['profile' => $user->profile->id]) }}" class="btn btn-xs btn-info">View Profile</a>
                        @endif
                    </td>
                </tr>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div data-ajax-links="true">
            {{ $users->links() }}
        </div>
    </div>
</div>
