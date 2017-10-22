

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
                    <th>Ref No</th>
                    <th>Email</th>
                    <th>Pin Collection</th>
                    <th>Count</th>
                    <th>Value/Cost </th>
                    <th>Total Value/Cost</th>
                    <th>Status</th>
                    <th>Date Created</th>
                   {{-- <th>Date Modified</th>--}}
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pin_requests as  $pin_request)
                    @php
                        $total_cost     =   $pin_request->count * $pin_request->cost;
                        $total_value    =   $pin_request->count * $pin_request->value;
                    @endphp
                <tr>
                    <th>{{ $pin_request->ref_no }}</th>
                    <th>{{ $pin_request->email }}</th>
                    <th>{{ @$pin_request->pinCollection->name }}</th>
                    <th>{{ $pin_request->count }}</th>
                    <th>{{ number_format($pin_request->value) }}/{{ number_format($pin_request->cost) }}</th>
                    <th>{{ number_format($total_value) }}/{{ number_format($total_cost) }}</th>
                    <th>{{ $pin_request->status? 'Complete': 'Pending' }}</th>
                    <th>{{ $pin_request->created_at }}</th>
                    {{--<th>{{ $pin_request->updated_at }}</th>--}}
                    <th>
                        @if($pin_request->status)
                            <form method="post" data-ajax="true" data-temp="true" action="{{ route('admin.pin-request.send', [ 'pin_request'=> $pin_request->id]) }}">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-success btn-xs" ><i class="fa fa-send-o"></i> Resend</button>
                            </form>
                        @else
                            <form method="post" data-ajax="true" data-temp="true" action="{{ route('admin.pin-request.update', [ 'pin_request'=> $pin_request->id]) }}">
                                {{ method_field('PUT') }}
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-info btn-xs" onclick="return confirm('Are you sure?')"><i class="fa fa-check"></i> Confirm</button>
                            </form>
                        @endif
                    </th>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div data-ajax-links="true">
            {{ $pin_requests->links() }}
        </div>
    </div>
</div>
<script>
    $(function () {
       @if($message = session('notify-msg'))
        swal('Success', '{{$message}}', 'success');
        @endif
    })
</script>