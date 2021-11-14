<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;


class PostController extends Controller
{
    //
    function save_posts(Request $request)
    {
        // save post function
        $image = $request->file('post_image');
        if ($image != null || $request->post_des != null) {
            $post = new Post();

            $post->description = $request->post_des;
            $post->status = 'draft';
            $post->user_id = session()->get('user_id');

            if ($post->save()) {
                if ($image != null) {

                    $name = time() . '.' . $image->getClientOriginalName();

                    $destinationPath = public_path('images');
                    //        echo $destinationPath ;
                    $aa = $image->move($destinationPath, $name);
                    $image = new Image();
                    $image->post_id = $post->id;
                    $image->imagepath = $name;
                    $image->save();

                }
                session()->flash('sucsses_post', 'your post is saved go to profile and activate');
            }
        } else {

            session()->flash('create', 'You need to fill atleast one field to creat a post !');
        }
        return redirect('create_post');
    }

    function edit_posts(Request $request)
    {

        // edit post function
        $image = $request->file('post_image');

        $destinationPath = public_path('images');
        DB::table('posts')
            ->where('id', $request->input('id'))
            ->limit(1)
            ->update(array('description' => $request->post_des));

        $exist_image = DB::table('images')
            ->where('post_id', '=', $request->input('id'))
            ->select('images.*')
            ->get();

        // if($post){
        if ($image != null) {
            // image uploading and tabale insert
            $name = time() . '.' . $image->getClientOriginalName();
            $aa = $image->move($destinationPath, $name);
            $destinationPath = public_path('images');
            if ($request->input('image_loc') != '') {
                File::delete($destinationPath . "/" . $request->input('image_loc'));

            }

            if (count($exist_image) > 0) {
                DB::table('images')
                    ->where('post_id', $request->input('id'))
                    ->limit(1)
                    ->update(array('imagepath' => $name));
                session()->flash('sucsses', 'your post is saved');

            } else {

                $image = new Image();
                $image->post_id = $request->input('id');
                $image->imagepath = $name;
                $image->save();

            }


            // }

        }
        return redirect('profile');
    }

    function edit($idd)
    {
        // load edit view with post detais
        $id = $idd;
        $posts = DB::table('posts')
            ->leftjoin('images', 'posts.id', '=', 'images.post_id')
            ->where('posts.id', '=', $id)
            ->select('posts.*', 'images.*', 'posts.id as pid')
            ->get();

        return view('edit_post')->with(compact('posts'));


    }

    function delete($idd)
    {

        // delete post from post ang images tables
        $id = $idd;
        $posts = DB::table('images')
            ->where('post_id', '=', $id)
            ->select('images.*')
            ->first();

        DB::table('posts')->where('id', $id)->delete();
        if ($posts) {
            DB::table('images')->where('post_id', $id)->delete();
            $destinationPath = public_path('images');
            // delete file from location
            File::delete($destinationPath . "/" . $posts->imagepath);

        }

        return redirect('profile');
    }

    public function activate_poste(Request $request)
    {

        // activate and draft function
        $id = $request->id;
        if ($request->input('value') == 1) {
            $value = "active";
        } else {
            $value = "draft";
        }

        $post = Post::find($id);
        $post->status = $value;


        if ($post->save()) {
            return response()->json([
                'status' => 'true',
                'msg' => 'Updated',
            ]);
        } else {
            return response()->json([
                'status' => 'false',
                'msg' => 'Did not updated',
            ]);
        }

    }
}
