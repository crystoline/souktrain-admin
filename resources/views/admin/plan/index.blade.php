

<div class="panel panel-default">
    <div class="panel-heading">
        <h3>Plans
            <a href="{{ route('admin.plan.create') }}" data-ajax="true" class="btn btn-primary pull-right">
                <i class="fa fa-plus"></i> Create Plan
            </a>
        </h3>

    </div>
    <div class="panel-body">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Date Created</th>
                    <th>Date Modified</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($plans as $plan)
                <tr>
                    <th>{{ $plan->order }}</th>
                    <th>{{ $plan->name }}</th>
                    <th>{{ number_format($plan->price, 2) }}</th>
                    <th>{{ $plan->created_at }}</th>
                    <th>{{ $plan->updated_at }}</th>
                    <th> <a class="btn btn-xs btn-info" href="{{ route('admin.plan.edit', ['plan' => $plan->id]) }}" data-ajax="true">
                            <i class="fa fa-edit"></i>
                            edit
                        </a> </th>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    $(function () {
       @if($message = session('notify-msg'))
        swal('Success', '{{$message}}', 'success');
        @endif
    })
</script>