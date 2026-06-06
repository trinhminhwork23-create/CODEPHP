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

    public function index()
    {
        $rooms = Room::with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        $categories = Category::where('status', 1)->orderBy('name')->get();

        return view('rooms.index', compact('rooms', 'categories'));
    }

    public function search(Request $request)
    {
        if ($request->has('check_in')) {
            $request->merge(['check_in' => $this->parseDate($request->check_in)]);
        }
        if ($request->has('check_out')) {
            $request->merge(['check_out' => $this->parseDate($request->check_out)]);
        }

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

        $rooms = Room::with('category')
            ->whereDoesntHave('bookings', function ($q) use ($request) {
                $q->whereNotIn('status', [\App\Models\Booking::STATUS_CANCELLED])
                  ->where('check_in', '<', $request->check_out)
                  ->where('check_out', '>', $request->check_in);
            })
            ->when($request->filled('adults'), function ($q) use ($request) {
                $q->where('capacity', '>=', $request->adults);
            })
            ->orderBy('price')
            ->paginate(6)
            ->appends($request->only(['check_in', 'check_out', 'adults', 'children']));

        $categories = Category::where('status', 1)->orderBy('name')->get();

        return view('rooms.index', compact('rooms', 'categories'));
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

        return view('rooms.show', compact('room', 'avgRating'));
    }
}
