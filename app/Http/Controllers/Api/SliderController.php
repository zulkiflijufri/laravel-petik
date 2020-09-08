<?php

namespace App\Http\Controllers\Api;

use App\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SliderController extends Controller
{
    /**
     * List data sliders
     *
     * @return void
     */
    public function index()
    {
        $sliders = Slider::latest()->paginate(10);
        return response()->json([
            "response" => [
                "status" => 200, // OK
                "message" => "List data sliders"
            ],
            "data" => $sliders
        ], 200);
    }
}
