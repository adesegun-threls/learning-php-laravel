<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of events.
     */
    public function index()
    {
        $events = Event::with('user:id,name', 'attendees')
            ->latest()
            ->get();

        return response()->json($events);
    }

    /**
     * Store a newly created event.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date|after:now',
            'end_time' => 'nullable|date|after:start_time',
        ]);

        $event = $request->user()->events()->create($validated);

        return response()->json($event->load('user:id,name'), 201);
    }

    /**
     * Display the specified event.
     */
    public function show(Event $event)
    {
        return response()->json(
            $event->load('user:id,name,email', 'attendees.user:id,name')
        );
    }

    /**
     * Update the specified event.
     */
    public function update(Request $request, Event $event)
    {
        // Only the event creator can update
        if ($event->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'You are not authorized to update this event.',
            ], 403);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'sometimes|required|date',
            'end_time' => 'nullable|date|after:start_time',
        ]);

        $event->update($validated);

        return response()->json($event->load('user:id,name'));
    }

    /**
     * Remove the specified event.
     */
    public function destroy(Request $request, Event $event)
    {
        // Only the event creator can delete
        if ($event->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'You are not authorized to delete this event.',
            ], 403);
        }

        $event->delete();

        return response()->json(null, 204);
    }
}
