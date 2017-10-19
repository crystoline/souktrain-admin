
<div class="row">
    <div class="col-md-5">
<div class="panel panel-default">
    <div class="panel-heading">
        <h3>Withdrawals | Unpaid

        </h3>
   <?php $withdraw = DB::table('user_account_withdraw')->where('id',$withdraw_id)->first();
        $user_id = $withdraw->user_id;
        $profile = DB::table('profiles')->where('user_id', $user_id)->first();

        $user_acount_types = DB::table('user_account_types')->where('id', $withdraw->user_account_type_id)->first();
        $account_info = DB::table('account_info')->where('user_id', $withdraw->user_id)->first();
       ?>

    </div>

    <div class="panel-body">

            <form action="{{ route('admin.withdrawal.update',['withdraw_id' => $withdraw->id]) }}" method="post" data-ajax="true">
                <table class="table  table-hover" >
                    <tr> <th>Name:</th><td> {{ $profile->first_name }} {{ $profile->last_name }}</td></tr>
                    <tr><th> Amount:</th><td> {{ $withdraw->amount}}</td></tr>
                    <tr><th>Transaction Fees:</th><td> {{ $withdraw->transaction_fees}}</td></tr>
                    <tr><th> Account Name:</th><td> {{ $account_info->account_name }}</td></tr>
                    <tr><th> Bank:</th><td>{{ $account_info->bank }}</td></tr>
                    <tr><th>Account No:</th><td> {{ $account_info->account_no }}</td></tr>
                    <tr><th> Account type: </th><td>{{ $account_info->acc_type }}</td></tr>
                    <tr><th>Date Updated:</th><td>{{ $withdraw->updated_at }}</td></tr>
                    <tr><th>Date Created:</th><td>{{  $withdraw->created_at }}</td></tr>


                </table>
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="form-group{{ $errors->has('details')? 'has-error': '' }}">
                    <label>Brief Payment Details</label><br>
                    <textarea name="details" placeholder="Write details of transaction." class="form-control" style="background-color: lightyellow; color: darkgrey"></textarea>
                    @if ($errors->has('details'))
                        <span class="help-block">
                                <strong>{{ $errors->first('details') }}</strong>
                            </span>
                    @endif
                </div>

       <button class="btn btn-default btn-lg"><i class="fa fa-money"></i> Pay </button>
            </form>

</div>
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