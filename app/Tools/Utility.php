<?php
/**
 * Created by PhpStorm.
 * User: Jephthah
 * Date: 7/19/2017
 * Time: 3:13 PM
 */

namespace App\Tools;


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

}