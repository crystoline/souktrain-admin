<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class CmdToolController extends Controller
{
    public function index(){

    return $this->view();

    }

    public function exec(Request $request){
        if($request->input('cmd')) {
            $params = [];
            $vs = $request->input('paramValue');
            $ps = $request->input('param');
            if(!empty($ps) and !empty($vs)){
                foreach($ps as $i =>$p){
                   if(empty($vs[$i])) continue;
                    @$params[$p] = $vs[$i];
                }
            }
            Artisan::call($request->input('cmd'), $params);
            return '<div style="font-family: monospace;">'.preg_replace('#( ){1}#', '&nbsp;', str_replace("\r\n", '<br>',Artisan::output()) ).'</div>';
        }
    }

    private function view(){

        return '
<style>
iframe {
  height: 300px;
  width: 300px;
  resize: both;
  overflow: auto;
}
</style>
        <iframe name="output" style=""></iframe>


<form method="post" target="output" style="max-width: 600px">
'.csrf_field().'
    <fieldset>
        <legend>Run Commands</legend>
        <label>Command <br>
            <input name="cmd" value="'.old('cmd').'">
        </label><br>
        <label>Parameters</label><br>
        <input name="param[]" value="" size="7"><input name="paramValue[]" value="" size="7">&nbsp;
        <input name="param[]" value="" size="7"><input name="paramValue[]" value="" size="7">&nbsp;
        <input name="param[]" value="" size="7"><input name="paramValue[]" value="" size="7">

    </fieldset>
    <button type="submit">Run</button>
</form>
        ';
    }
}
