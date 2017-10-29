

<div class="panel panel-default">
    <div class="panel-heading">
        <h3>Roles</h3>
    </div>
    <div class="panel-body">
        <div class="pull-right">

            <a href="{{ route('admin.role.index') }}" data-ajax="true" class="btn btn-xs btn-primary">
                <i class="fa fa-list"></i> Role List
            </a>
        </div>
        <form data-ajax="true" data-temp="true" method="post" action="{{ route('admin.role.store') }}" style="max-width: 400px">
            {{ csrf_field() }}

            <div class="form-group {{ $errors->has('name')? 'has-error': '' }}">
                <laable for="name">Name</laable>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control">
                @if($errors->has('name'))
                    <span>{{ $errors->first('name') }}</span>
                @endif
            </div>

            <div class="form-group {{ $errors->has('display_name')? 'has-error': '' }}">
                <laable for="display_name">Display Name</laable>
                <input type="text" id="display_name" name="display_name" value="{{ old('display_name') }}" class="form-control">
                @if($errors->has('display_name'))
                    <span>{{ $errors->first('display_name') }}</span>
                @endif
            </div>
            <button class="btn btn-xs btn-primary"><i class="fa fa-save"></i> Submit</button>
        </form>
    </div>
</div>
