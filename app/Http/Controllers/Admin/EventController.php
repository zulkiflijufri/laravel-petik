<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\EventRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventUpdateRequest;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:events.index|events.create|events.edit|events.delete']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::latest()->when(request()->q,
        function($events) {
            $events = $events->where('title', 'like', '%' . request()->q . '%' );
        })->paginate(10);

        return view('admin.event.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.event.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\EventRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventRequest $request)
    {
        $event = Event::create([
            'title' => $request->input('title'),
            'slug' => Str::slug($request->input('title'), '-'),
            'content' => $request->input('content'),
            'location' => $request->input('location'),
            'date' => $request->input('date')
        ]);

        if ($event) {
            return redirect()->route('admin.event.index')->with(['success' => 'Data berhasil disimpan']);
        } else {
            return redirect()->route('admin.event.index')->with(['error' => 'Data gagal disimpan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        return view('admin.event.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\EventUpdateRequest  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(EventUpdateRequest $request, Event $event)
    {
        $event->update([
            'title' => $request->input('title'),
            'slug' => Str::slug($request->input('title'), '-'),
            'content' => $request->input('content'),
            'location' => $request->input('location'),
            'date' => $request->input('date')
        ]);

        if ($event) {
            return redirect()->route('admin.event.index')->with(['success' => 'Data berhasil diupdate']);
        } else {
            return redirect()->route('admin.event.index')->with(['error' => 'Data gagal diupdate']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $event = $event->delete();

        if ($event) {
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
