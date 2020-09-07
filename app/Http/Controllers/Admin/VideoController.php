<?php

namespace App\Http\Controllers\Admin;

use App\Video;
use Illuminate\Http\Request;
use App\Http\Requests\VideoRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\VideoUpdateRequest;

class VideoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:videos.index|videos.create|videos.edit|videos.delete']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videos = Video::latest()->when(request()->q,
        function($videos){
            $videos = $videos->where('title', 'like', '%' . request()->q . '%');
        })->paginate(10);

        return view('admin.video.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.video.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\VideoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VideoRequest $request)
    {
        $video = Video::create([
            'title' => $request->input('title'),
            'embed' => $request->input('embed')
        ]);

        if ($video) {
            return redirect()->route('admin.video.index')->with(['success' => 'Data berhasil disimpan']);
        } else {
            return redirect()->route('admin.video.index')->with(['error' => 'Data gagal disimpan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function show(Video $video)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function edit(Video $video)
    {
        return view('admin.video.edit', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Requests\VideoUpdateRequest  $request
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function update(VideoUpdateRequest $request, Video $video)
    {
        $video->update([
            'title' => $request->input('title'),
            'embed' => $request->input('embed')
        ]);

        if ($video) {
            return redirect()->route('admin.video.index')->with(['success' => 'Data berhasil diupdate']);
        } else {
            return redirect()->route('admin.video.index')->with(['error' => 'Data gagal diupdate']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $video)
    {
        $video = $video->delete();

        if ($video) {
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
