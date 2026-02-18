<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Booking;

class DashboardController extends Controller
{

    public function index()
    {
        $booking = Booking::count();
        $user = User::where('role', 'user')->where('is_profile_completed', true)->count();
        $nurse = User::where('role', 'specialist')->where('subRole', 'nurse')->where('is_profile_completed', true)->count();
        $houseManager = User::where('role', 'specialist')->where('subRole', 'house-manager')->where('is_profile_completed', true)->count();
        $physiotherapist = User::where('role', 'specialist')->where('subRole', 'physiotherapist')->where('is_profile_completed', true)->count();
        $nurseAide = User::where('role', 'specialist')->where('subRole', 'nurse-aide-or-assistant')->where('is_profile_completed', true)->count();
        $caregiver = User::where('role', 'specialist')->where('subRole', 'special-need-caregivers')->where('is_profile_completed', true)->count();
        $agency = User::where('role', 'agency')->where('is_profile_completed', true)->count();
        $careInstitution = User::where('role', 'care_institutions')->where('is_profile_completed', true)->count();
        $users = User::where('is_profile_verified', true)->select('id', 'name', 'email')->get();
        return Inertia::render('Dashboard', [
            'users' => $users,
            'booking' => $booking,
            'user' => $user,
            'nurse' => $nurse,
            'houseManager' => $houseManager,
            'physiotherapist' => $physiotherapist,
            'nurseAide' => $nurseAide,
            'caregiver' => $caregiver,
            'agency' => $agency,
            'careInstitution' => $careInstitution,
        ]);
    }
}
