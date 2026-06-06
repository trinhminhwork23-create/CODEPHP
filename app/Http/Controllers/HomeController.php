<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $featuredRooms = Room::with('category')
            ->latest()
            ->take(4)
            ->get();

        $categories = Category::where('status', 1)
            ->orderBy('name')
            ->get();

        return view('home', compact('featuredRooms', 'categories'));
    }
}
