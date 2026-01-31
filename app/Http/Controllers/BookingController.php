<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Inertia\Inertia;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('user')->get();

        return Inertia::render('Booking/Index', [
            'bookings' => $bookings,
        ]);
    }
}
