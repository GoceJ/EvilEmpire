<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserCollection;

class UserController extends Controller
{
    // api/users
    public function index()
    {
        return new UserCollection(User::all());
    }

    // api/users/create
    public function store(UserRequest $request)
    {
        // if (!in_array($request->faculty_id, Faculty::pluck('id')->toArray()))
            // return response()->json(['error' => 'Faculty doesnt exist', 'status' => 400]);


        if (User::create($request->validated()))
            return response()->json(['success' => 'success', 'status' => 200]);
    }
}
