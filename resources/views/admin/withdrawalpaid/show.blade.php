
<div class="row">
    <div class="col-md-5">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3>Withdrawals |Paid

                </h3>
            </div>

            <div class="panel-body">
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
                <a class="btn btn-lg btn-default" href="{{ route('admin.withdrawalpaid.index') }}" data-ajax="true">
                    <i class="fa fa-check-back-arrow"></i>
                    Back
                </a>

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