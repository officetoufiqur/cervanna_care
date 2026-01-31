<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Price;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user:id,name', 'specialist:id,name'])->get();

        return Inertia::render('Booking/Index', [
            'bookings' => $bookings,
        ]);
    }

    public function edit($id)
    {
      $booking = Booking::with(['user:id,name', 'price:id,name,price', 'specialist:id,name'])->find($id);      
        return Inertia::render('Booking/Edit', [
            'booking' => $booking,
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $booking = Booking::find($id);
        $booking->update([
            'booking_status' => $request->booking_status,
        ]);

        return redirect()->route('booking.index')->with('message', 'Booking status updated successfully');
    }
}
