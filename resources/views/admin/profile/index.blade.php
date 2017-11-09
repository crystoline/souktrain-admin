<div class="panel panel-default">
    <div class="panel-heading">
        <h3>Profile

        </h3>


    </div>
    <div class="panel-body">
        <table class="table table-striped table-hover" id="datatable-plan-cond">
            <thead>
            <tr>
                <form method="post" action=""></form>
                <th>#</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Gender</th>
                <th>Email</th>
                <th>My_ID</th>
                <th>Upline</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
			<?php $i = 1;
			// var_dump($profiles);
			?>

            @foreach($profiles as $index => $profile)
				<?php $upline = DB::table( 'profiles' )->where( 'referral_id', $profile->referral_id )->first();
				//var_dump($upline);
				?>
                <tr>
                    <th>{{ $profile->id }}</th>
                    <th>{{ $profile->first_name }}</th>
                    <th>{{ $profile->last_name }}</th>
                    <th>{{ $profile->gender }}</th>
                    <th>{{  $profile->email }}</th>
                    <th>{{  $profile->my_id }}</th>
                    <th><?php echo $upline->first_name . ' ' . $upline->last_name ?></th>
                    <th><?php  if ( $profile->status === '0' ) {
							echo 'Not logged In';
						} else {
							echo 'logged In';
						}
						?></th>
                    <th><a class="btn btn-xs btn-info"
                           href="{{ route('admin.profiles.show', ['profile' => $profile->id]) }}" data-ajax="true">
                            <i class="fa fa-folder"></i>
                            view
                        </a></th>

            @endforeach
            </tbody>
        </table>
        <div data-ajax-links="true">
            {{ $profiles->links() }}
        </div>
    </div>
</div>
<script>
    $(function () {
        @if($message = session('notify-msg'))
        swal('Success', '{{$message}}', 'success');
        @endif

        //$('#datatable-plan-cond').DataTable({ "lengthChange": false});
    })
</script>