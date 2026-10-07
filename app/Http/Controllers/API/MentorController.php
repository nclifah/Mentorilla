<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MentorController extends Controller
{
    public function index(Request $request)
    {
        $query = Mentor::with(['user', 'category']);

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhere('specialization', 'like', "%{$search}%");
            });
        }

        $mentors = $query->get();
        return response()->json($mentors);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'specialization' => 'required|string',
            'bio' => 'required|string',
            'experience_years' => 'required|integer|min:0',
            'hourly_rate' => 'required|numeric|min:0',
            'education' => 'required|string',
            'photo' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $mentor = Mentor::create([
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'specialization' => $request->specialization,
            'bio' => $request->bio,
            'experience_years' => $request->experience_years,
            'hourly_rate' => $request->hourly_rate,
            'education' => $request->education,
            'photo' => $request->photo,
        ]);

        return response()->json($mentor->load(['user', 'category']), 201);
    }

    public function show($uuid)
    {
        $mentor = Mentor::where('uuid', $uuid)
            ->with(['user', 'category', 'bookings.user'])
            ->firstOrFail();
        return response()->json($mentor);
    }

    public function update(Request $request, $id)
    {
        $mentor = Mentor::findOrFail($id);

        if ($mentor->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'category_id' => 'sometimes|exists:categories,id',
            'specialization' => 'sometimes|string',
            'bio' => 'sometimes|string',
            'experience_years' => 'sometimes|integer|min:0',
            'hourly_rate' => 'sometimes|numeric|min:0',
            'education' => 'sometimes|string',
            'photo' => 'nullable|string',
            'status' => 'sometimes|in:available,busy,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $mentor->update($request->all());
        return response()->json($mentor->load(['user', 'category']));
    }

    public function destroy($id)
    {
        $mentor = Mentor::findOrFail($id);

        if ($mentor->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $mentor->delete();
        return response()->json(['message' => 'Mentor deleted successfully']);
    }
}
