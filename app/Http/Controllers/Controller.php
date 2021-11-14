<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

   

    public function landing()
    {
        // loading landing page with posts
        $posts = DB::table('posts')
            ->leftJoin('images', 'posts.id', '=', 'images.post_id')
            ->leftJoin('users', 'posts.user_id', '=', 'users.id')
            ->where('posts.status', '=', 'active')
            ->select('posts.*', 'images.*', 'posts.id as pid', 'users.*')
            ->orderBy('posts.created_at', 'desc')
            ->get();

        return view('welcome')->with(compact('posts'));


    }
}
