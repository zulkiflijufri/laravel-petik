<?php

namespace App\Http\Controllers\Api;

use App\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    /**
     * List data events
     *
     * @return void
     */
    public function index()
    {
        $events = Event::latest()->paginate(6);
        return response()->json([
            "response" => [
                "status" => 200, // OK
                "message" => "List data events"
            ],
            "data" => $events
        ], 200);
    }

    /**
     * Show event
     *
     * @param string $slug
     * @return void
     */
    public function show($slug)
    {
        $event = Event::where('slug', $slug)->first();

        if ($event) {
            return response()->json([
                "response" => [
                    "status" => 20,
                    "messages" => "Detail data event"
                ],
                "data" => $event
            ], 200);
        } else {
            return response()->json([
                "response" => [
                    "status" => 404,
                    "messages" => "Data event tidak ditemukan"
                ],
                "data" => null
            ], 404);
        }
    }

    /**
     * List data events home page
     *
     * @return void
     */
    public function EventHomePage()
    {
        $events = Event::latest()->take(6)->get();
        return response()->json([
            "response" => [
                "status" => 20,
                "messages" => "List data events home page"
            ],
            "data" => $events
        ]);
    }
}
