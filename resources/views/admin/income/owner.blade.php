@include('admin.notification')
<ul class="text text-danger">
@foreach($errors->all() as $error)
    <li>{{ $error }}</li>
@endforeach
</ul>

<h3>{{strtoupper($owner) }}</h3>
<form method="post" action="{{ route('admin.income.settlement.create', ['owner' => $owner]) }}" data-ajax="true" data-dst="#tab-content">
    {{ csrf_field()}}
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
                <th><input type="checkbox" name="income_ids[][income_id]" value="{{ $income->id }}"></th>
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
    <button type="submit" class="btn btn-primary btn-sm">Create Settlement</button>
</form>
<div data-ajax-links="true" data-dst="#tab-content" data-temp="true">
    {{ $incomes->links() }}
</div>