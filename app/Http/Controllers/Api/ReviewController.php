<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Booking;

class ReviewController extends Controller
{
    public function review(Request $request)
    {
        $user = auth()->user();

        if ($user->role === 'user') {

            $request->validate([
                'booking_id' => 'required',
                'specialist_id' => 'required',
                'specialist_type' => 'required',
                'rating' => 'required',
                'review' => 'nullable',
            ]);

            $booking = Booking::find($request->booking_id);

            if (!$booking) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Booking not found',
                ], 404);
            }

            $review = Review::create([
                'booking_id' => $request->booking_id,
                'user_id' => auth()->user()->id,
                'specialist_id' => $request->specialist_id,
                'specialist_type' => $request->specialist_type,
                'rating' => $request->rating,
                'review' => $request->review,
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Review created successfully',
            ], 200);
        }
    }

    public function getSpecialistReview()
    {

       $user = auth()->user();
       $reviews = Review::with('user:id,name')->where('specialist_id', $user->id)->whereNotIn('specialist_type', ['agency-employee', 'institution-nurse'])->orderBy('id', 'desc')->get();

        return response()->json([
            'status' => 200,
            'message' => 'Review get successfully',
            'data' => $reviews,
        ], 200);

    }


}
