<?php

namespace App\Http\Controllers\Api;

use App\Photo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PhotoController extends Controller
{
     /**
    hotoList data photos
     *
     * @return void
     */
    public function index()
    {
        $photos = Photo::latest()->paginate(6);
        return response()->json([
            "response" => [
                "status" => 200, // OK
                "message" => "List data photos"
            ],
            "data" => $photos
        ], 200);
    }


    /**
     * List data photos home page
     *
     * @return void
     */
    public function PhotoHomePage()
    {
        $photos = Photo::latest()->take(2)->get();
        return response()->json([
            "response" => [
                "status" => 20,
                "messages" => "List data photos home page"
            ],
            "data" => $photos
        ]);
    }
}
