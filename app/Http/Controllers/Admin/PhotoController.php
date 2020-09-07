<?php

namespace App\Http\Controllers\Admin;

use App\Photo;
use Illuminate\Http\Request;
use App\Http\Requests\PhotoRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:photos.index|photos.create|photos.edit|photos.delete']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $photos = Photo::latest()->when(request()->q,
        function($photos) {
            $photos = $photos->where('caption', 'like', '%' . request()->q . '%');
        })->paginate(10);

        return view('admin.photo.index', compact('photos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PhotoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PhotoRequest $request)
    {
        // upload image
        $image = $request->file('image');
        $image->storeAs('public/photos', $image->getClientOriginalName());

        $photo = Photo::create([
            'image' => $image->getClientOriginalName(),
            'caption'   => $request->input('caption')
        ]);

        if ($photo) {
            return redirect()->route('admin.photo.index')->with(['success' => 'Data berhasil disimpan!']);
        } else {
            return redirect()->route('admin.photo.index')->with(['error' =>'Data gagal disimpan!']);
        }
    }

    public function edit(Photo $photo)
    {
        return view('admin.photo.index', compact('photo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Photo $photo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo)
    {
        $photo->delete();
        Storage::disk('local')->delete('public/photos/'.$photo->image);

        if ($photo) {
            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
