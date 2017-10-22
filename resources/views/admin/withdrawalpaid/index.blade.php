

<div class="panel panel-default">
    <div class="panel-heading">
        <h3>Withdrawals | Paid

        </h3>
        <?php //var_dump( $withdrawals)?>

    </div>
    <div class="panel-body">
        <table class="table table-striped table-hover" id="datatable-plan-cond">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Acconut type</th>
                <th>Amount</th>
                <th>Transaction fees</th>
                <th>Status</th>
                <th>Account Name</th>
                <th>Account Type</th>
                <th>Bank</th>
                <th>Account no</th>
                <th>Date Editted </th>
                <th>Date Created </th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
		    <?php $i = 1;
		    //var_dump($profiles);?>
            @foreach($withdrawals as $withdraw)
            <tr>
                <th>{{ $i++ }}</th>
                <th><?php echo $withdraw->user->profile->first_name .''. $withdraw->user->profile->last_name ?></th>
                <th>{{ @ $withdraw->userAccountType->name }}</th>
                <th>{{ $withdraw->amount }} </th>
                <th>{{ $withdraw->transaction_fees }}   </th>
                <th>{{ $withdraw->status? 'Completed' : 'Pending' }}  </th>
                <th>{{@$withdraw->user->profile->accountInfo->account_name  }}   </th>
                <th>{{ @$withdraw->user->profile->account_info->acc_type  }}  </th>
                <th>{{ @$withdraw->user->profile->account_info->bank }}   </th>
                <th>{{ @$withdraw->user->profile->account_info->account_no  }}  </th>
                <th>{{ $withdraw->updated_at }}   </th>
                <th>{{  $withdraw->created_at }}  </th>

                <th> <a class="btn btn-xs btn-info" href="{{ route('admin.withdrawalpaid.show', ['withdraw_id' => $withdraw->id]) }}" data-ajax="true">
                        <i class="fa fa-check-folder"></i>
                        view
                    </a>
                </th>
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