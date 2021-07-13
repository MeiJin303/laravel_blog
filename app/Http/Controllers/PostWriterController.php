<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostWriterController extends Controller
{
    // add new post
    public function addPost(Request $request)
    {
        if ($request->method() == 'GET') {
            return view('add-post');
        }

        $this->validate($request,[
            'title' => 'required',
            'description' => 'required'
            ]);

        $userId = auth()->id();
        $post = new Post();
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->user_id = $userId;
        $post->save();

        return redirect()->route('dashboard')->with('success', 'Post created successfully!');
    }

}
