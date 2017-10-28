<?php

namespace App\Http\Controllers\Agent;

use App\PinCollection;
use App\PinRequest;
use App\Tools\Utility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\Agent\PinRequestMail;
use Illuminate\Support\Facades\Mail;

class PinRequestController extends Controller
{
	private $pin_counts = [5, 10, 20, 100];

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	    $pin_collections = PinCollection::orderBy('public_value', 'ASC')->get();
	    $counts = $this->pin_counts;
        return view('agent.pin-request.index', [ 'pin_collections' => $pin_collections, 'counts' => $counts ]);
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
        $this->validate($request, [
        	'email' => 'required|email',
	        'pin_collection' => 'required|exists:pin_collections,id',
	        'count' => 'required'
        ]);

	    $ref_no =  $this->gen_ref();
		//dd($ref_no);
        if(!Utility::confirm_form_token($request) or !$ref_no or  !in_array($request->input('count'), $this->pin_counts)){
			return redirect()->route('agent.pin-request.index');
        }
		$pin_collection = PinCollection::find($request->input('pin_collection'));
        $pin_request =  PinRequest::create([
        	'email' => $request->input('email'),
	        'pin_collection_id' => $pin_collection->id,
	        'count' => $request->input('count'),
	        'value' => $pin_collection->public_value,
	        'cost'  => $pin_collection->real_value,
	        'status' => 0,
	        'ref_no' =>$ref_no,
        ]);

        Mail::to($pin_request->email)->send( new PinRequestMail( $pin_request));
	    return view('agent.pin-request.submitted', ['pin_request' => $pin_request]);
    }

    private function gen_ref($i=0){

    	$ref_no = substr( md5(uniqid(mt_rand())),0 , 11 );
    	$pin_req  = PinRequest::where('ref_no', $ref_no)->get()->first();
    	if(!$pin_req){
    		return strtoupper($ref_no);
	    }
	    if($i >= 4){
    		return false;
	    }
		$i++;
	    return $this->gen_ref($i);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
