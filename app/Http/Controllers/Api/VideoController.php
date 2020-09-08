<?php

namespace App\Http\Controllers\Api;

use App\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VideoController extends Controller
{
     /**
     * List data videos
     *
     * @return void
     */
    public function index()
    {
        $videos = Video::latest()->paginate(6);
        return response()->json([
            "response" => [
                "status" => 200, // OK
                "message" => "List data videos"
            ],
            "data" => $videos
        ], 200);
    }


    /**
     * List data videos home page
     *
     * @return void
     */
    public function VideoHomePage()
    {
        $videos = Video::latest()->take(2)->get();
        return response()->json([
            "response" => [
                "status" => 20,
                "messages" => "List data videos home page"
            ],
            "data" => $videos
        ], 200);
    }
}
