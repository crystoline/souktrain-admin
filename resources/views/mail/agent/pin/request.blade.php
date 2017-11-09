@component('mail::message')
# Good day

@php
    $total_cost = number_format($pin_request->cost * $pin_request->count)
@endphp
<p>Your request to purchase recharge Pin was successful</p>
<code>
Your Reference number is: {{ $pin_request->ref_no }}<br>
Value of Pin : {{ number_format($pin_request->value) }}<br>
Cost : {{ number_format($pin_request->cost) }} /PIN<br>
Quantity : {{ $pin_request->count }}<br>
Total Cost: {{ $total_cost }}
</code>

<h3>Making Payment</h3>
Pay the amount of {{ $total_cost }} to any of the following bank account
<ol>
@foreach(config('souktrain.bank_accounts', []) as $account)
<li>{{ $account['bank'] }} {{ $account['account_no'] }} {{ $account['name'] }}</li>
@endforeach

</ol>

<h3>Payment confirmation</h3>
<ol>
<li>After making payment, confirm your payment by Uploading the scanned copy of the duplicate bank teller used for making payment</li>
<li>The Admin will confirm you payment and</li>
<li>Your purchased PIN numbers will be sent to your email ({{ $pin_request->email }})</li>
</ol>


Thanks,<br>
{{ config('app.name') }}
@endcomponent
