
@include('admin.notification')
<div class="panel panel-default">
    <div class="panel-heading">
        <h3>Settlements</h3>

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
                    <th>Name</th>
                    <th>Status</th>
                    <th>Amount</th>
                    <th>Date Created</th>
                    <th>Date Modified</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($settlements as $settlement)
                <tr>
                    <td>{{ $settlement->id }}</td>
                    <td>{{ $settlement->name }}</td>
                    <td><span class="label label-{{$settlement->statusToColor()}}">{{ $settlement->statusToString() }}</span></td>
                    <td>{{ number_format($settlement->settlementIncomes->sum('income.amount')) }}</td>
                    <td>{{ $settlement->created_at }}</td>
                    <td>{{ $settlement->updated_at }}</td>
                    <td>
                        <form data-ajax="true" data-temp="true" method="post" action="{{ route('admin.settlement.update', ['settlement' => $settlement->id]) }}">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                        @if($settlement->status == '-1')
                            <button type="submit" class="btn btn-xs btn-success" onclick="return confirm('Are you sure?')">
                                <i class="fa fa-check"></i> Approve</button>
                        @elseif($settlement->status == '0')
                                <button type="submit" class="btn btn-xs btn-primary" onclick="return confirm('Are you sure?')">
                                    <i class="fa fa-check"></i> Confirm</button>
                            @endif

                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div data-ajax-links="true">
            {{ $settlements->links() }}
        </div>
    </div>
</div>
