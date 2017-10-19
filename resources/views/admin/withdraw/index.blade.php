

<div class="panel panel-default">
    <div class="panel-heading">
        <h3>Withdrawals | Unpaid

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
                 <?php $profile = DB::table('profiles')->where('user_id', $withdraw->user_id)->first();
               $user_acount_types = DB::table('user_account_types')->where('id', $withdraw->user_account_type_id)->first();
                 $account_info = DB::table('account_info')->where('user_id', $withdraw->user_id)->first();
                 if (!isset($account_info) or !isset($user_acount_types) or !isset($profile) or
                     $account_info === NULL or  $user_acount_types === NULL or  $profile === NULL  ){
                     echo'<div class="alert alert-danger">You must have </div>';
                     return ;
                 }
                 ?>
                <tr>
                    <th>{{ $i++ }}</th>
                    <th><?php echo $profile->first_name .''. $profile->last_name ?></th>
                    <th>{{ $user_acount_types->name }}</th>
                    <th>{{ $withdraw->amount }} </th>
                    <th>{{ $withdraw->transaction_fees }}   </th>
                    <th>{{ $withdraw->status }}  </th>
                    <th>{{ $account_info->account_name  }}   </th>
                    <th>{{  $account_info->acc_type  }}  </th>
                    <th>{{ $account_info->bank }}   </th>
                    <th>{{ $account_info->account_no  }}  </th>
                    <th>{{ $withdraw->updated_at }}   </th>
                    <th>{{  $withdraw->created_at }}  </th>


                    <th> <a class="btn btn-xs btn-info" href="{{ route('admin.withdrawal.edit', ['withdraw' => $withdraw->id]) }}" data-ajax="true">
                                                  pay
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