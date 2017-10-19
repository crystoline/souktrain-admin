
<div class="row">
    <div class="col-md-5">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3>View Profile

                </h3>
                <?php
                // $withdraw = DB::table('user_account_withdraw') ->where('status', 'pending')->get();
                $profile = DB::table('profiles')->where('id',$profile_id)->first();

               // $profile_update = DB::table('profile_update')->where('user_id', $profile->user_id)->first();
                $upline = DB::table('profiles')->where('referral_id', $profile->referral_id)->first();

                ?>

            </div>

            <div class="panel-body">

                 <img src="{{ $profile->picture_url }}"  width="200px" height="200px"></img><br>
                <table class="table  table-hover" >
                    <tr> <th>Name:</th><td> {{ $profile->first_name }} {{ $profile->last_name }}</td></tr>
                    <tr><th> Gender:</th><td> {{ $profile->gender}}</td></tr>
                    <tr><th>My ID</th><td> {{ $profile->my_id}}</td></tr>
                    <tr><th> My phone No:</th><td> {{ $profile->phone_no }}</td></tr>
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
</div>
<script>
    $(function () {
        @if($message = session('notify-msg'))
swal('Success', '{{$message}}', 'success');
        @endif

$('#datatable-plan-cond').DataTable({ "lengthChange": false});
    })
</script>