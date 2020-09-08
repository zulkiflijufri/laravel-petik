<?php

namespace App\Http\Controllers\Api;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    /**
     * List data posts
     *
     * @return void
     */
    public function index()
    {
        $posts = Post::latest()->paginate(6);
        return response()->json([
            "response" => [
                "status" => 200, // OK
                "message" => "List data posts"
            ],
            "data" => $posts
        ], 200);
    }

    /**
     * Show post
     *
     * @param string $slug
     * @return void
     */
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->first();

        if ($post) {
            return response()->json([
                "response" => [
                    "status" => 20,
                    "messages" => "Detail data post"
                ],
                "data" => $post
            ], 200);
        } else {
            return response()->json([
                "response" => [
                    "status" => 404,
                    "messages" => "Data post tidak ditemukan"
                ],
                "data" => null
            ], 404);
        }
    }

    /**
     * List data posts home page
     *
     * @return void
     */
    public function PostHomePage()
    {
        $posts = Post::latest()->take(6)->get();
        return response()->json([
            "response" => [
                "status" => 20,
                "messages" => "List data posts home page"
            ],
            "data" => $posts
        ]);
    }
}
