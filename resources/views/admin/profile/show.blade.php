
<div class="row">





     <div class="col-md-4">

     <div class="panel panel-default">
         <div class="panel-heading">
             <h3>View Profile

             </h3>
             <?php
             // $withdraw = DB::table('user_account_withdraw') ->where('status', 'pending')->get();
             $profile = DB::table('profiles')
                 ->join('users', 'users.id', '=', 'profiles.user_id')
                 ->select('profiles.*', 'users.email')
                 ->where('profiles.id',$profile_id)->first();


             $upline = DB::table('profiles')->where('referral_id', $profile->referral_id)->first();
             $profile_update = DB::table('profile_update')->where('user_id', $profile->user_id)->first();
             $bank_account = DB::table('account_info')->where('profile_id', $profile->id)->first();
             ?>

         </div>


         <div class="panel-body">


             <table class="table  table-hover" >
                 <tr> <th>Name:</th><td> {{ $profile->first_name }} {{ $profile->last_name }}</td></tr>
                    <tr><th> Gender:</th><td> {{ $profile->gender}}</td></tr>
                    <tr><th>My ID</th><td> {{ $profile->my_id}}</td></tr>
                    <tr><th> My phone No:</th><td> {{ $profile->phone_no }}</td></tr>
                    <tr><th> Email:</th><td> {{ $profile->email }}</td></tr>

                    <tr><th> Upline:</th><td> {{ $upline->first_name }} {{ $upline->last_name }}</td></tr>
                    <tr><th> Date Created:</th><td>{{ $profile->created_at }}</td></tr>
                    <tr><th>Date Editted:</th><td> {{ $profile->updated_at }}</td></tr>


                </table>

                <a class="btn btn-lg btn-default" href="{{ route('admin.profiles.index') }}" data-ajax="true">
                    <i class="fa fa-check-back-arrow"></i>
                    Back
                </a>
            </div>




        </div>
    </div>
    <div class="col-md-4">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3>Other information

                </h3>


            </div>

            <div class="panel-body">
                @if( !empty($profile_update) )
                <table class="table  table-hover " >

                    <tr> <th>Address:</th><td> {{ $profile_update->address }}</td></tr>
                    <tr><th> Date of Birth:</th><td> {{ $profile_update->dob}}</td></tr>
                    <tr><th>Mother's Maiden Name</th><td> {{ $profile_update->maiden}}</td></tr>

                    <tr><th> Date Created:</th><td>{{ $profile_update->created_at }}</td></tr>
                    <tr><th>Date Editted:</th><td> {{ $profile_update->updated_at }}</td></tr>


                </table>

                <a class="btn btn-lg btn-default" href="{{ route('admin.profiles.index') }}" data-ajax="true">
                    <i class="fa fa-check-back-arrow"></i>
                    Back
                </a>


                @else
                    <div class="text text-danger"> Other information is not available!! Kindly update your profile</div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-4">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3>Bank Account details

                </h3>


            </div>

            <div class="panel-body">
                @if( empty($bank_account))
                    <div class="text text-danger">Bank Account Not Available!! Kindly update your bank info</div>
                @else


                <table class="table  table-hover" >
                    <tr> <th>Account Name:</th><td> {{ $bank_account->account_name }} </td></tr>
                    <tr><th> Account No:</th><td> {{ $bank_account->account_no}}</td></tr>
                    <tr><th>Account Type</th><td> {{ $bank_account->acc_type}}</td></tr>
                    <tr><th>Phone No:</th><td> {{ $bank_account->phone_no }}</td></tr>
                    <tr><th> Bank:</th><td> {{ $bank_account->bank }} </td></tr>
                    <tr><th>Branch:</th><td> {{ $bank_account->bank_branch }}</td></tr>
                    <tr><th> Country:</th><td> {{ $bank_account-> country }} {{ $upline->last_name }}</td></tr>
                    <tr><th> Date Created:</th><td>{{ $bank_account->created_at }}</td></tr>
                    <tr><th>Date Editted:</th><td> {{ $bank_account->updated_at }}</td></tr>


                </table>

                <a class="btn btn-lg btn-default" href="{{ route('admin.profiles.index') }}" data-ajax="true">
                    <i class="fa fa-check-back-arrow"></i>
                    Back
                </a>
                @endif
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