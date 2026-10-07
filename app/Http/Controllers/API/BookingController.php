<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('user_id', auth()->id())
            ->with(['mentor.user', 'mentor.category'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($bookings);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mentor_id' => 'required|exists:mentors,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'duration_hours' => 'required|integer|min:1|max:8',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $mentor = Mentor::findOrFail($request->mentor_id);

        $startTime = Carbon::parse($request->start_time);
        $endTime = $startTime->copy()->addHours($request->duration_hours);
        $totalPrice = $mentor->hourly_rate * $request->duration_hours;

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'mentor_id' => $request->mentor_id,
            'booking_date' => $request->booking_date,
            'start_time' => $request->start_time,
            'end_time' => $endTime->format('H:i'),
            'duration_hours' => $request->duration_hours,
            'total_price' => $totalPrice,
            'notes' => $request->notes,
        ]);

        $mentor->increment('total_students');

        return response()->json($booking->load(['mentor.user', 'mentor.category']), 201);
    }

    public function show($uuid)
    {
        $booking = Booking::where('uuid', $uuid)
            ->with(['mentor.user', 'mentor.category'])
            ->firstOrFail();

        if ($booking->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($booking);
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::with(['mentor'])->findOrFail($id);

        
        if ($booking->user_id !== auth()->id() && $booking->mentor->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'sometimes|in:pending,confirmed,completed,cancelled',
            'notes' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $booking->update($request->all());
        return response()->json($booking->load(['mentor.user', 'mentor.category', 'user']));
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $booking->delete();
        return response()->json(['message' => 'Booking deleted successfully']);
    }
}
