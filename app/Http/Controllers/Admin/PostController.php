<?php

namespace App\Http\Controllers\Admin;

use App\Tag;
use App\Post;
use App\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PostUpdateRequest;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:posts.index|posts.create|posts.edit|posts.delete']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->when(request()->q,
        function($posts) {
            $posts = $posts->where('title', 'like', '%' . request()->q . '%' );
        })->paginate(10);

        return view('admin.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::latest()->get();
        $categories = Category::latest()->get();

        return view('admin.post.create', compact('tags', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $image = $request->file('image');
        if (Storage::exists('public/posts/'.$image->getClientOriginalName())) {
            return redirect()->back()->with(['error' => 'Gambar sudah ada, pilih gambar lain']);
        } else {
            $image->storeAs('public/posts', $image->getClientOriginalName());
        }

        $post = Post::create([
            'image' => $image->getClientOriginalName(),
            'title' => $request->input('title'),
            'slug'  => Str::slug($request->input('title'), '-'),
            'category_id' => $request->input('category_id'),
            'content' => $request->input('content')
        ]);

        // assign tags
        $post->tags()->attach($request->input('tags'));

        if ($post) {
            return redirect()->route('admin.post.index')->with(['success' => 'Data berhasil disimpan']);
        } else {
            return redirect()->route('admin.post.index')->with(['error' => 'Data gagal disimpan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $tags = Tag::latest()->get();
        $categories = Category::latest()->get();

        return view('admin.post.edit', compact('tags', 'categories', 'post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PostUpdateRequest  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        if ($request->file('image') == "") {
            $post->update([
                'title' => $request->input('title'),
                'slug'  => Str::slug($request->input('title'), '-'),
                'category_id' => $request->input('category_id'),
                'content' => $request->input('content')
            ]);
        } else {
            // remove old image
            Storage::disk('local')->delete('public/posts/'.$post->image);

            // upload new image
            $image = $request->file('image');
            $image->storeAs('public/posts', $image->getClientOriginalName());

            $post->update([
                'image' => $image->getClientOriginalName(),
                'title' => $request->input('title'),
                'slug'  => Str::slug($request->input('title'), '-'),
                'category_id' => $request->input('category_id'),
                'content' => $request->input('content')
            ]);
        }

        // assign tags
        $post->tags()->sync($request->input('tags'));

        if ($post) {
            return redirect()->route('admin.post.index')->with(['success' => 'Data berhasil diupdate']);
        } else {
            return redirect()->route('admin.post.index')->with(['error' => 'Data gagal diupdate']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        Storage::disk('local')->delete('public/posts/'.$post->image);

        if ($post) {
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
