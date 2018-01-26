

<div class="panel panel-default">
    <div class="panel-heading">
        <h3>Plans Conditions
            <a href="{{ route('admin.plan-condition.create') }}" data-ajax="true" class="btn btn-primary pull-right">
                <i class="fa fa-plus"></i> Create Plan Condition
            </a>
        </h3>

    </div>
    <div class="panel-body">
        <table class="table table-striped table-hover" id="datatable-plan-cond">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Plan/Title</th>
                    <th>Condition</th>
                    <th>Generation</th>
                    <th>Limits</th>
                    <th>Event</th>
                    <th>Amount</th>
                    <th>Account Type</th>
                    <th>Date Created</th>
                    <th>Date Modified</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($plans_conditions as $i =>  $plans_condition)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $plans_condition->plan->name }} - {{ $plans_condition->title }}</td>

                    <td>{{ $plans_condition->condition? $plans_condition->condition->title: 'None'}}</td>
                    <td>{{ $plans_condition->level }}</td>
                    <td>
                        @if(!$plans_condition->min and !$plans_condition->limits)
                            Unlimited
                        @else
                            {{ $plans_condition->min }} to {{ $plans_condition->limits? : 'Unlimited' }}
                        @endif
                    </td>
                    <td>{{ $plans_condition->action }} {{ $plans_condition->sub_action? "->".$plans_condition->sub_action: "" }}</td>
                    <th>{{ number_format($plans_condition->amount, 2) }}</th>
                    <td>{{ @$plans_condition->userAccountType->name? : (($plans_condition->action == 'credit_wallet')? 'Wallet' : '-')}}</td>
                    <th>{{ $plans_condition->created_at }}</th>
                    <th>{{ $plans_condition->updated_at }}</th>
                    <th> <a class="btn btn-xs btn-info" href="{{ route('admin.plan-condition.edit', ['plan_condition' => $plans_condition->id]) }}" data-ajax="true">
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

        $('#datatable-plan-cond').DataTable({ "lengthChange": false});
    })
</script>