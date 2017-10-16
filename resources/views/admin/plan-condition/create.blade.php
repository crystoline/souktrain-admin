<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default card-view">
            <div class="panel-heading">
                <h3 class="panel-title txt-dark">Create New Plan Condition</h3>
            </div>
            <div class="panel-body">
                <form action="{{ route('admin.plan-condition.store') }}" method="post" data-ajax="true">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('title')? 'has-error': '' }}">
                                <label>Title</label>
                                <input name="title" class="form-control" required value="{{ old('title') }}">
                                @if ($errors->has('title'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('plan_id')? 'has-error': '' }}">
                                <label>Plan Name</label>
                                <select name="plan_id" class="form-control" required value="{{ old('plan_id') }}">
                                    @foreach($plans as $plan)
                                        <option value="{{ $plan->id }}">{{ $plan->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('plan_id'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('plan_id') }}</strong>
                            </span>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group{{ $errors->has('min')? 'has-error': '' }}">
                                    <label>Minimum Downlines</label>
                                    <input name="min" class="form-control" required type="number" min="0" step="1" value="{{ old('min') }}">
                                    @if ($errors->has('min'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('min') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-6 form-group{{ $errors->has('limits')? 'has-error': '' }}">
                                    <label>Limits</label>
                                    <input name="limits" class="form-control" required type="number" min="0" step="1" value="{{ old('limits') }}">
                                    @if ($errors->has('limits'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('limits') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('level')? 'has-error': '' }}">
                                <label>level</label>
                                <input name="level" class="form-control" required type="number" min="1" step="1" value="{{ old('level') }}">
                                @if ($errors->has('level'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('level') }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('action')? 'has-error': '' }}">
                                <label>Action</label>
                                <select name="action" class="form-control" required value="{{ old('action') }}">
                                    <option value="">Nothing</option>
                                    <option value="credit_wallet">Credit Wallet</option>
                                    <option value="credit_account">Credit Account</option>
                                    <option value="upgrade">Upgrade</option>
                                </select>
                                @if ($errors->has('action'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('action') }}</strong>
                            </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('user_account_type_id')? 'has-error': '' }}">
                                <label>Account</label>

                                <select name="user_account_type_id" class="form-control" required value="{{ old('user_account_type_id') }}">
                                    <option value="">None</option>
                                    <option value="">Wallet</option>
                                    @foreach($account_types as $account_type)
                                        <option value="{{ $account_type->id }}">{{ $account_type->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('user_account_type_id'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('user_account_type_id') }}</strong>
                            </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('amount')? 'has-error': '' }}">
                                <label>Amount</label>
                                <input name="amount" class="form-control" required type="number" min="1" step="1" value="{{ old('amount') }}">
                                @if ($errors->has('amount'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('condition_id')? 'has-error': '' }}">
                                <label>Condition Required?</label>
                                <select name="condition_id" class="form-control" required type="number" value="{{ old('condition_id') }}">
                                    <option value="">None</option>
                                @foreach($conditions as $condition)
                                    <option value="{{ $condition->id }}">{{ $condition->plan->name }} - {{ $condition->title }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('condition_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('condition_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                    </div>

                    <button class="btn btn-sm btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

