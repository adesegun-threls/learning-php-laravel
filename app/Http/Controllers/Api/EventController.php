<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="Event Management API",
 *     version="1.0.0",
 *     description="API for managing events and attendees",
 *     @OA\Contact(
 *         email="support@example.com"
 *     )
 * )
 * @OA\Server(
 *     url="http://localhost:8000/api",
 *     description="Local Development Server"
 * )
 * @OA\SecurityScheme(
 *     type="http",
 *     securityScheme="sanctum",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Enter token as: Bearer {token}"
 * )
 */
class EventController extends Controller
{
    /**
     * Display a listing of events.
     * 
     * @OA\Get(
     *     path="/events",
     *     summary="Get all events",
     *     description="Returns list of all events with creator and attendee counts",
     *     tags={"Events"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Event")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     )
     * )
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
     * 
     * @OA\Post(
     *     path="/events",
     *     summary="Create a new event",
     *     description="Creates a new event for the authenticated user",
     *     tags={"Events"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","start_time"},
     *             @OA\Property(property="name", type="string", maxLength=255, example="Laravel Conference 2025"),
     *             @OA\Property(property="description", type="string", nullable=true, example="Annual Laravel developer conference"),
     *             @OA\Property(property="start_time", type="string", format="date-time", example="2025-12-01 09:00:00"),
     *             @OA\Property(property="end_time", type="string", format="date-time", nullable=true, example="2025-12-01 17:00:00")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Event created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Event")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
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
     * 
     * @OA\Get(
     *     path="/events/{id}",
     *     summary="Get a single event",
     *     description="Returns detailed information about a specific event",
     *     tags={"Events"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Event ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Event")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Event not found"
     *     )
     * )
     */
    public function show(Event $event)
    {
        return response()->json(
            $event->load('user:id,name,email', 'attendees.user:id,name')
        );
    }

    /**
     * Update the specified event.
     * 
     * @OA\Put(
     *     path="/events/{id}",
     *     summary="Update an event",
     *     description="Updates an event (only by creator)",
     *     tags={"Events"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Event ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", maxLength=255, example="Updated Event Name"),
     *             @OA\Property(property="description", type="string", nullable=true, example="Updated description"),
     *             @OA\Property(property="start_time", type="string", format="date-time", example="2025-12-01 10:00:00"),
     *             @OA\Property(property="end_time", type="string", format="date-time", nullable=true, example="2025-12-01 18:00:00")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Event updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Event")
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Not authorized to update this event"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Event not found"
     *     )
     * )
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
     * 
     * @OA\Delete(
     *     path="/events/{id}",
     *     summary="Delete an event",
     *     description="Deletes an event (only by creator)",
     *     tags={"Events"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Event ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Event deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Not authorized to delete this event"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Event not found"
     *     )
     * )
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
