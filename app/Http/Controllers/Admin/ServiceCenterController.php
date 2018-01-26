<?php

namespace App\Http\Controllers\Admin;
use App\ServicCenter;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
class ServiceCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$this->authorize('browse-service_center', ServicCenter::class);
        $service_centers = DB::table('servic_centers')->get();

        return view( 'admin.service_center.index', [ 'service_centers' => $service_centers ] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ServicCenter $service_center)
    {
//        $serviceCenter_id = request()->segment(3);
//        $service_center = DB::table('servic_centers')->where('id',$serviceCenter_id)->first();
	    $this->authorize('browse-service_center', $service_center);

	    $profile = DB::table('profiles')->where('user_id', $service_center->user_id)->first();

        return view( 'admin.service_center.edit', ['service_center'=> $service_center,'profile' => $profile] );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServicCenter $service_center)
    {

//       $id = request()->segment(3);
//       $service_center = DB::table('servic_centers')->where('id',$id)->first();
     //var_dump($service_center);
	    $this->authorize('browse-service_center', $service_center);
          if($service_center->status ==='0') {
              $status ='1';
          }else{
              $status ='0';
          }
        DB::table('servic_centers')
          ->where('id', $id)
            ->update(['status' => $status,'updated_at' =>date("Y-m-d H:i:s")]);


        return redirect()->route( 'admin.service_center.index' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
