
<div class="row">
    <div class="col-md-5">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3>Service Center Details

                </h3>
                <?php



                ?>

            </div>


            <div class="panel-body">
                <form action="{{ route('admin.service_center.update',['service_center_id' => $service_center->id] ) }}" method="post" data-ajax="true">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <table class="table  table-hover" >
                     <tr> <th>Name:</th><td> {{$service_center->name }}</td></tr>
                     <tr><th>Address:</th><td> {{ $service_center->address }}</td></tr>
                     <tr><th>Country</th><td> {{ $service_center->country }}</td></tr>
                     <tr><th>Telephone</th><td> {{ $service_center->telephone }} </td></tr>
                     <tr><th>Service Center Code</th><td>{{ $service_center->code }}</td></tr>
                     <tr><th>Status</th><td><?php if($service_center->status === '0'){
                                 echo 'Approved';
                             }else{
                                 echo 'Unapproved';
                             }
                             ?> </td></tr>
                     <tr><th> Service Center Owner </th><td>{{  $profile->first_name }} {{  $profile->last_name }}</td></tr>
                     <tr><th>Date Updated:</th><td>{{ $service_center->updated_at }}</td></tr>
                     <tr><th>Date Created:</th><td>{{  $service_center->created_at }}</td></tr>


                </table>
                    <button class="btn btn-default btn-lg"><i class="fa fa-money"></i> <?php if($service_center->status === '0'){
                            echo 'Approve';
                        }else{
                            echo 'UnApprove';
                        }
                        ?></button>
                </form>


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