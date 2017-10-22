

<div class="panel panel-default">
    <div class="panel-heading">
        <h3>Income
        </h3>

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
                </tr>
            </thead>
            <tbody>
                @foreach($users as  $user)
                <tr>
                    <th>{{ $user->id }}</th>
                    <th>{{ $user->username }}</th>
                    <th>{{ $user->email }}</th>
                    <th>{{ @$user->role->name }}</th>
                    <th>{{ $user->created_at }}</th>
                    <th>{{ $user->updated_at }}</th>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div data-ajax-links="true">
            {{ $users->links() }}
        </div>
    </div>
</div>
