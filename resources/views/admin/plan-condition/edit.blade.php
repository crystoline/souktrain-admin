@php
function selected($v1, $v2){
    return ($v1 == $v2)? ' selected ' : '';
}
@endphp
<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default card-view">
            <div class="panel-heading">
                <h3 class="panel-title txt-dark">Edit Plan Condition ({{ $plan_condition->title }})</h3>
            </div>
            <div class="panel-body">
                <form action="{{ route('admin.plan-condition.update', ['plan_condition' => $plan_condition->id] ) }}" method="post" data-ajax="true">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('title')? 'has-error': '' }}">
                                <label>Title</label>
                                <input name="title" class="form-control" required value="{{ $plan_condition->title }}">
                                @if ($errors->has('title'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('plan_id')? 'has-error': '' }}">
                                <label>Plan Name</label>
                                <select name="plan_id" class="form-control" required value="{{ $plan_condition->plan_id }}">
                                    @foreach($plans as $plan)
                                        <option value="{{ $plan->id }}" {{ selected( $plan->id, $plan_condition->plan_id) }}>{{ $plan->name }}</option>
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
                                    <input name="min" class="form-control" required type="number" min="0" step="1" value="{{ $plan_condition->min }}">
                                    @if ($errors->has('min'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('min') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-6 form-group{{ $errors->has('limits')? 'has-error': '' }}">
                                    <label>Limits</label>
                                    <input name="limits" class="form-control" required type="number" min="0" step="1" value="{{ $plan_condition->limits }}">
                                    @if ($errors->has('limits'))
                                        <span class="help-block">
                                <strong>{{ $errors->first('limits') }}</strong>
                            </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group{{ $errors->has('level')? 'has-error': '' }}">
                                <label>level</label>
                                <input name="level" class="form-control" required type="number" min="0" step="1" value="{{ $plan_condition->level }}">
                                @if ($errors->has('level'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('level') }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('action')? 'has-error': '' }}">
                                        <label>Action</label>
                                        <select name="action" class="form-control" required value="{{ $plan_condition->action }}">
                                            <option value="">Nothing</option>
                                            <option value="credit_wallet" {{ selected('credit_wallet',  $plan_condition->action) }}>Credit Wallet</option>
                                            <option value="credit_account" {{ selected('credit_account',  $plan_condition->action) }}>Credit Account</option>
                                            <option value="credit_service_center" {{ selected('credit_service_center',  $plan_condition->action) }}>Credit Service Center</option>
                                            <option value="upgrade" {{ selected('upgrade',  $plan_condition->action) }}>Upgrade</option>
                                            <option value="matrix3_2_ps_level_1"  {{ selected('matrix3_2_ps_level_1',  $plan_condition->action) }}>Do 3by1 PS Log</option>
                                            <option value="matrix3_2_ps_level_2"  {{ selected('matrix3_2_ps_level_2',  $plan_condition->action) }}>Do 3by2 PS Downline</option>

                                            <option value="matrix_pt_level_1_log"  {{ selected('matrix_pt_level_1_log',  $plan_condition->action) }}>Do 6by1 PT Log</option>

                                            <option value="matrix6_1_pt_level_1"  {{ selected('matrix6_1_pt_level_1',  $plan_condition->action) }}>Do 6by1 PT Level 1 Downline</option>
                                            <option value="matrix6_2_pt_level_2"  {{ selected('matrix6_2_pt_level_2',  $plan_condition->action) }}>Do 6by2  PTLevel 2 Downline</option>

                                            <option value="matrix6_1_cpt_level_1" {{ selected('matrix6_1_cpt_level_1',  $plan_condition->action) }}>Do 6by1 CPT Level 1 Downline</option>
                                            <option value="matrix6_2_cpt_level_2" {{ selected('matrix6_2_cpt_level_2',  $plan_condition->action) }}>Do 6by2 CPT Level 2 Downline</option>
                                            <option value="matrix6_3_cpt_level_3" {{ selected('matrix6_3_cpt_level_3',  $plan_condition->action) }}>Do 6by1 CPT Level 3 Downline</option>
                                            <option value="matrix6_4_cpt_level_4" {{ selected('matrix6_4_cpt_level_4',  $plan_condition->action) }}>Do 6by2 CPT Level 4 Downline</option>
                                        </select>
                                        @if ($errors->has('action'))
                                            <span class="help-block">
                                <strong>{{ $errors->first('action') }}</strong>
                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('sub_action')? 'has-error': '' }}">
                                        <label>Sub Action</label>
                                        <select name="sub_action" class="form-control"  value="{{ $plan_condition->sub_action }}">
                                            <option value="">Nothing</option>
                                            <option value="credit_wallet" {{ selected('credit_wallet',  $plan_condition->sub_action) }}>Credit Wallet</option>
                                            <option value="credit_account" {{ selected('credit_account',  $plan_condition->sub_action) }}>Credit Account</option>
                                            <option value="credit_service_center" {{ selected('credit_service_center',  $plan_condition->sub_action) }}>Credit Service Center</option>
                                            <option value="upgrade" {{ selected('upgrade',  $plan_condition->sub_action) }}>Upgrade</option>
                                        </select>
                                        @if ($errors->has('sub_action'))
                                            <span class="help-block">
                                <strong>{{ $errors->first('sub_action') }}</strong>
                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('user_account_type_id')? 'has-error': '' }}">
                                <label>Account</label>

                                <select name="user_account_type_id" class="form-control"  value="{{ $plan_condition->user_account_type_id }}">
                                    <option value="">None</option>
                                    <option value="">Wallet</option>
                                    @foreach($account_types as $account_type)
                                        <option {{ selected($account_type->id, $plan_condition->user_account_type_id) }} value="{{ $account_type->id }}">{{ $account_type->name }}</option>
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
                                <input name="amount" class="form-control" required type="number" min="0" step="1" value="{{ $plan_condition->amount }}">
                                @if ($errors->has('amount'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('condition_id')? 'has-error': '' }}">
                                <label>Condition Required?</label>
                                <select name="condition_id" class="form-control" type="number" value="{{ $plan_condition->condition_id }}">
                                    <option value="">None</option>
                                @foreach($conditions as $condition)
                                    <option {{ selected($condition->id, $plan_condition->condition_id) }} value="{{ $condition->id }}">{{ $condition->plan->name }} - {{ $condition->title }}</option>
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

