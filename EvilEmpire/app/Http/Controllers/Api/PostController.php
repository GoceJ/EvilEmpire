<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostCollection;

class PostController extends Controller
{
       // api/users
       public function index()
       {
           return new PostCollection(Post::all());
       }
   
       // api/Posts/create
       public function store(PostRequest $request)
       {
           // if (!in_array($request->faculty_id, Faculty::pluck('id')->toArray()))
               // return response()->json(['error' => 'Faculty doesnt exist', 'status' => 400]);
   
   
           if (Post::create($request->validated()))
               return response()->json(['success' => 'success', 'status' => 200]);
       }
}
