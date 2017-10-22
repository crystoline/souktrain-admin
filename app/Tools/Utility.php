<?php
/**
 * Created by PhpStorm.
 * User: Jephthah
 * Date: 7/19/2017
 * Time: 3:13 PM
 */

namespace App\Tools;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Utility
{
    public static function json($response){
        return response()->json($response)->header('Access-Control-Allow-Origin','*');
    }

    public static function json_success($data){
        return  self::json_status(true,$data,'200');
    }

    public static function json_failure($data,$code = '000'){
        return  self::json_status(false,$data,$code);
    }
    public static function response_array_failure($data,$code_name){
        return self::response_array_status(false,$data,$code_name);
    }
    public static function response_array_status($status,$data,$code = '000'){

        $statuses = [
            '000' => 'unknown',
            '001' => 'validation error',
            '200' => 'ok',
            '404' => 'not found',

            'P01' => 'pin error',
        ];
        if(!array_key_exists($code,$statuses)){
            $code = '000';
        }


        return [
            'status'=>$status,
            'status_code'=> $code,
            'message'=>$statuses[$code],
            'data'=>$data
        ];
    }

    public static function json_status($status,$data,$code_name){

        $response = self::response_array_status($status,$data,$code_name);

        return  self::json($response);
    }


    public static function gen_form_token(){
    	$token =  rand(10000000,99999999);
	    Session::put('my_form_token', $token);
    	return $token;
    }
    public static function my_form_token_field(){
	    $token =  self::gen_form_token();
	    return "<input type='hidden' name='my_form_no_refresh' value='{$token}'>";
    }

    public static function confirm_form_token(Request $request){
    	$prev_token = Session::get('my_form_token'); //dd($prev_token);
    	if($prev_token and $prev_token == $request->input('my_form_no_refresh') ){
		    Session::put('my_form_token', null);
    		return true;
	    }
	    Session::put('my_form_token', null);
	    false;
    }

}