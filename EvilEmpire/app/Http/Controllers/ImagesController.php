<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImagesController extends Controller
{
    public function index()
    {
        return view('pages.images.show', ['images' => Image::all()]);
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
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        
        if (!Image::where('id', $id)->delete())
            return back()->withStatus(__('Image failed to delete.'));

        return back()->withStatus(__('Image successfully updated.'));
    }
}
