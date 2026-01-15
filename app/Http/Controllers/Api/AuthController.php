<?php

namespace App\Http\Controllers\Api;

use App\Helpers\FileUpload;
use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\HouseManager;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required_if:role,user|string|max:255',
            'email' => 'required|email|unique:users',
            'number' => 'required|string|unique:users',
            'password' => 'required|min:8',
            'role' => 'required|in:user,specialist,agency,care_institutions',
            'subRole' => [
                'required_if:role,specialist',
                'nullable',
                'in:house-manager,nurse,physiotherapist,nurse-aide-or-assistant,special-need-caregivers',
            ],
        ]);

        $otp = random_int(100000, 999999);

        $user = User::create([
            'name' => $request->role === 'user' ? $request->name : null,
            'email' => $request->email,
            'number' => $request->number,
            'password' => Hash::make($request->password),
            // 'otp' => $otp,
            'otp' => 123456,
            'role' => $request->role,
            'subRole' => $request->role === 'specialist'
                ? $request->subRole
                : null,
        ]);

        // Mail::to($user->email)->send(new OtpMail($otp));

        return response()->json([
            'status' => true,
            'message' => 'OTP sent to your email successfully.',
        ], 201);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
            ], 404);
        }

        if ((int) $user->otp !== (int) $request->otp) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid OTP',
            ], 400);
        }

        $user->email_verified_at = now();
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Email verified successfully',
        ], 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->where('email_verified_at', '!=', null)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials',
            ], 401);
        }

        return response()->json([
            'status' => true,
            'message' => 'Login successful',
            'data' => [
                'token' => $user->createToken('auth_token')->plainTextToken,
            ],
        ], 200);

    }

    public function create_profile(Request $request)
    {

        $user = auth()->user();

        if ($user->role == 'specialist') {

            if ($user->subRole == 'house-manager') {

                $request->validate([

                    'name' => 'required|string|max:255',
                    'education' => 'required|string|max:255',
                    'experience' => 'required|string|max:255',
                    'location' => 'required|string|max:255',
                    // 'languages' => 'required|array|min:1',
                    'phone' => 'required|digits:10',
                    'idCopy' => 'required|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'profilePhoto' => 'required|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'drivingLicense' => 'required|mimes:pdf,jpg,jpeg,png,webp|max:2048',

                ]);

                $idCopy = null;
                if ($request->hasFile('idCopy')) {
                    $idCopy = FileUpload::storeFile($request->file('idCopy'), 'uploads/house-manager');
                }

                $profilePhoto = null;
                if ($request->hasFile('profilePhoto')) {
                    $profilePhoto = FileUpload::storeFile($request->file('profilePhoto'), 'uploads/house-manager');
                }

                $drivingLicense = null;
                if ($request->hasFile('drivingLicense')) {
                    $drivingLicense = FileUpload::storeFile($request->file('drivingLicense'), 'uploads/house-manager');
                }

                $user->update([
                    'name' => $request->name,
                    'education' => $request->education,
                    'experience' => $request->experience,
                    'location' => $request->location,
                    'languages' => json_encode($request->languages),
                    'number' => $request->phone,
                    'idCopy' => $idCopy,
                    'profilePhoto' => $profilePhoto,
                    'drivingLicense' => $drivingLicense,
                ]);

                $request->validate([

                    'salaryRange' => 'required|string|max:255',
                    'serviceOffered' => 'required|string|max:255',
                    'isMother' => 'required|boolean',
                    'ageOfKids' => 'required|string|max:255',
                    'isHandelingPet' => 'required|boolean',
                    'preferBeingA' => 'required|string|max:255',
                    'firstAidCertificate' => 'required|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'goodConductCertificate' => 'required|mimes:pdf,jpg,jpeg,png,webp|max:2048',

                ]);

                $houseManager = new HouseManager;
                $houseManager->user_id = $user->id;
                $houseManager->experience = $request->experience;
                $houseManager->experienceYear = $request->experienceYear;
                $houseManager->salaryRange = $request->salaryRange;
                $houseManager->serviceOffered = $request->serviceOffered;
                $houseManager->isMother = $request->isMother;
                $houseManager->ageOfKids = $request->ageOfKids;
                $houseManager->isHandelingPet = $request->isHandelingPet;
                $houseManager->preferBeingA = $request->preferBeingA;

                if ($request->hasFile('firstAidCertificate')) {
                    $file = FileUpload::storeFile($request->file('firstAidCertificate'), 'uploads/house-manager');
                    $houseManager->firstAidCertificate = $file;
                }
                if ($request->hasFile('goodConductCertificate')) {
                    $file = FileUpload::storeFile($request->file('goodConductCertificate'), 'uploads/house-manager');
                    $houseManager->goodConductCertificate = $file;
                }

                $houseManager->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Profile created successfully',
                ], 200);

            }

            if ($user->subRole === 'nurse') {

            }

        } elseif ($user->role === 'agency') {

        } elseif ($user->role === 'care_institutions') {

        }

    }
}
