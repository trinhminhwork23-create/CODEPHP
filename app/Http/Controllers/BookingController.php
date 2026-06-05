<?php

namespace App\Http\Controllers;

class BookingController
{
    public function checkout($room)
    {
        return view('bookings.checkout');
    }

    public function store()
    {
        //
    }

    public function cancel($booking)
    {
        //
    }

    public function success()
    {
        return view('bookings.success');
    }

    public function history()
    {
        return view('profile.history');
    }
}
