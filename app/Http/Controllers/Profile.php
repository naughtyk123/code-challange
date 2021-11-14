<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;


class Profile extends Controller
{
    //
    public function profile()
    {
        // load profile view wit user data
        $posts = DB::table('posts')
            ->leftJoin('images', 'posts.id', '=', 'images.post_id')
            ->where('posts.user_id', '=', session()->get('user_id'))
            ->select('posts.*', 'images.*', 'posts.id as pid')
            ->orderBy('posts.created_at', 'desc')
            ->get();

        $u_img = DB::table('users')
            ->where('users.id', '=', session()->get('user_id'))
            ->select('users.pro_imagepath')
            ->first();

        return view('profile')->with(compact('posts'))->with(compact('u_img'));

    }

    public function change_pro_pic(Request $request)
    {

        $image = $request->file('pro_pic');

        if ($image != null) {
            // profile picture insert and upload to folder
            $u_img = DB::table('users')
                ->where('users.id', '=', session()->get('user_id'))
                ->select('users.pro_imagepath')
                ->first();

            if ($u_img->pro_imagepath != "default.png") {
                // delete propictur from location if exist
                $destinationPath = public_path('users');
                File::delete($destinationPath . "/" . $u_img->pro_imagepath);
            }


            $name = time() . '.' . $image->getClientOriginalName();

            $destinationPath = public_path('users');

            $aa = $image->move($destinationPath, $name);


            DB::table('users')
                ->where('id', session()->get('user_id'))
                ->limit(1)
                ->update(array('pro_imagepath' => $name));
            session()->flash('sucsses', 'your post is saved');

        }
        return redirect('profile');
    }


}
