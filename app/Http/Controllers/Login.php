<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;

class Login extends Controller
{
    //
    public function logincheck(Request $request){

        

        $data = DB::table('users')->get()->where('username', '=', $request->input('username'))->where('password', '=', Crypt::encryptString($request->input('password'));
        if(!$data->isEmpty()){
            foreach ($data as $object){

                Session::put('user_id',$object->id);
                Session::put('user_name',$object->username);

            }
            return response()->json([
                'status' => 'true',
                'msg' => '/',
            ]);
        }
    }
}
