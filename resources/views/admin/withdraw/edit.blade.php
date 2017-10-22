
<div class="row">
    <div class="col-md-12">
<div class="panel panel-default">
    <div class="panel-heading">
        <h3>Withdrawals | Unpaid

        </h3>

    </div>

    <div class="panel-body">

        <div class="row">
            <div class="col-md-6">
                <table class="table  table-hover table-bordered table-striped" >
                    <tr> <th>Name:</th><td> {{ @$withdraw->user->profile->first_name }} {{ @$withdraw->user->profile->last_name }}</td></tr>
                    <tr><th> Amount:</th><td> {{ number_format($withdraw->amount) }}</td></tr>
                    <tr><th>Transaction Fees:</th><td> {{ @$withdraw->transaction_fees}}</td></tr>
                    <tr><th> Account Name:</th><td> {{ @$account_info->account_name }}</td></tr>
                    <tr><th> Bank:</th><td>{{ @$withdraw->user->profile->accountInfo->bank }}</td></tr>
                    <tr><th>Account No:</th><td> {{ @$withdraw->user->accountInfo->account_no }}</td></tr>
                    <tr><th> Account type: </th><td>{{ @$withdraw->user->accountInfo->acc_type }}</td></tr>
                    <tr><th>Date Updated:</th><td>{{ $withdraw->updated_at }}</td></tr>
                    <tr><th>Date Created:</th><td>{{  $withdraw->created_at }}</td></tr>


                </table>
            </div>
            <div class="col-md-6">
                <form action="{{ route('admin.withdrawal.update',['withdraw_id' => $withdraw->id]) }}" method="post" data-ajax="true">

                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="form-group{{ $errors->has('transaction_fee')? 'has-error': '' }}">
                        <label>Brief Payment Details</label><br>
                        <input type="number" max="200" min="0" name="transaction_fee" placeholder="Enter Transaction fee" class="form-control" value="{{ old('transaction_fee')? : 0 }}">
                        @if ($errors->has('transaction_fee'))
                            <span class="help-block">
                                <strong>{{ $errors->first('transaction_fee') }}</strong>
                            </span>
                        @endif
                    </div>

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