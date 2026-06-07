<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Category;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    private function parseDate($dateStr)
    {
        if (!$dateStr) return null;
        
        $formats = ['j F, Y', 'd/m/Y', 'Y-m-d', 'd-m-Y', 'j M, Y'];
        foreach ($formats as $format) {
            try {
                return \Carbon\Carbon::createFromFormat($format, trim($dateStr))->format('Y-m-d');
            } catch (\Exception $e) {
                // Ignore and try next format
            }
        }
        
        try {
            return \Carbon\Carbon::parse($dateStr)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    public function index(Request $request)
    {
        // 🎯 UNIFIED QUERY: Handle both direct access AND homepage search redirect
        $query = Room::with('category');

        // ── Capacity-Based Filtering ──────────────────────────────
        $adults = (int) $request->get('adults', 0);
        $children = (int) $request->get('children', 0);
        $totalGuests = $adults + $children;

        if ($totalGuests > 0) {
            // Filter rooms by capacity (your database column: 'capacity')
            $query->where('capacity', '>=', $totalGuests);
        }

        // ── Date-Based Availability Filtering (Optional) ──────────────────
        if ($request->filled('check_in') && $request->filled('check_out')) {
            $checkIn = $this->parseDate($request->check_in);
            $checkOut = $this->parseDate($request->check_out);

            if ($checkIn && $checkOut) {
                $query->whereDoesntHave('bookings', function ($q) use ($checkIn, $checkOut) {
                    $q->whereNotIn('status', [\App\Models\Booking::STATUS_CANCELLED])
                      ->where('check_in', '<', $checkOut)
                      ->where('check_out', '>', $checkIn);
                });
            }
        }

        $rooms = $query->orderBy('created_at', 'desc')
            ->paginate(6)
            ->appends($request->only(['adults', 'children', 'check_in', 'check_out']));

        $categories = Category::where('status', 1)->orderBy('name')->get();

        return view('rooms.index', compact('rooms', 'categories'));
    }

    public function search(Request $request)
    {
        // ── Normalize Date Formats ────────────────────────────────
        if ($request->has('check_in')) {
            $request->merge(['check_in' => $this->parseDate($request->check_in)]);
        }
        if ($request->has('check_out')) {
            $request->merge(['check_out' => $this->parseDate($request->check_out)]);
        }

        // ── Validate Date Inputs ─────────────────────────────────
        $request->validate([
            'check_in'  => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
        ], [
            'check_in.required'          => 'Vui lòng chọn ngày nhận phòng.',
            'check_in.date'              => 'Ngày nhận phòng không hợp lệ.',
            'check_in.after_or_equal'    => 'Ngày nhận phòng phải từ hôm nay trở đi.',
            'check_out.required'         => 'Vui lòng chọn ngày trả phòng.',
            'check_out.date'             => 'Ngày trả phòng không hợp lệ.',
            'check_out.after'            => 'Ngày trả phòng phải sau ngày nhận phòng.',
        ]);

        // ── REDIRECT TO INDEX WITH QUERY PARAMS ───────────────────────
        // Leverage the unified index() method instead of duplicating logic
        return redirect()->route('rooms.index', $request->only(['check_in', 'check_out', 'adults', 'children']));
    }

    public function show($room)
    {
        $room = Room::with([
            'category',
            'reviews' => function ($q) {
                $q->where('status', \App\Models\Review::STATUS_VISIBLE)
                  ->with('user')
                  ->latest();
            },
        ])->findOrFail($room);

        $avgRating = $room->reviews->avg('rating');

        // Check if current user has completed stay at this room
        $hasCompletedStay = false;
        if (\Auth::check()) {
            $hasCompletedStay = \App\Models\Booking::where('user_id', \Auth::id())
                ->where('room_id', $room->id)
                ->where('status', \App\Models\Booking::STATUS_COMPLETED)
                ->exists();
        }

        return view('rooms.show', compact('room', 'avgRating', 'hasCompletedStay'));
    }

    public function getSuggestions(Request $request)
    {
        $query = $request->get('query', '');
        
        if (strlen($query) < 1) {
            return response()->json([]);
        }

        $rooms = Room::where('name', 'LIKE', '%' . $query . '%')
            ->limit(5)
            ->get(['id', 'name']);

        return response()->json($rooms);
    }
}
