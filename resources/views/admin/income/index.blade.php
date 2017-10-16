

<div class="panel panel-default">
    <div class="panel-heading">
        <h3>Income
        </h3>

    </div>
    <div class="panel-body">
        <table class="table table-striped table-hover">
            <thead>
                <tr>

                    <th><input type="checkbox" class="check-all"></th>
                    <th>ID</th>
                    <th>Beneficiary</th>
                    <th>Amount</th>
                    <th>Description</th>
                    <th>Date Created</th>
                    <th>Date Modified</th>
                </tr>
            </thead>
            <tbody>
                @foreach($incomes as  $income)
                <tr>
                    <th><input type="checkbox" name="income_id[]" value="{{ $income->id }}"></th>
                    <th>{{ $income->id }}</th>
                    <th>{{ $income->beneficiary }}</th>
                    <th>{{ number_format($income->amount, 2) }}</th>
                    <th>{{ $income->description }}</th>
                    <th>{{ $income->created_at }}</th>
                    <th>{{ $income->updated_at }}</th>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div data-ajax-links="true">
            {{ $incomes->links() }}
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