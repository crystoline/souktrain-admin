

<div class="panel panel-default">
    <div class="panel-heading">
        <h3>Service Centers

        </h3>
        <?php //var_dump( $withdrawals)?>

    </div>
    <div class="panel-body">
        <table class="table table-striped table-hover" id="datatable-plan-cond">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Address</th>
                <th>Country</th>
                <th>Telephone</th>
                <th>Service Center Code</th>
                <th>Status</th>
                <th>Service Center Owner</th>
                <th>Date Created</th>
                <th>Date Editted</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php $i = 1;
            //var_dump($profiles);?>
            @foreach($service_centers as $service_center)
            <?php
            $profile = DB::table('profiles')->where('user_id', $service_center->user_id)->first();

            ?>
            <tr>
                <th>{{ $i++ }}</th>
                <th><?php echo $service_center->name ?></th>
                <th>{{ $service_center->address }}</th>
                <th>{{ $service_center->country }} </th>
                <th>{{ $service_center->telephone }}   </th>
                <th>{{ $service_center->code }}  </th>
                <th><?php if($service_center->status === '0'){
                    echo 'Approve';
                    }else{
                        echo 'Unapprove';
                    }
                     ?>  </th>
                <th>{{  $profile->first_name }} {{  $profile->last_name }} </th>
                <th>{{ $service_center->updated_at }}   </th>
                <th>{{  $service_center->created_at }}  </th>


                <th> <a class="btn btn-xs btn-info" href="{{ route('admin.service_center.edit', ['service_center' => $service_center->id]) }}" data-ajax="true">
                        <?php if($service_center->status === '0'){
                            echo 'Approve';
                        }else{
                            echo 'Unapprove';
                        }
                        ?>
                    </a> </th>
            </tr>
            @endforeach
            </tbody>
        </table>
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