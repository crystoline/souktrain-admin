@component('mail::message')
# Good day Sir/Ma

This mail show that the purchase of recharge pin code was successful.

Here is your PIN.  {{ $pin_request->price}}/Each
@component('mail::table')
| S/N           | PIN           |
| ------------- |---------------|
@foreach($pin_request->pins as $pin)
| {{ $pin->id}}      | {{ $pin->code}}      |
@endforeach
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent
