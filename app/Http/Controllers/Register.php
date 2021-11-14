<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;

class Register extends Controller
{
    //
    function register_user(Request $req)
    {

       Validator::extend('without_spaces', function($attr, $value){
            return preg_match('/^\S*$/u', $value);
        });

       // register input validation
        $validator = Validator::make($req->all(), [
            'username' => 'required|unique:users|without_spaces',
            'password' => 'min:6|required_with:cf_password|same:cf_password|without_spaces',
            'cf_password' => 'min:6|required_with:password|without_spaces',

        ], $messages = [
            'username.required' => 'We need to know your user name!',
           'username.without_spaces' => 'Username whitespace not allowed.',
           'password.without_spaces' => 'Password whitespace not allowed.',
           'cf_password.without_spaces' => 'Confirme password whitespace not allowed.',
            'username.unique' => 'User name exist!',
            'password.required' => 'Please enter password!',
            'password.same' => 'Password not match!',
            'password.min' => 'Password should contain minimum 6 charactors!',
            'cf_password.min' => 'Confirme password should contain minimum 6 charactors!',
            'cf_password.required_with' => 'Confirme password canot be empty!',


        ]);
        // insert to users table
        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $user = new User();
            $user->username = $req->input('username');
            $user->pro_imagepath = 'default.png';
            $user->password = Crypt::encryptString($req->input('password'));


            if ($user->save()) {
                $insertedId = $user->id;
                Session::put('user_id', $user->id);
                Session::put('user_name', $user->username);
                return response()->json(['status' => 1, 'msg' => '/']);

            } else {
                return redirect('register');
            }
        }


    }
}
