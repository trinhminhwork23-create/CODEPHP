<?php

namespace App\Http\Controllers;

class RoomController
{
    public function index()
    {
        return view('rooms.index');
    }

    public function search()
    {
        return view('rooms.index');
    }

    public function show($room)
    {
        return view('rooms.show');
    }
}
