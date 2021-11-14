<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// landing rout
Route::get('/', function () {

    return view('welcome');
});
// log in view rout
Route::get('/login', function () {
    return view('login');
});
Route::post('/logincheck','Login@logincheck');


Route::get('/','Controller@landing');
// middleware to check if user login
Route::group(['middleware' => ['login_check']], function () {
	// activ and draft function rout
	Route::post('/activate_poste','PostController@activate_poste');
	// save post function rout
	Route::post('/save_posti','PostController@save_posts');
	Route::post('/edit_posti','PostController@edit_posts');
	// change profile picture rout
	Route::post('/change_pro','Profile@change_pro_pic');
	// rout for edit post
	Route::get('/edit/{id}','PostController@edit');
	// rout for delete post
	Route::get('/delete/{id}','PostController@delete');
	// profilr view rout
	Route::get('profile','Profile@profile');
	// create post function rout
	Route::view('create_post','post_create');

});
// register user function rout
Route::post('/register_user','Register@register_user');
// register view rout
Route::view('register','register');
// log out rout
Route::get('/logout', function() {
	// delete session if exist
    if(Session::has('user_id')){
        Session::pull('user_id');
        Session::pull('user_name');
        return redirect('/');
    }
});
