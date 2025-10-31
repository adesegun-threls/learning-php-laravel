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
     * 
     * @OA\Get(
     *     path="/events/{event}/attendees",
     *     summary="Get event attendees",
     *     description="Returns all attendees for a specific event",
     *     tags={"Attendees"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="event",
     *         in="path",
     *         description="Event ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Attendee")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Event not found"
     *     )
     * )
     */
    public function index(Event $event)
    {
        $attendees = $event->attendees()->with('user:id,name,email')->get();

        return response()->json($attendees);
    }

    /**
     * Register the authenticated user as an attendee.
     * 
     * @OA\Post(
     *     path="/events/{event}/attendees",
     *     summary="Register for event",
     *     description="Register the authenticated user as an attendee for an event",
     *     tags={"Attendees"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="event",
     *         in="path",
     *         description="Event ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successfully registered",
     *         @OA\JsonContent(ref="#/components/schemas/Attendee")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Already registered for this event"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Event not found"
     *     )
     * )
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
     * 
     * @OA\Delete(
     *     path="/events/{event}/attendees/{attendee}",
     *     summary="Cancel event registration",
     *     description="Cancel the authenticated user's attendance for an event",
     *     tags={"Attendees"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="event",
     *         in="path",
     *         description="Event ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="attendee",
     *         in="path",
     *         description="Attendee ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Successfully cancelled registration"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Not authorized to cancel this registration"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Event or attendee not found"
     *     )
     * )
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
