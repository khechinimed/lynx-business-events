<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $events = Event::all();
        return response()->json(['events' => $events], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'timestamp' => 'required|date_format:Y-m-d H:i:s|after_or_equal:' . Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $event = Event::create($request->all());

        return response()->json(['event' => $event], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['error' => 'Event not found'], 404);
        }

        return response()->json(['event' => $event], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'timestamp' => 'required|date_format:Y-m-d H:i:s|after_or_equal:' . Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $event = Event::find($id);
        if (!$event) {
            return response()->json(['error' => 'Event not found'], 404);
        }

        $event->update($request->all());

        return response()->json(['event' => $event], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['error' => 'Event not found'], 404);
        }

        $event->delete();

        return response()->json(['message' => 'Event deleted successfully'], 200);
    }
}