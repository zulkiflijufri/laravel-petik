<?php

namespace App\Http\Controllers\Api;

use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    /**
     * List tags
     *
     * @return void
     */
    public function index()
    {
        $tags = Tag::latest()->paginate(10);
        return response()->json([
            "response" => [
                "status" => 200,
                "message" => "List data tags"
            ],
            "data" => $tags
        ], 200);
    }

    /**
     * Data post with tag
     *
     * @param string $slug
     * @return void
     */
    public function show($slug)
    {
        $tag = Tag::where('slug', $slug)->first();

        if ($tag) {
            return response()->json([
                "response" => [
                    "status" => 200,
                    "message" => "Data Post Berdasarkan Tag: " . $tag->name
                ],
                "data" => $tag->posts()->latest()->paginate(6)
            ], 200);
        } else {
            return response()->json([
                "response" => [
                    "status" => 404,
                    "message" => "Data Post Berdasarkan Tag Tidak Ditemukan"
                ],
                "data" => null
            ], 404);
        }
    }
}
