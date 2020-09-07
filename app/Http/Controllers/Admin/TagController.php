<?php

namespace App\Http\Controllers\Admin;

use App\Tag;
use Illuminate\Support\Str;
use App\Http\Requests\TagRequest;
use App\Http\Requests\TagUpdateRequest;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:tags.index|tags.create|tags.edit|tags.delete']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::latest()->when(request()->q,
        function($tags) {
            $tags = $tags->where('name', 'like', '%'. request()->q . '%');
        })->paginate(10);

        return view('admin.tag.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tag.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TagRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $request)
    {
        $tag = Tag::create([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name'), '-')
        ]);

        if($tag){
            return redirect()->route('admin.tag.index')->with(['success' =>'Data berhasil disimpan!']);
        } else{
            return redirect()->route('admin.tag.index')->with(['error' => 'Data gagal disimpan!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        return view('admin.tag.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TagUpdateRequest  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(TagUpdateRequest $request, Tag $tag)
    {
        $tag->update([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name'), '-')
        ]);

        if($tag){
            return redirect()->route('admin.tag.index')->with(['success' => 'Data berhasil diupdate!']);
        } else {
            return redirect()->route('admin.tag.index')->with(['error' => 'Data gagal diupdate!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag = $tag->delete();

        if ($tag) {
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
