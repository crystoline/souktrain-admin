@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Buy Pin</div>

                    <div class="panel-body">
                      <form method="post" action="{{route('agent.pin-request.store')}}">
                          {{ csrf_field() }}
                          {!! \App\Tools\Utility::my_form_token_field() !!}
                          <div class="form-group">
                              <label for="">Email</label>
                              <input type="email" class="form-control" required name="email" value="{{ old('email') }}" placeholder="Enter you email" title="You have to enter your email address">
                          </div>
                          <div class="form-group">
                              <label for="">Select Pin</label>
                              <select name="pin_collection" class="form-control" required>
                                  <option value="" {{ !(old('pin_collection'))?  'selected' : '' }}selected readonly style="color: grey;">--CHOOSE--</option>
                                @foreach($pin_collections as $pin_collection)
                                    <option value="{{ $pin_collection->id }}">{{ $pin_collection->name }}/{{ number_format($pin_collection->public_value) }}. Buy at {{ number_format($pin_collection->real_value) }}</option>
                                @endforeach
                              </select>
                          </div>
                          <div class="form-group">
                              <label for="">How many</label>
                              <select name="count" class="form-control" required>
                                  <option value="" {{ !(old('count'))?  'selected' : '' }}selected readonly style="color: grey;">--CHOOSE--</option>
                                  @foreach($counts as $count)
                                      <option value="{{ $count}}">{{ $count }}</option>
                                  @endforeach
                              </select>
                          </div>

                          <button type="submit" class="btn btn-primary">Submit</button>
                      </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection