<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Notifications\UserNotification;

class BookingController extends Controller
{
    public function booking(Request $request)
    {
        $user = auth()->user();

        if ($user->role === 'user') {

            $request->validate([

                'specialist_id' => 'required',
                'patient_name' => 'required',
                'patient_age' => 'required',
                'patient_gender' => 'required',
                'patient_currently_on_medication_data' => 'nullable',
                'patient_have_any_known_allergies_details' => 'nullable',
                'relationship_to_booking_person' => 'required',
                'price_id' => 'required',
                'booking_amount' => 'required',
                'patient_have_any_conditions' => 'nullable',
                'patient_currently_on_medication' => 'nullable',
                'patient_have_any_known_allergies' => 'nullable',
                'mobility_status_of_patient' => 'required',
                'care_start_date' => 'required',
                'care_end_date' => 'required',
                'location_of_care' => 'required',
                'emergency_contact_name' => 'required',
                'emergency_contact_number' => 'required',
                'primary_doctor_name' => 'required',
                'primary_doctor_number' => 'required',
                'primary_hospital' => 'required',

            ]);

            $booking = Booking::create([

                'specialist_id' => $request->specialist_id,
                'booking_person_id' => $user->id,
                'patient_name' => $request->patient_name,
                'patient_age' => $request->patient_age,
                'patient_gender' => $request->patient_gender,
                'patient_currently_on_medication_data' => $request->patient_currently_on_medication_data,
                'patient_have_any_known_allergies_details' => $request->patient_have_any_known_allergies_details,
                'relationship_to_booking_person' => $request->relationship_to_booking_person,
                'price_id' => $request->price_id,
                'booking_amount' => $request->booking_amount,
                'patient_have_any_conditions' => $request->patient_have_any_conditions,
                'patient_currently_on_medication' => $request->patient_currently_on_medication,
                'patient_have_any_known_allergies' => $request->patient_have_any_known_allergies,
                'mobility_status_of_patient' => $request->mobility_status_of_patient,
                'care_start_date' => $request->care_start_date,
                'care_end_date' => $request->care_end_date,
                'location_of_care' => $request->location_of_care,
                'emergency_contact_name' => $request->emergency_contact_name,
                'emergency_contact_number' => $request->emergency_contact_number,
                'primary_doctor_name' => $request->primary_doctor_name,
                'primary_doctor_number' => $request->primary_doctor_number,
                'primary_hospital' => $request->primary_hospital,

            ]);

            $user->notify(new UserNotification('Specialist booking successfull', $user->specialist_id, $user->id));

            return response()->json([
                'status' => 'pending',
                'message' => 'Booking created successfully',
            ], 200);
        }
    }

    public function getBooking(Request $request)
    {
        $user = auth()->user();

        if ($user->role === 'user') {
            $bookings = Booking::with(['specialist:id,name','user:id,name'])->where('booking_person_id', $user->id)->get();
            return response()->json([
                'status' => 'success',
                'message' => 'Bookings fetched successfully',
                'data' => $bookings,
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not authorized to access this resource',
            ], 401);
        }
    }

    public function getSpecialistBooking(Request $request)
    {
        $user = auth()->user();

        if ($user->role === 'specialist') {

            $bookings = Booking::with(['specialist:id,name','user:id,name'])->where('specialist_id', $user->id)->get();
            return response()->json([
                'status' => 'success',
                'message' => 'Bookings fetched successfully',
                'data' => $bookings,
            ], 200);

        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not authorized to access this resource',
            ], 401);
        }
    }

    public function getSchedule(Request $request)
    {
        $user = auth()->user();

        $schedules = Schedule::with(['user:id,name','timeSlot:id,start_time,end_time'])->where('user_id', $user->id)->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Schedules fetched successfully',
            'data' => $schedules,
            ], 200);
    }
}
