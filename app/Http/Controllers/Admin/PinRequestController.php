<?php

namespace App\Http\Controllers\Admin;

use App\Pin;
use App\PinRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\Agent\PinResponseMail;

class PinRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request)
    {
		$this->authorize('browse-pin_request', PinRequest::class);
	    //dd($request);
	    $keyword = $request->get('search');
	    $perPage = 100;

	    if (!empty($keyword)) {
		    $pin_requests = PinRequest::where('email', 'LIKE', "%$keyword%")
		         ->orderBy('status', 'DESC')
		         ->orderBy('created_at', 'ASC')
		         ->paginate($perPage);
	    } else {
		    $pin_requests = PinRequest::orderBy('status', 'DESC')->orderBy('created_at', 'ASC')->paginate($perPage);
	    }
        return view('admin.pin-request.index', ['pin_requests' =>$pin_requests]);
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
    public function update(Request $request, PinRequest $pin_request)
    {
	    $this->authorize('update-pin_request', $pin_request);
	    self::generatePins($pin_request);
		//send mail here
	    $pin_request->status = 1;
        $pin_request->save();
        Mail::to($pin_request->email)->send( new PinResponseMail( $pin_request));
        session()->flash('message', 'Pin was sent');
    	return redirect()->route('admin.pin-request.index');
    }

    public function send(Request $request, PinRequest $pin_request){
	    $this->authorize('send-pin', $pin_request);
        Mail::to($pin_request->email)->send( new PinResponseMail( $pin_request));
        session()->flash('message', 'Pin was sent');
    	return redirect()->route('admin.pin-request.index');
    }

    public static function generatePins(PinRequest $pin_request)
    {
    	$pin_request->load('pins');
		if(!$pin_request->count or count($pin_request->pins) >= $pin_request->count) return;
	    $code = substr( uniqid(mt_rand()),0 , 9 );
	    $pin = Pin::where('code', $code)->get()->first();
	    if(!$pin){
		    $pin_request->pins()->create([
			    'code' => $code,
			    'pin_collection_id' => $pin_request->pin_collection_id
		    ]);
	    }

	    self::generatePins($pin_request);

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
