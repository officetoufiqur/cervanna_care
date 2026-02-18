<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Schedule;
use App\Notifications\UserNotification;

class BookingController extends Controller
{
    public function booking(Request $request)
    {
        $user = auth()->user();

        if ($user->role === 'user') {

            $request->validate([

                'specialist_id' => 'required',
                'specialist_type' => 'required',
                'patient_name' => 'required',
                'patient_age' => 'required',
                'patient_gender' => 'required',
                'relationship_to_booking_person' => 'required',
                'booking_amount' => 'required',
                'booking_type' => 'required',
                'selected_dates_or_months' => 'required',
                'patient_have_any_others_conditions' => 'nullable',
                'patient_have_any_conditions' => 'required',
                'patient_currently_on_medication' => 'boolean',
                'patient_currently_on_medication_data' => 'nullable',
                'prescription_file' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                'patient_have_any_known_allergies' => 'required',
                'patient_have_any_known_allergies_details' => 'nullable',
                'mobility_status_of_patient' => 'required',
                'location_of_care' => 'required',
                'emergency_contact_name' => 'required',
                'emergency_contact_number' => 'required',
                'primary_doctor_name' => 'required',
                'primary_doctor_number' => 'required',
                'primary_hospital' => 'required',

            ]);

 
            $prescription_file = null;

            if ($request->file('prescription_file')) {
                $prescription_file = $request->file('prescription_file')
                    ->store('uploads/bookings', 'public');
            }

            $booking = Booking::create([

                'specialist_id' => $request->specialist_id,
                'specialist_type' => $request->specialist_type,
                'patient_name' => $request->patient_name,
                'patient_age' => $request->patient_age,
                'booking_person_id' => $user->id,
                'patient_gender' => $request->patient_gender,
                'relationship_to_booking_person' => $request->relationship_to_booking_person,
                'booking_amount' => $request->booking_amount,
                'booking_type' => $request->booking_type,
                'selected_dates_or_months' => $request->selected_dates_or_months,
                'patient_have_any_others_conditions' => $request->patient_have_any_others_conditions,
                'patient_have_any_conditions' => $request->patient_have_any_conditions,
                'patient_currently_on_medication' => $request->patient_currently_on_medication,
                'patient_currently_on_medication_data' => $request->patient_currently_on_medication_data,
                'prescription_file' => $prescription_file,
                'patient_have_any_known_allergies' => $request->patient_have_any_known_allergies,
                'patient_have_any_known_allergies_details' => $request->patient_have_any_known_allergies_details,
                'mobility_status_of_patient' => $request->mobility_status_of_patient,
                'location_of_care' => $request->location_of_care,
                'emergency_contact_name' => $request->emergency_contact_name,
                'emergency_contact_number' => $request->emergency_contact_number,
                'primary_doctor_name' => $request->primary_doctor_name,
                'primary_doctor_number' => $request->primary_doctor_number,
                'primary_hospital' => $request->primary_hospital,

            ]);

            $user->notify(new UserNotification('Specialist booking successfull', $user->specialist_id, $user->id));

            return response()->json([
                'status' => 200,
                'message' => 'Booking created successfully',
            ], 200);
        }
    }

    public function getBooking(Request $request)
    {
        $user = auth()->user();

        if ($user->role === 'user') {
            $bookings = Booking::with(['specialist:id,name','user:id,name'])->withCount('review')->where('booking_person_id', $user->id)->get();
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

            $bookings = Booking::with(['specialist:id,name','user:id,name'])->withCount('review')->where('specialist_id', $user->id)->get();
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

    public function updateBookingStatus(Request $request, $id)
    {
        $user = auth()->user();

        if ($user->role !== 'specialist') {
            return response()->json([
                'status' => 401,
                'message' => 'You are not authorized to access this resource',
            ], 401);
        }

        $request->validate([
            'booking_status' => 'required|in:pending,accepted,rejected,completed',
        ]);

        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json([
                'status' => 404,
                'message' => 'Booking not found',
            ], 404);
        }

        if ($booking->specialist_id != $user->id) {
            return response()->json([
                'status' => 403,
                'message' => 'You cannot update this booking',
            ], 403);
        }

        $booking->update([
            'booking_status' => $request->booking_status,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Booking updated successfully',
        ], 200);
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

    public function storeOrUpdate(Request $request)
    {
        $specialistId = auth()->id(); 

        $request->validate([
            'specialist_type' => 'nullable|string',
            'date'           => 'required|array',
            'date.*'         => 'date',
        ]);

        $schedule = Schedule::updateOrCreate(
            [
                'specialist_id' => $specialistId,
            ],
            [
                'specialist_type' => $request->specialist_type,
                'date' => $request->date, 
            ]
        );

        return response()->json([
            'status' => 200,
            'message' => 'Schedule saved successfully',
        ], 200);
    }

}
