<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function index(Post $model)
    {
        return view('pages.posts.index', ['posts' => $model->paginate(15)]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        return view('pages.posts.show', ['post' => Post::where('id', $id)->first()]);
    }

    public function edit($id)
    {
        return view('pages.posts.edit', ['post' => Post::where('id', $id)->first()]);
    }

    public function update(Request $request, $id)
    {
        Post::where('id', $id )->update($request->except(['_token', '_method']));

        return back()->withStatus(__('Profile successfully updated.'));
    }

    public function destroy($id)
    {
        Post::where('id', $id)->delete();
        return back()->withStatus(__('Post successfully deleted.'));
    }
}
