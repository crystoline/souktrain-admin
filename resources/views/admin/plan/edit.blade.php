<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default card-view">
            <div class="panel-heading">
                <h3 class="panel-title txt-dark">Edit Plan ({{ $plan->name }})</h3>
            </div>
            <div class="panel-body">
                <form action="{{ route('admin.plan.update', ['plan' => $plan->id]) }}" method="post" data-ajax="true">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="form-group{{ $errors->has('name')? 'has-error': '' }}">
                        <label>Plan Name</label>
                        <input name="name" class="form-control" required value="{{ $plan->name }}">
                        @if ($errors->has('name'))
                            <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('price')? 'has-error': '' }}">
                        <label>Price</label>
                        <input name="price" class="form-control" required type="number" min="1000" step="500" value="{{ $plan->price }}">
                        @if ($errors->has('price'))
                            <span class="help-block">
                        <strong>{{ $errors->first('price') }}</strong>
                    </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('order')? 'has-error': '' }}">
                        <label>Order</label>
                        <input name="order" class="form-control" required type="number" min="1" step="1" value="{{ $plan->order }}">
                        @if ($errors->has('order'))
                            <span class="help-block">
                        <strong>{{ $errors->first('order') }}</strong>
                    </span>
                        @endif
                    </div>
                    <button class="btn btn-sm btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

