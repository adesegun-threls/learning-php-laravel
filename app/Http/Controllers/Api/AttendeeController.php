<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Http\Request;

class AttendeeController extends Controller
{
    /**
     * Display a listing of attendees for an event.
     */
    public function index(Event $event)
    {
        $attendees = $event->attendees()->with('user:id,name,email')->get();

        return response()->json($attendees);
    }

    /**
     * Register the authenticated user as an attendee.
     */
    public function store(Request $request, Event $event)
    {
        // Check if user is already attending
        $existingAttendee = $event->attendees()
            ->where('user_id', $request->user()->id)
            ->first();

        if ($existingAttendee) {
            return response()->json([
                'message' => 'You are already registered for this event.',
            ], 422);
        }

        $attendee = $event->attendees()->create([
            'user_id' => $request->user()->id,
        ]);

        return response()->json(
            $attendee->load('user:id,name,email'),
            201
        );
    }

    /**
     * Remove the authenticated user's attendance.
     */
    public function destroy(Request $request, Event $event, Attendee $attendee)
    {
        // Verify the attendee belongs to this event
        if ($attendee->event_id !== $event->id) {
            return response()->json([
                'message' => 'Attendee not found for this event.',
            ], 404);
        }

        // Only the attendee themselves can cancel their attendance
        if ($attendee->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'You are not authorized to remove this attendee.',
            ], 403);
        }

        $attendee->delete();

        return response()->json(null, 204);
    }
}
