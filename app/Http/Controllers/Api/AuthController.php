<?php

namespace App\Http\Controllers\Api;

use App\Helpers\FileUpload;
use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\Agency;
use App\Models\AgencyEmployee;
use App\Models\Booking;
use App\Models\CareInstitution;
use App\Models\HouseManager;
use App\Models\InstitutionNurse;
use App\Models\Nurse;
use App\Models\NurseAssistant;
use App\Models\Physiotherapist;
use App\Models\SpecialNeed;
use App\Models\Subscribe;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        $user = User::where('email', $request->email)->where('role', '!=', 'admin')->first();

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
        if ($user->role === 'user') {
            $user->is_profile_completed = true;
            $user->is_profile_verified = true;
        }
        
        $user->save();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Email verified successfully',
            'data' => [
                'token' => $token,
                'role' => $user->role,
                'subRole' => $user->subRole,
                'is_profile_completed' => $user->is_profile_completed,
                'is_profile_verified' => $user->is_profile_verified,
            ],
        ], 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->where('role', '!=', 'admin')->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials',
            ], 401);
        }

        if (is_null($user->email_verified_at)) {
            return response()->json([
                'status' => false,
                'message' => 'Please verify your email address',
            ], 403);
        }

        if ($user->is_profile_completed === false) {
            return response()->json([
                'status' => true,
                'message' => 'Profile not completed. Please complete your profile.',
                'data' => [
                    'token' => $user->createToken('auth_token')->plainTextToken,
                    'is_profile_completed' => false,
                    'is_profile_verified' => $user->is_profile_verified,
                    'role' => $user->role,
                    'subRole' => $user->subRole,
                ],
            ], 200);
        }

        return response()->json([
            'status' => true,
            'message' => 'Login successful',
            'data' => [
                'token' => $user->createToken('auth_token')->plainTextToken,
                'is_profile_completed' => true,
                'is_profile_verified' => $user->is_profile_verified,
                'role' => $user->role,
                'subRole' => $user->subRole,
            ],
        ], 200);
    }

    public function create_profile(Request $request)
    {

        $user = auth()->user();

        if ($user->role === 'specialist') {

            if ($user->subRole === 'house-manager') {

                $request->validate([

                    'name' => 'nullable|string|max:255',
                    'education' => 'nullable|string|max:255',
                    'experience' => 'nullable|string|max:255',
                    'location' => 'nullable|string|max:255',
                    'preferredRole' => 'nullable|string|max:255',
                    'languages' => 'nullable|array|min:1',
                    'number_two' => 'nullable',
                    'salaryRange' => 'nullable|string|max:255',
                    'preferred' => 'nullable|array',
                    'isMother' => 'nullable|boolean',
                    'ageOfKids' => 'nullable|array|min:1',
                    'isHandelingPet' => 'nullable|boolean',
                    'preferBeingA' => 'nullable|string|max:255',
                    'idCopy' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'profilePhoto' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'drivingLicense' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'firstAidCertificate' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'goodConductCertificate' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',

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

                $goodConductCertificate = null;
                if ($request->hasFile('goodConductCertificate')) {
                    $goodConductCertificate = FileUpload::storeFile($request->file('goodConductCertificate'), 'uploads/house-manager');
                }

                $user->update([
                    'name' => $request->name,
                    'education' => $request->education,
                    'experience' => $request->experience,
                    'location' => $request->location,
                    'preferredRole' => $request->preferredRole,
                    'languages' => $request->languages,
                    'preferred' => $request->preferred,
                    'number_two' => $request->number_two,
                    'idCopy' => $idCopy,
                    'profilePhoto' => $profilePhoto,
                    'drivingLicense' => $drivingLicense,
                    'goodConductCertificate' => $goodConductCertificate,
                    'is_profile_completed' => true,
                ]);

                $houseManager = HouseManager::firstOrNew([
                    'user_id' => $user->id,
                ]);

                if ($request->hasFile('firstAidCertificate')) {
                    $file = FileUpload::storeFile($request->file('firstAidCertificate'), 'uploads/house-manager');
                    $houseManager->firstAidCertificate = $file;
                }

                $houseManager->fill([

                    'experience' => $request->experience,
                    'experienceYear' => $request->experienceYear,
                    'salaryRange' => $request->salaryRange,
                    'isMother' => $request->isMother,
                    'ageOfKids' => $request->ageOfKids,
                    'isHandelingPet' => $request->isHandelingPet,
                    'preferBeingA' => $request->preferBeingA,

                ]);

                $houseManager->save();

                return response()->json([
                    'is_profile_completed' => $user->is_profile_completed,
                    'is_profile_verified' => false,
                    'message' => 'House Manager Profile created successfully',
                ], 200);

               $user->notify(new UserNotification('Specialist booking successfull', $user->specialist_id, $user->id));

            }

            if ($user->subRole === 'nurse') {

                $request->validate([

                    'name' => 'nullable|string|max:255',
                    'location' => 'nullable|string|max:255',
                    'age' => 'nullable',
                    'experience' => 'nullable|string|max:255',
                    'gender' => 'nullable|string|max:255',
                    'preferredRole' => 'nullable|string|max:255',
                    'languages' => 'nullable|array|min:1',
                    'canDrive' => 'nullable|boolean',
                    'bio' => 'nullable',
                    'education' => 'nullable|string|max:255',
                    'preferred' => 'nullable|array',

                    'hospitalBasedCare' => 'nullable',
                    'hospitalBasedYearsOfExperience' => 'nullable',
                    'hospitalBasedReferenceContact' => 'nullable|string|max:255',

                    'homeBasedCare' => 'nullable',
                    'homeBasedYearsOfExperience' => 'nullable',
                    'homeBasedReferenceContact' => 'nullable|string|max:255',

                    'number_two' => 'nullable',
                    'isNursingInKenya' => 'nullable',
                    'registrationNumber' => 'nullable',
                    'skills' => 'nullable|array|min:1',
                    'mobilityYears' => 'nullable',
                    'bathingYears' => 'nullable',
                    'feedingYears' => 'nullable',
                    'serviceFee' => 'nullable',
                    'serviceFeeDay' => 'nullable',
                    'serviceFeeMonth' => 'nullable',

                    'idCopy' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'profilePhoto' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'practiceLicense' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'goodConductCertificate' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'drivingLicense' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'referenceLetter' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'educationCertificate' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',

                ]);

                $idCopy = null;
                if ($request->hasFile('idCopy')) {
                    $idCopy = FileUpload::storeFile($request->file('idCopy'), 'uploads/nurse');
                }

                $profilePhoto = null;
                if ($request->hasFile('profilePhoto')) {
                    $profilePhoto = FileUpload::storeFile($request->file('profilePhoto'), 'uploads/nurse');
                }

                $drivingLicense = null;
                if ($request->hasFile('drivingLicense')) {
                    $drivingLicense = FileUpload::storeFile($request->file('drivingLicense'), 'uploads/nurse');
                }

                $goodConductCertificate = null;
                if ($request->hasFile('goodConductCertificate')) {
                    $goodConductCertificate = FileUpload::storeFile($request->file('goodConductCertificate'), 'uploads/nurse');
                }

                $referenceLetter = null;
                if ($request->hasFile('referenceLetter')) {
                    $referenceLetter = FileUpload::storeFile($request->file('referenceLetter'), 'uploads/nurse');
                }

                $user->update([

                    'name' => $request->name,
                    'age' => $request->age,
                    'gender' => $request->gender,
                    'preferredRole' => $request->preferredRole,
                    'languages' => $request->languages,
                    'canDrive' => $request->canDrive,
                    'bio' => $request->bio,
                    'education' => $request->education,
                    'location' => $request->location,
                    'number_two' => $request->number_two,
                    'preferred' => $request->preferred,

                    'hospitalBasedCare' => $request->hospitalBasedCare,
                    'hospitalBasedYearsOfExperience' => $request->hospitalBasedYearsOfExperience,
                    'hospitalBasedReferenceContact' => $request->hospitalBasedReferenceContact,

                    'homeBasedCare' => $request->homeBasedCare,
                    'homeBasedYearsOfExperience' => $request->homeBasedYearsOfExperience,
                    'homeBasedReferenceContact' => $request->homeBasedReferenceContact,

                    'idCopy' => $idCopy,
                    'profilePhoto' => $profilePhoto,
                    'goodConductCertificate' => $goodConductCertificate,
                    'drivingLicense' => $drivingLicense,
                    'referenceLetter' => $referenceLetter,
                    'is_profile_completed' => true,
                ]);

                $nurse = Nurse::firstOrNew([
                    'user_id' => $user->id,
                ]);

                $educationCertificate = null;
                if ($request->hasFile('educationCertificate')) {
                    $educationCertificate = FileUpload::storeFile($request->file('educationCertificate'), 'uploads/nurse');
                    $nurse->educationCertificate = $educationCertificate;
                }

                $practiceLicense = null;
                if ($request->hasFile('practiceLicense')) {
                    $practiceLicense = FileUpload::storeFile($request->file('practiceLicense'), 'uploads/nurse');
                    $nurse->practiceLicense = $practiceLicense;
                }

                $nurse->fill([

                    'isNursingInKenya' => $request->isNursingInKenya,
                    'registrationNumber' => $request->registrationNumber,
                    'experience' => $request->experience,
                    'mobilityYears' => $request->mobilityYears,
                    'bathingYears' => $request->bathingYears,
                    'feedingYears' => $request->feedingYears,
                    'serviceFee' => $request->serviceFee,
                    'serviceFeeDay' => $request->serviceFeeDay,
                    'serviceFeeMonth' => $request->serviceFeeMonth,
                    'skills' => $request->skills,

                ]);

                $nurse->save();

                return response()->json([
                    'is_profile_completed' => $user->is_profile_completed,
                    'is_profile_verified' => false,
                    'message' => 'Nurse Profile updated successfully',
                ], 200);
            }

            if ($user->subRole === 'physiotherapist') {

                $request->validate([

                    'name' => 'nullable|string|max:255',
                    'location' => 'nullable|string|max:255',
                    'age' => 'nullable',
                    'experience' => 'nullable|string|max:255',
                    'gender' => 'nullable|string|max:255',
                    'languages' => 'nullable|array|min:1',
                    'canDrive' => 'nullable|boolean',
                    'bio' => 'nullable',
                    'education' => 'nullable|string|max:255',
                    'number_two' => 'nullable',

                    'hospitalBasedCare' => 'nullable',
                    'hospitalBasedYearsOfExperience' => 'nullable',
                    'hospitalBasedReferenceContact' => 'nullable|string|max:255',

                    'homeBasedCare' => 'nullable',
                    'homeBasedYearsOfExperience' => 'nullable',
                    'homeBasedReferenceContact' => 'nullable|string|max:255',
                    'preferred' => 'nullable|array|min:1',
                    'isRegisterPCK' => 'nullable|boolean',
                    'registrationNumber' => 'nullable|string|max:255',
                    'serviceFee' => 'nullable|numeric',
                    'serviceFeeDay' => 'nullable',
                    'serviceFeeMonth' => 'nullable',

                    'idCopy' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'profilePhoto' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'goodConductCertificate' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'drivingLicense' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'referenceLetter' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'eduCertificate' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'practiceLicense' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                ]);

                $idCopy = null;
                if ($request->hasFile('idCopy')) {
                    $idCopy = FileUpload::storeFile($request->file('idCopy'), 'uploads/physiotherapist');
                }

                $profilePhoto = null;
                if ($request->hasFile('profilePhoto')) {
                    $profilePhoto = FileUpload::storeFile($request->file('profilePhoto'), 'uploads/physiotherapist');
                }

                $drivingLicense = null;
                if ($request->hasFile('drivingLicense')) {
                    $drivingLicense = FileUpload::storeFile($request->file('drivingLicense'), 'uploads/physiotherapist');
                }

                $goodConductCertificate = null;
                if ($request->hasFile('goodConductCertificate')) {
                    $goodConductCertificate = FileUpload::storeFile($request->file('goodConductCertificate'), 'uploads/physiotherapist');
                }

                $referenceLetter = null;
                if ($request->hasFile('referenceLetter')) {
                    $referenceLetter = FileUpload::storeFile($request->file('referenceLetter'), 'uploads/physiotherapist');
                }

                $user->update([

                    'name' => $request->name,
                    'age' => $request->age,
                    'gender' => $request->gender,
                    'languages' => $request->languages,
                    'canDrive' => $request->canDrive,
                    'bio' => $request->bio,
                    'education' => $request->education,
                    'location' => $request->location,
                    'preferred' => $request->preferred,
                    'number_two' => $request->number_two,

                    'hospitalBasedCare' => $request->hospitalBasedCare,
                    'hospitalBasedYearsOfExperience' => $request->hospitalBasedYearsOfExperience,
                    'hospitalBasedReferenceContact' => $request->hospitalBasedReferenceContact,

                    'homeBasedCare' => $request->homeBasedCare,
                    'homeBasedYearsOfExperience' => $request->homeBasedYearsOfExperience,
                    'homeBasedReferenceContact' => $request->homeBasedReferenceContact,

                    'idCopy' => $idCopy,
                    'profilePhoto' => $profilePhoto,
                    'goodConductCertificate' => $goodConductCertificate,
                    'drivingLicense' => $drivingLicense,
                    'referenceLetter' => $referenceLetter,
                    'is_profile_completed' => true,
                ]);

                $physiotherapist = Physiotherapist::firstOrNew([
                    'user_id' => $user->id,
                ]);

                $eduCertificate = null;
                if ($request->hasFile('eduCertificate')) {
                    $eduCertificate = FileUpload::storeFile($request->file('eduCertificate'), 'uploads/physiotherapist');
                    $physiotherapist->eduCertificate = $eduCertificate;
                }

                $practiceLicense = null;
                if ($request->hasFile('practiceLicense')) {
                    $practiceLicense = FileUpload::storeFile($request->file('practiceLicense'), 'uploads/physiotherapist');
                    $physiotherapist->practiceLicense = $practiceLicense;

                }

                $physiotherapist->fill([
                    'isRegisterPCK' => $request->isRegisterPCK,
                    'experience' => $request->experience,
                    'registrationNumber' => $request->registrationNumber,
                    'serviceFee' => $request->serviceFee,
                    'serviceFeeMonth' => $request->serviceFeeMonth,
                    'serviceFeeDay' => $request->serviceFeeDay,
                ]);

                $physiotherapist->save();

                return response()->json([
                    'is_profile_completed' => $user->is_profile_completed,
                    'is_profile_verified' => false,
                    'message' => 'Physiotherapist Profile updated successfully',
                ], 200);
            }

            if ($user->subRole === 'nurse-aide-or-assistant') {

                $request->validate([

                    'name' => 'nullable',
                    'location' => 'nullable',
                    'age' => 'nullable',
                    'experience' => 'nullable',
                    'gender' => 'nullable',
                    'languages' => 'nullable',
                    'canDrive' => 'nullable',
                    'bio' => 'nullable',
                    'education' => 'nullable',
                    'hospitalBasedCare' => 'nullable',
                    'hospitalBasedYearsOfExperience' => 'nullable',
                    'hospitalBasedReferenceContact' => 'nullable',
                    'homeBasedCare' => 'nullable',
                    'homeBasedYearsOfExperience' => 'nullable',
                    'homeBasedReferenceContact' => 'nullable',
                    'preferred' => 'nullable',

                    'number_two' => 'nullable',
                    'skills' => 'nullable',
                    'mobilityYears' => 'nullable',
                    'bathingYears' => 'nullable',
                    'feedingYears' => 'nullable',
                    'serviceFee' => 'nullable',
                    'serviceFeeDay' => 'nullable',
                    'serviceFeeMonth' => 'nullable',

                    'idCopy' => 'nullable',
                    'profilePhoto' => 'nullable',
                    'goodConductCertificate' => 'nullable',
                    'drivingLicense' => 'nullable',
                    'referenceLetter' => 'nullable',
                    'educationCertificate' => 'nullable',

                ]);

                $idCopy = null;
                if ($request->hasFile('idCopy')) {
                    $idCopy = FileUpload::storeFile($request->file('idCopy'), 'uploads/nurse_assistant');
                }

                $profilePhoto = null;
                if ($request->hasFile('profilePhoto')) {
                    $profilePhoto = FileUpload::storeFile($request->file('profilePhoto'), 'uploads/nurse_assistant');
                }

                $drivingLicense = null;
                if ($request->hasFile('drivingLicense')) {
                    $drivingLicense = FileUpload::storeFile($request->file('drivingLicense'), 'uploads/nurse_assistant');
                }

                $goodConductCertificate = null;
                if ($request->hasFile('goodConductCertificate')) {
                    $goodConductCertificate = FileUpload::storeFile($request->file('goodConductCertificate'), 'uploads/nurse_assistant');
                }

                $referenceLetter = null;
                if ($request->hasFile('referenceLetter')) {
                    $referenceLetter = FileUpload::storeFile($request->file('referenceLetter'), 'uploads/nurse_assistant');
                }

                $user->update([

                    'name' => $request->name,
                    'age' => $request->age,
                    'experience' => $request->experience,
                    'gender' => $request->gender,
                    'languages' => $request->languages,
                    'canDrive' => $request->canDrive,
                    'bio' => $request->bio,
                    'education' => $request->education,
                    'location' => $request->location,
                    'number_two' => $request->number_two,
                    'preferred' => $request->preferred,

                    'hospitalBasedCare' => $request->hospitalBasedCare,
                    'hospitalBasedYearsOfExperience' => $request->hospitalBasedYearsOfExperience,
                    'hospitalBasedReferenceContact' => $request->hospitalBasedReferenceContact,

                    'homeBasedCare' => $request->homeBasedCare,
                    'homeBasedYearsOfExperience' => $request->homeBasedYearsOfExperience,
                    'homeBasedReferenceContact' => $request->homeBasedReferenceContact,

                    'idCopy' => $idCopy,
                    'profilePhoto' => $profilePhoto,
                    'goodConductCertificate' => $goodConductCertificate,
                    'drivingLicense' => $drivingLicense,
                    'referenceLetter' => $referenceLetter,
                    'is_profile_completed' => true,
                ]);

                $nurse_assistant = NurseAssistant::firstOrNew([
                    'user_id' => $user->id,
                ]);

                $educationCertificate = null;
                if ($request->hasFile('educationCertificate')) {
                    $educationCertificate = FileUpload::storeFile($request->file('educationCertificate'), 'uploads/nurse_assistant');
                    $nurse_assistant->educationCertificate = $educationCertificate;
                }

                $nurse_assistant->fill([

                    'mobilityYears' => $request->mobilityYears,
                    'experience' => $request->experience,
                    'bathingYears' => $request->bathingYears,
                    'feedingYears' => $request->feedingYears,
                    'serviceFee' => $request->serviceFee,
                    'serviceFeeMonth' => $request->serviceFeeMonth,
                    'serviceFeeDay' => $request->serviceFeeDay,
                    'skills' => $request->skills,
                ]);

                $nurse_assistant->save();

                return response()->json([
                    'is_profile_completed' => $user->is_profile_completed,
                    'is_profile_verified' => false,
                    'message' => 'Nurse Ade Assistant Profile updated successfully',
                ], 200);
            }

            if ($user->subRole === 'special-need-caregivers') {

                $request->validate([

                    'name' => 'nullable',
                    'location' => 'nullable',
                    'age' => 'nullable',
                    'number_two' => 'nullable',
                    'experience' => 'nullable',
                    'gender' => 'nullable',
                    'languages' => 'nullable',
                    'canDrive' => 'nullable',
                    'bio' => 'nullable',
                    'education' => 'nullable',
                    'hospitalBasedCare' => 'nullable',
                    'hospitalBasedYearsOfExperience' => 'nullable',
                    'hospitalBasedReferenceContact' => 'nullable',
                    'homeBasedCare' => 'nullable',
                    'homeBasedYearsOfExperience' => 'nullable',
                    'homeBasedReferenceContact' => 'nullable',
                    'preferred' => 'nullable',
                    'isRegisterPCK' => 'nullable',
                    'registrationNumber' => 'nullable',
                    'serviceFee' => 'nullable',
                    'serviceFeeDay' => 'nullable',
                    'serviceFeeMonth' => 'nullable',

                    'idCopy' => 'nullable',
                    'profilePhoto' => 'nullable',
                    'goodConductCertificate' => 'nullable',
                    'drivingLicense' => 'nullable',
                    'referenceLetter' => 'nullable',
                    'educationCertificate' => 'nullable',
                    'practiceLicense' => 'nullable',

                ]);

                $idCopy = null;
                if ($request->hasFile('idCopy')) {
                    $idCopy = FileUpload::storeFile($request->file('idCopy'), 'uploads/specialNeed');
                }

                $profilePhoto = null;
                if ($request->hasFile('profilePhoto')) {
                    $profilePhoto = FileUpload::storeFile($request->file('profilePhoto'), 'uploads/specialNeed');
                }

                $drivingLicense = null;
                if ($request->hasFile('drivingLicense')) {
                    $drivingLicense = FileUpload::storeFile($request->file('drivingLicense'), 'uploads/specialNeed');
                }

                $goodConductCertificate = null;
                if ($request->hasFile('goodConductCertificate')) {
                    $goodConductCertificate = FileUpload::storeFile($request->file('goodConductCertificate'), 'uploads/specialNeed');
                }

                $referenceLetter = null;
                if ($request->hasFile('referenceLetter')) {
                    $referenceLetter = FileUpload::storeFile($request->file('referenceLetter'), 'uploads/specialNeed');
                }

                $user->update([

                    'name' => $request->name,
                    'location' => $request->location,
                    'age' => $request->age,
                    'number_two' => $request->number_two,
                    'gender' => $request->gender,
                    'languages' => $request->languages,
                    'canDrive' => $request->canDrive,
                    'bio' => $request->bio,
                    'education' => $request->education,
                    'hospitalBasedCare' => $request->hospitalBasedCare,
                    'hospitalBasedYearsOfExperience' => $request->hospitalBasedYearsOfExperience,
                    'hospitalBasedReferenceContact' => $request->hospitalBasedReferenceContact,
                    'homeBasedCare' => $request->homeBasedCare,
                    'homeBasedYearsOfExperience' => $request->homeBasedYearsOfExperience,
                    'homeBasedReferenceContact' => $request->homeBasedReferenceContact,
                    'preferred' => $request->preferred,
                    'isRegisterPCK' => $request->isRegisterPCK,
                    'registrationNumber' => $request->registrationNumber,

                    'idCopy' => $idCopy,
                    'profilePhoto' => $profilePhoto,
                    'goodConductCertificate' => $goodConductCertificate,
                    'drivingLicense' => $drivingLicense,
                    'referenceLetter' => $referenceLetter,
                    'is_profile_completed' => true,
                ]);

                $specialNeed = SpecialNeed::firstOrNew([
                    'user_id' => $user->id,
                ]);

                $educationCertificate = null;
                if ($request->hasFile('educationCertificate')) {
                    $educationCertificate = FileUpload::storeFile($request->file('educationCertificate'), 'uploads/specialNeed');
                    $specialNeed->educationCertificate = $educationCertificate;
                }

                $practiceLicense = null;
                if ($request->hasFile('practiceLicense')) {
                    $practiceLicense = FileUpload::storeFile($request->file('practiceLicense'), 'uploads/specialNeed');
                    $specialNeed->practiceLicense = $practiceLicense;
                }

                $specialNeed->fill([

                    'isRegisterPCK' => $request->isRegisterPCK,
                    'experience' => $request->experience,
                    'registrationNumber' => $request->registrationNumber,
                    'serviceFee' => $request->serviceFee,
                    'serviceFeeMonth' => $request->serviceFeeMonth,
                    'serviceFeeDay' => $request->serviceFeeDay,
                ]);

                $specialNeed->save();

                return response()->json([
                    'is_profile_completed' => $user->is_profile_completed,
                    'is_profile_verified' => false,
                    'message' => 'Special Caregiver Profile updated successfully',
                ], 200);
            }

        } elseif ($user->role === 'agency') {

            $request->validate([
                'companyName' => 'nullable',
                'kraPin' => 'nullable',
                'companyRegistrationNumber' => 'nullable',
                'number' => 'nullable',
                'businessLocation' => 'nullable',
                'registrationDocument' => 'nullable',
                'agency_services' => 'nullable',
                'placementFee' => 'nullable',
                'replacementWindow' => 'nullable',
                'numberOfReplacement' => 'nullable',

                'employees' => 'nullable|array|min:1',

                'employees.*.name' => 'nullable',
                'employees.*.educationLevel' => 'nullable',
                'employees.*.location' => 'nullable',
                'employees.*.experience' => 'nullable',
                'employees.*.salaryRange' => 'nullable',
                'employees.*.isMother' => 'nullable',
                'employees.*.kidAges' => 'nullable',
                'employees.*.handlePets' => 'nullable',
                'employees.*.preferredRole' => 'nullable',
                'employees.*.languages' => 'nullable',
                'employees.*.cooking' => 'nullable',
                'employees.*.housekeeping' => 'nullable',
                'employees.*.childcare' => 'nullable',
                'employees.*.liveType' => 'nullable',

                'employees.*.idCopy' => 'nullable',
                'employees.*.profilePhoto' => 'nullable',
                'employees.*.drivingLicense' => 'nullable',
                'employees.*.goodConductCertificate' => 'nullable',
                'employees.*.aidCertificate' => 'nullable',
            ]);

            DB::transaction(function () use ($request, $user) {

                $agency = Agency::firstOrNew([
                    'user_id' => $user->id,
                ]);

                $registrationDocument = null;
                if ($request->hasFile('registrationDocument')) {
                    $registrationDocument = FileUpload::storeFile(
                        $request->file('registrationDocument'),
                        'uploads/agency'
                    );

                    $agency->registrationDocument = $registrationDocument;
                }

                $agency->fill([
                    'companyName' => $request->companyName,
                    'kraPin' => $request->kraPin,
                    'companyRegistrationNumber' => $request->companyRegistrationNumber,
                    'number' => $request->number,
                    'agency_services' => $request->agency_services,
                    'businessLocation' => $request->businessLocation,
                    'placementFee' => $request->placementFee,
                    'replacementWindow' => $request->replacementWindow,
                    'numberOfReplacement' => $request->numberOfReplacement,
                ]);

                $agency->save();

                if ($request->filled('employees')) {

                    foreach ($request->employees as $index => $employeeData) {

                        $employee = new AgencyEmployee;
                        $employee->agency_id = $agency->id;

                        $employee->fill($employeeData);

                        if ($request->hasFile("employees.$index.idCopy")) {
                            $employee->idCopy = FileUpload::storeFile(
                                $request->file("employees.$index.idCopy"),
                                'uploads/employees'
                            );
                        }

                        if ($request->hasFile("employees.$index.profilePhoto")) {
                            $employee->profilePhoto = FileUpload::storeFile(
                                $request->file("employees.$index.profilePhoto"),
                                'uploads/employees'
                            );
                        }

                        if ($request->hasFile("employees.$index.drivingLicense")) {
                            $employee->drivingLicense = FileUpload::storeFile(
                                $request->file("employees.$index.drivingLicense"),
                                'uploads/employees'
                            );
                        }

                        if ($request->hasFile("employees.$index.goodConductCertificate")) {
                            $employee->goodConductCertificate = FileUpload::storeFile(
                                $request->file("employees.$index.goodConductCertificate"),
                                'uploads/employees'
                            );
                        }

                        if ($request->hasFile("employees.$index.aidCertificate")) {
                            $employee->aidCertificate = FileUpload::storeFile(
                                $request->file("employees.$index.aidCertificate"),
                                'uploads/employees'
                            );
                        }

                        $employee->save();
                    }
                }

                $user->update([
                    'is_profile_completed' => true,
                ]);
            });

            return response()->json([
                'is_profile_completed' => $user->is_profile_completed,
                'is_profile_verified' => false,
                'message' => 'Agency profile and employees registered successfully',
            ], 200);

        } elseif ($user->role === 'care_institutions') {
            $request->validate([

                'companyName' => 'nullable|string|max:255',
                'kraPin' => 'nullable|string|max:255',
                'companyRegistrationNumber' => 'nullable|string|max:255',
                'number' => 'nullable|string|max:255',
                'businessLocation' => 'nullable|string|max:255',
                'registrationDocument' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',

                'institutionNurses' => 'nullable|array|min:1',

                'institutionNurses.*.fullName' => 'nullable|string|max:255',
                'institutionNurses.*.age' => 'nullable|integer',
                'institutionNurses.*.location' => 'nullable|string|max:255',
                'institutionNurses.*.experience' => 'nullable|string|max:255',
                'institutionNurses.*.gender' => 'nullable|string|max:255',
                'institutionNurses.*.education' => 'nullable|string|max:255',
                'institutionNurses.*.canDrive' => 'nullable|boolean',
                'institutionNurses.*.preferredRole' => 'nullable|string|max:255',
                'institutionNurses.*.languages' => 'nullable|array|min:1',
                'institutionNurses.*.educationCertificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                'institutionNurses.*.isNursingInKenya' => 'nullable|boolean',
                'institutionNurses.*.practiceLicense' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                'institutionNurses.*.registrationNumber' => 'nullable|string|max:255',
                'institutionNurses.*.hospitalBasedCare' => 'nullable|boolean',
                'institutionNurses.*.services' => 'nullable|array|min:1',
                'institutionNurses.*.hospitalBasedYearsOfExperience' => 'nullable|integer',
                'institutionNurses.*.hospitalBasedReferenceContact' => 'nullable|string|max:255',
                'institutionNurses.*.homeBasedCare' => 'nullable|boolean',
                'institutionNurses.*.homeBasedYearsOfExperience' => 'nullable|integer',
                'institutionNurses.*.homeBasedReferenceContact' => 'nullable|string|max:255',
                'institutionNurses.*.mobilityYears' => 'nullable|string|max:255',
                'institutionNurses.*.bathingYears' => 'nullable|string|max:255',
                'institutionNurses.*.feedingYears' => 'nullable|string|max:255',
                'institutionNurses.*.serviceFee' => 'nullable|integer',
                'institutionNurses.*.serviceFeeDay' => 'nullable',
                'institutionNurses.*.serviceFeeMonth' => 'nullable',
                'institutionNurses.*.bio' => 'nullable|string|max:255',
                'institutionNurses.*.idCopy' => 'nullable|image|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                'institutionNurses.*.profilePhoto' => 'nullable|image|mimes:pdf,jpg,jpeg,png,webp|max:2048',
            ]);

            DB::transaction(function () use ($request, $user) {

                $careInstitution = CareInstitution::firstOrNew([
                    'user_id' => $user->id,
                ]);

                $registrationDocument = null;
                if ($request->hasFile('registrationDocument')) {
                    $registrationDocument = FileUpload::storeFile(
                        $request->file('registrationDocument'),
                        'uploads/careInstitution'
                    );

                    $careInstitution->registrationDocument = $registrationDocument;
                }

                $careInstitution->fill([
                    'companyName' => $request->companyName,
                    'kraPin' => $request->kraPin,
                    'companyRegistrationNumber' => $request->companyRegistrationNumber,
                    'number' => $request->number,
                    'businessLocation' => $request->businessLocation,
                    'placementFee' => $request->placementFee,
                    'replacementWindow' => $request->replacementWindow,
                    'numberOfReplacement' => $request->numberOfReplacement,
                ]);

                $careInstitution->save();

                if ($request->filled('institutionNurses')) {

                    foreach ($request->institutionNurses as $index => $nurseData) {

                        $institutionNurse = new InstitutionNurse;
                        $institutionNurse->care_institution_id = $careInstitution->id;
                        $institutionNurse->fill($nurseData);

                        if ($request->hasFile("practiceLicense.$index")) {
                            $institutionNurse->practiceLicense = FileUpload::storeFile(
                                $request->file("practiceLicense.$index"),
                                'uploads/institutionNurse'
                            );
                        }

                        if ($request->hasFile("institutionNurses.$index.idCopy")) {
                            $institutionNurse->idCopy = FileUpload::storeFile(
                                $request->file("institutionNurses.$index.idCopy"),
                                'uploads/institutionNurse'
                            );
                        }

                        if ($request->hasFile("institutionNurses.$index.profilePhoto")) {
                            $institutionNurse->profilePhoto = FileUpload::storeFile(
                                $request->file("institutionNurses.$index.profilePhoto"),
                                'uploads/institutionNurses'
                            );
                        }

                        if ($request->hasFile("institutionNurses.$index.educationCertificate")) {
                            $institutionNurse->educationCertificate = FileUpload::storeFile(
                                $request->file("institutionNurses.$index.educationCertificate"),
                                'uploads/institutionNurses'
                            );
                        }

                        $institutionNurse->save();
                    }

                }

                $user->update([

                    'is_profile_completed' => true,
                ]);

            });

            return response()->json([
                'message' => 'Care institution profile and nurses registered successfully',
                'is_profile_completed' => $user->is_profile_completed,
                'is_profile_verified' => false,
            ], 200);
        }

    }

    public function logout(Request $request)
    {
        auth()->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logout successful',
        ], 200);
    }

    public function getProfile(Request $request)
    {

        $user = auth()->user();

        if ($user->role === 'user') {

            $user = User::select('id', 'name', 'email', 'number', 'profilePhoto', 'is_profile_completed','location','gender', 'role')->find($user->id);

            return response()->json([
                'status' => true,
                'message' => 'User profile fetched successfully',
                'data' => $user,
            ], 200);
        }

        if ($user->role === 'specialist') {

            if ($user->subRole === 'house-manager') {
                $user = User::with('houseManager')->find($user->id);
                $shedule = Schedule::where('specialist_id', $user->id)->get();

                return response()->json([
                    'status' => true,
                    'message' => 'House manager profile fetched successfully',
                    'houseManager' => $user,
                    'schedule' => $shedule,
                ], 200);
            }

            if ($user->subRole === 'nurse') {
                $user = User::with('nurse')->find($user->id);

                return response()->json([
                    'status' => true,
                    'message' => 'Nurse profile fetched successfully',
                    'nurse' => $user,
                ], 200);
            }

            if ($user->subRole === 'physiotherapist') {
                $user = User::with('physiotherapist')->find($user->id);

                return response()->json([
                    'status' => true,
                    'message' => 'Physiotherapist profile fetched successfully',
                    'physiotherapist' => $user,
                ], 200);
            }

            if ($user->subRole === 'nurse-aide-or-assistant') {
                $user = User::with('nurseAssistant')->find($user->id);

                return response()->json([
                    'status' => true,
                    'message' => 'Nurse assistant profile fetched successfully',
                    'nurseAssistant' => $user,
                ], 200);
            }

            if ($user->subRole === 'special-need-caregivers') {
                $user = User::with('specialNeed')->find($user->id);

                return response()->json([
                    'status' => true,
                    'message' => 'Special need profile fetched successfully',
                    'specialNeed' => $user,
                ], 200);
            }
        }

        if ($user->role === 'agency') {

            $user = User::select('id', 'name','number', 'email', 'is_profile_verified', 'is_profile_completed', 'role')->find($user->id);
            $agency = Agency::where('user_id', $user->id)->first();
            $agencyEmployees = [];
            if($agency){
                $agencyEmployees = AgencyEmployee::where('agency_id', $agency->id)->get();
            }

            return response()->json([
                'status' => true,
                'message' => 'Agency profile fetched successfully',
                'user' => $user,
                'agency' => $agency,
                'agencyEmployees' => $agencyEmployees,
            ], 200);
        }

        if ($user->role === 'care_institutions') {

            $user = User::select('id', 'email', 'number', 'profilePhoto', 'is_profile_completed', 'role')->find($user->id);
            $careInstitution = CareInstitution::where('user_id', $user->id)->first();
            $institutionNurses = [];

            if ($careInstitution) {
                $institutionNurses = InstitutionNurse::where(
                    'care_institution_id',
                    $careInstitution->id
                )->get();
            }

            return response()->json([
                'status' => true,
                'message' => 'Care institution profile fetched successfully',
                'user' => $user,
                'careInstitution' => $careInstitution,
                'institutionNurses' => $institutionNurses,
            ], 200);
        }

    }

    public function updateProfile(Request $request)
    {

        $user = auth()->user();

        if ($user->role === 'user') {

            $request->validate([
                'name' => 'nullable',
                'email' => 'nullable',
                'number' => 'nullable',
                'profilePhoto' => 'nullable',
                'gender' => 'nullable',
                'location' => 'nullable',
            ]);

            if ($request->hasFile('profilePhoto')) {
                $user->profilePhoto = FileUpload::updateFile($request->file('profilePhoto'), 'uploads/user', $user->profilePhoto);
            }

            $user->update([
                'name' => $request->name,
                'email' => $request->email ?? $user->email,
                'number' => $request->number,
                'gender' => $request->gender,
                'location' => $request->location,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User profile updated successfully',
            ], 200);
        }

        if ($user->role === 'specialist') {

            if ($user->subRole === 'house-manager') {

                $request->validate([

                    'name' => 'nullable',
                    'education' => 'nullable',
                    'experience' => 'nullable',
                    'location' => 'nullable',
                    'preferredRole' => 'nullable',
                    'languages' => 'nullable|array|min:1',
                    'number' => 'nullable',
                    'number_two' => 'nullable',
                    'salaryRange' => 'nullable',
                    'serviceOffered' => 'nullable',
                    'isMother' => 'nullable|boolean',
                    'ageOfKids' => 'nullable|array',
                    'isHandelingPet' => 'nullable|boolean',
                    'preferBeingA' => 'nullable',
                    'idCopy' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'profilePhoto' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'drivingLicense' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'firstAidCertificate' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'goodConductCertificate' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',

                ]);

                if ($request->hasFile('idCopy')) {
                    $user->idCopy = FileUpload::updateFile($request->file('idCopy'), 'uploads/house-manager', $user->idCopy);
                }

                if ($request->hasFile('profilePhoto')) {
                    $user->profilePhoto = FileUpload::updateFile($request->file('profilePhoto'), 'uploads/house-manager', $user->profilePhoto);
                }

                if ($request->hasFile('drivingLicense')) {
                    $user->drivingLicense = FileUpload::updateFile($request->file('drivingLicense'), 'uploads/house-manager', $user->drivingLicense);
                }

                $user->update([
                    'name' => $request->name,
                    'education' => $request->education,
                    'location' => $request->location,
                    'preferredRole' => $request->preferredRole,
                    'languages' => $request->languages,
                    'number' => $request->number,
                    'number_two' => $request->number_two,
                    'is_profile_completed' => $user->is_profile_completed,
                    'is_profile_verified' => $user->is_profile_verified,
                ]);

                $houseManager = HouseManager::firstOrNew([
                    'user_id' => $user->id,
                ]);

                if ($request->hasFile('firstAidCertificate')) {
                    $file = FileUpload::updateFile($request->file('firstAidCertificate'), 'uploads/house-manager', $houseManager->firstAidCertificate);
                    $houseManager->firstAidCertificate = $file;
                }

                $houseManager->fill([

                    'experience' => $request->experience,
                    'experienceYear' => $request->experienceYear,
                    'salaryRange' => $request->salaryRange,
                    'serviceOffered' => $request->serviceOffered,
                    'isMother' => $request->isMother,
                    'ageOfKids' => $request->ageOfKids,
                    'isHandelingPet' => $request->isHandelingPet,
                    'preferBeingA' => $request->preferBeingA,

                ]);

                $houseManager->update();

                return response()->json([
                    'is_profile_completed' => $user->is_profile_completed,
                    'is_profile_verified' => $user->is_profile_verified,
                    'message' => 'House Manager Profile updated successfully',
                ], 200);
            }

            if ($user->subRole === 'nurse') {

                $request->validate([

                    'name' => 'nullable',
                    'location' => 'nullable',
                    'age' => 'nullable',
                    'experience' => 'nullable',
                    'gender' => 'nullable',
                    'preferredRole' => 'nullable',
                    'languages' => 'nullable|array',
                    'canDrive' => 'nullable|boolean',
                    'bio' => 'nullable',
                    'education' => 'nullable',
                    'preferred' => 'nullable|array',

                    'hospitalBasedCare' => 'nullable',
                    'hospitalBasedYearsOfExperience' => 'nullable',
                    'hospitalBasedReferenceContact' => 'nullable',

                    'homeBasedCare' => 'nullable',
                    'homeBasedYearsOfExperience' => 'nullable',
                    'homeBasedReferenceContact' => 'nullable',

                    'number_two' => 'nullable',
                    'isNursingInKenya' => 'nullable',
                    'registrationNumber' => 'nullable',
                    'skills' => 'nullable|array',
                    'mobilityYears' => 'nullable',
                    'bathingYears' => 'nullable',
                    'feedingYears' => 'nullable',
                    'serviceFee' => 'nullable',
                    'serviceFeeDay' => 'nullable',
                    'serviceFeeMonth' => 'nullable',

                    'idCopy' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'profilePhoto' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'goodConductCertificate' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'drivingLicense' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'practiceLicense' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'referenceLetter' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'educationCertificate' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',

                ]);


                if ($request->hasFile('idCopy')) {
                    $idCopy = FileUpload::updateFile($request->file('idCopy'), 'uploads/nurse', $user->idCopy);
                    $user->idCopy = $idCopy;
                }
                if ($request->hasFile('profilePhoto')) {
                    $profilePhoto = FileUpload::updateFile($request->file('profilePhoto'), 'uploads/nurse', $user->profilePhoto);
                    $user->profilePhoto = $profilePhoto;
                }
                if ($request->hasFile('drivingLicense')) {
                    $drivingLicense = FileUpload::updateFile($request->file('drivingLicense'), 'uploads/nurse', $user->drivingLicense);
                    $user->drivingLicense = $drivingLicense;
                }
                if ($request->hasFile('goodConductCertificate')) {
                    $goodConductCertificate = FileUpload::updateFile($request->file('goodConductCertificate'), 'uploads/nurse', $user->goodConductCertificate);
                    $user->goodConductCertificate = $goodConductCertificate;
                }
                if ($request->hasFile('referenceLetter')) {
                    $referenceLetter = FileUpload::updateFile($request->file('referenceLetter'), 'uploads/nurse', $user->referenceLetter);  
                    $user->referenceLetter = $referenceLetter;
                }

                $user->update([

                    'name' => $request->name,
                    'age' => $request->age,
                    'gender' => $request->gender,
                    'preferredRole' => $request->preferredRole,
                    'languages' => $request->languages,
                    'canDrive' => $request->canDrive,
                    'bio' => $request->bio,
                    'education' => $request->education,
                    'location' => $request->location,
                    'number_two' => $request->number_two,
                    'preferred' => $request->preferred,

                    'hospitalBasedCare' => $request->hospitalBasedCare,
                    'hospitalBasedYearsOfExperience' => $request->hospitalBasedYearsOfExperience,
                    'hospitalBasedReferenceContact' => $request->hospitalBasedReferenceContact,

                    'homeBasedCare' => $request->homeBasedCare,
                    'homeBasedYearsOfExperience' => $request->homeBasedYearsOfExperience,
                    'homeBasedReferenceContact' => $request->homeBasedReferenceContact,

                    'is_profile_completed' => $user->is_profile_completed,
                    'is_profile_verified' => $user->is_profile_verified,
                ]);

                $nurse = Nurse::firstOrNew([
                    'user_id' => $user->id,
                ]);

                $educationCertificate = null;
                if ($request->hasFile('educationCertificate')) {
                    $educationCertificate = FileUpload::updateFile($request->file('educationCertificate'), 'uploads/nurse', $nurse->educationCertificate);
                    $nurse->educationCertificate = $educationCertificate;
                }

                $practiceLicense = null;
                if ($request->hasFile('practiceLicense')) {
                    $practiceLicense = FileUpload::updateFile($request->file('practiceLicense'), 'uploads/nurse', $nurse->practiceLicense);
                    $nurse->practiceLicense = $practiceLicense;
                }

                $nurse->fill([

                    'isNursingInKenya' => $request->isNursingInKenya,
                    'experience' => $request->experience,
                    'registrationNumber' => $request->registrationNumber,
                    'mobilityYears' => $request->mobilityYears,
                    'bathingYears' => $request->bathingYears,
                    'feedingYears' => $request->feedingYears,
                    'serviceFee' => $request->serviceFee,
                    'serviceFeeDay' => $request->serviceFeeDay,
                    'serviceFeeMonth' => $request->serviceFeeMonth,
                    'skills' => $request->skills,

                ]);

                $nurse->update();

                return response()->json([
                    'is_profile_completed' => $user->is_profile_completed,
                    'is_profile_verified' => $user->is_profile_verified,
                    'message' => 'Nurse Profile updated successfully',
                ], 200);
            }

            if ($user->subRole === 'physiotherapist') {

                $request->validate([

                    'name' => 'nullable',
                    'location' => 'nullable',
                    'age' => 'nullable',
                    'experience' => 'nullable',
                    'gender' => 'nullable',
                    'languages' => 'nullable|array',
                    'canDrive' => 'nullable|boolean',
                    'bio' => 'nullable',
                    'education' => 'nullable',
                    'number_two' => 'nullable',

                    'hospitalBasedCare' => 'nullable',
                    'hospitalBasedYearsOfExperience' => 'nullable',
                    'hospitalBasedReferenceContact' => 'nullable',

                    'homeBasedCare' => 'nullable',
                    'homeBasedYearsOfExperience' => 'nullable',
                    'homeBasedReferenceContact' => 'nullable',
                    'preferred' => 'nullable|array|min:1',
                    'isRegisterPCK' => 'nullable|boolean',
                    'registrationNumber' => 'nullable',
                    'serviceFee' => 'nullable',
                    'serviceFeeDay' => 'nullable',
                    'serviceFeeMonth' => 'nullable',

                    'idCopy' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'profilePhoto' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'goodConductCertificate' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'drivingLicense' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'referenceLetter' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'eduCertificate' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'practiceLicense' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                ]);

            
                if ($request->hasFile('idCopy')) {
                    $idCopy = FileUpload::updateFile($request->file('idCopy'), 'uploads/physiotherapist', $user->idCopy);
                    $user->idCopy = $idCopy;
                }

                if ($request->hasFile('profilePhoto')) {
                    $profilePhoto = FileUpload::updateFile($request->file('profilePhoto'), 'uploads/physiotherapist', $user->profilePhoto);
                    $user->profilePhoto = $profilePhoto;
                }

                if ($request->hasFile('drivingLicense')) {
                    $drivingLicense = FileUpload::updateFile($request->file('drivingLicense'), 'uploads/physiotherapist', $user->drivingLicense);
                    $user->drivingLicense = $drivingLicense;
                }
                if ($request->hasFile('goodConductCertificate')) {
                    $goodConductCertificate = FileUpload::updateFile($request->file('goodConductCertificate'), 'uploads/physiotherapist', $user->goodConductCertificate);
                    $user->goodConductCertificate = $goodConductCertificate;
                }
                if ($request->hasFile('referenceLetter')) {
                    $referenceLetter = FileUpload::updateFile($request->file('referenceLetter'), 'uploads/physiotherapist', $user->referenceLetter);
                    $user->referenceLetter = $referenceLetter;
                }

                $user->update([

                    'name' => $request->name,
                    'age' => $request->age,
                    'gender' => $request->gender,
                    'languages' => $request->languages,
                    'canDrive' => $request->canDrive,
                    'bio' => $request->bio,
                    'education' => $request->education,
                    'location' => $request->location,
                    'preferred' => $request->preferred,
                    'number_two' => $request->number_two,

                    'hospitalBasedCare' => $request->hospitalBasedCare,
                    'hospitalBasedYearsOfExperience' => $request->hospitalBasedYearsOfExperience,
                    'hospitalBasedReferenceContact' => $request->hospitalBasedReferenceContact,

                    'homeBasedCare' => $request->homeBasedCare,
                    'homeBasedYearsOfExperience' => $request->homeBasedYearsOfExperience,
                    'homeBasedReferenceContact' => $request->homeBasedReferenceContact,
                    'is_profile_completed' => $user->is_profile_completed,
                    'is_profile_verified' => $user->is_profile_verified,
                ]);

                $physiotherapist = Physiotherapist::firstOrNew([
                    'user_id' => $user->id,
                ]);

                $eduCertificate = null;
                if ($request->hasFile('eduCertificate')) {
                    $eduCertificate = FileUpload::updateFile($request->file('eduCertificate'), 'uploads/physiotherapist', $physiotherapist->eduCertificate);
                    $physiotherapist->eduCertificate = $eduCertificate;
                }

                $practiceLicense = null;
                if ($request->hasFile('practiceLicense')) {
                    $practiceLicense = FileUpload::updateFile($request->file('practiceLicense'), 'uploads/physiotherapist', $physiotherapist->practiceLicense);
                    $physiotherapist->practiceLicense = $practiceLicense;

                }

                $physiotherapist->fill([
                    'isRegisterPCK' => $request->isRegisterPCK,
                    'experience' => $request->experience,
                    'registrationNumber' => $request->registrationNumber,
                    'serviceFee' => $request->serviceFee,
                    'serviceFeeDay' => $request->serviceFeeDay,
                    'serviceFeeMonth' => $request->serviceFeeMonth,
                ]);

                $physiotherapist->update();

                return response()->json([
                    'is_profile_completed' => $user->is_profile_completed,
                    'is_profile_verified' => $user->is_profile_verified,
                    'message' => 'Physiotherapist Profile updated successfully',
                ], 200);
            }

            if ($user->subRole === 'nurse-aide-or-assistant') {

                $request->validate([

                    'name' => 'nullable',
                    'location' => 'nullable',
                    'age' => 'nullable',
                    'experience' => 'nullable',
                    'gender' => 'nullable',
                    'languages' => 'nullable',
                    'canDrive' => 'nullable',
                    'bio' => 'nullable',
                    'education' => 'nullable',
                    'hospitalBasedCare' => 'nullable',
                    'hospitalBasedYearsOfExperience' => 'nullable',
                    'hospitalBasedReferenceContact' => 'nullable',
                    'homeBasedCare' => 'nullable',
                    'homeBasedYearsOfExperience' => 'nullable',
                    'homeBasedReferenceContact' => 'nullable',
                    'preferred' => 'nullable',

                    'number_two' => 'nullable',
                    'skills' => 'nullable',
                    'mobilityYears' => 'nullable',
                    'bathingYears' => 'nullable',
                    'feedingYears' => 'nullable',
                    'serviceFee' => 'nullable',
                    'serviceFeeDay' => 'nullable',
                    'serviceFeeMonth' => 'nullable',

                    'idCopy' => 'nullable',
                    'profilePhoto' => 'nullable',
                    'goodConductCertificate' => 'nullable',
                    'drivingLicense' => 'nullable',
                    'referenceLetter' => 'nullable',
                    'educationCertificate' => 'nullable',

                ]);

                
                if ($request->hasFile('idCopy')) {
                    $idCopy = FileUpload::updateFile($request->file('idCopy'), 'uploads/nurse_assistant', $user->idCopy);
                    $user->idCopy = $idCopy;
                }

                
                if ($request->hasFile('profilePhoto')) {
                    $profilePhoto = FileUpload::updateFile($request->file('profilePhoto'), 'uploads/nurse_assistant', $user->profilePhoto);
                    $user->profilePhoto = $profilePhoto;
                }

                
                if ($request->hasFile('drivingLicense')) {
                    $drivingLicense = FileUpload::updateFile($request->file('drivingLicense'), 'uploads/nurse_assistant', $user->drivingLicense);
                    $user->drivingLicense = $drivingLicense;
                }

                
                if ($request->hasFile('goodConductCertificate')) {
                    $goodConductCertificate = FileUpload::updateFile($request->file('goodConductCertificate'), 'uploads/nurse_assistant', $user->goodConductCertificate);
                    $user->goodConductCertificate = $goodConductCertificate;
                }

                
                if ($request->hasFile('referenceLetter')) {
                    $referenceLetter = FileUpload::updateFile($request->file('referenceLetter'), 'uploads/nurse_assistant', $user->referenceLetter);
                    $user->referenceLetter = $referenceLetter;
                }

                $user->update([

                    'name' => $request->name,
                    'age' => $request->age,
                    'gender' => $request->gender,
                    'languages' => $request->languages,
                    'canDrive' => $request->canDrive,
                    'bio' => $request->bio,
                    'education' => $request->education,
                    'location' => $request->location,
                    'number_two' => $request->number_two,
                    'preferred' => $request->preferred,

                    'hospitalBasedCare' => $request->hospitalBasedCare,
                    'hospitalBasedYearsOfExperience' => $request->hospitalBasedYearsOfExperience,
                    'hospitalBasedReferenceContact' => $request->hospitalBasedReferenceContact,

                    'homeBasedCare' => $request->homeBasedCare,
                    'homeBasedYearsOfExperience' => $request->homeBasedYearsOfExperience,
                    'homeBasedReferenceContact' => $request->homeBasedReferenceContact,

                    'is_profile_completed' => $user->is_profile_completed,
                    'is_profile_verified' => $user->is_profile_verified,
                ]);

                $nurse_assistant = NurseAssistant::firstOrNew([
                    'user_id' => $user->id,
                ]);

                if ($request->hasFile('educationCertificate')) {
                    $educationCertificate = FileUpload::updateFile($request->file('educationCertificate'), 'uploads/nurse_assistant', $nurse_assistant->educationCertificate);
                    $nurse_assistant->educationCertificate = $educationCertificate;
                }

                $nurse_assistant->fill([

                    'mobilityYears' => $request->mobilityYears,
                    'bathingYears' => $request->bathingYears,
                    'experience' => $request->experience,
                    'feedingYears' => $request->feedingYears,
                    'serviceFee' => $request->serviceFee,
                    'serviceFeeMonth' => $request->serviceFeeMonth,
                    'serviceFeeDay' => $request->serviceFeeDay,
                    'skills' => $request->skills,
                ]);

                $nurse_assistant->update();

                return response()->json([
                    'status' => true,
                    'message' => 'Nurse Ade Assistant Profile updated successfully',
                ], 200);
            }

            if ($user->subRole === 'special-need-caregivers') {

                $request->validate([

                    'name' => 'nullable',
                    'location' => 'nullable',
                    'age' => 'nullable',
                    'number_two' => 'nullable',
                    'experience' => 'nullable',
                    'gender' => 'nullable',
                    'languages' => 'nullable',
                    'canDrive' => 'nullable',
                    'bio' => 'nullable',
                    'education' => 'nullable',
                    'hospitalBasedCare' => 'nullable',
                    'hospitalBasedYearsOfExperience' => 'nullable',
                    'hospitalBasedReferenceContact' => 'nullable',
                    'homeBasedCare' => 'nullable',
                    'homeBasedYearsOfExperience' => 'nullable',
                    'homeBasedReferenceContact' => 'nullable',
                    'preferred' => 'nullable',
                    'isRegisterPCK' => 'nullable',
                    'registrationNumber' => 'nullable',
                    'serviceFee' => 'nullable',
                    'serviceFeeDay' => 'nullable',
                    'serviceFeeMonth' => 'nullable',

                    'idCopy' => 'nullable',
                    'profilePhoto' => 'nullable',
                    'goodConductCertificate' => 'nullable',
                    'drivingLicense' => 'nullable',
                    'referenceLetter' => 'nullable',
                    'educationCertificate' => 'nullable',
                    'practiceLicense' => 'nullable',

                ]);

                if ($request->hasFile('idCopy')) {
                    $idCopy = FileUpload::updateFile($request->file('idCopy'), 'uploads/specialNeed', $user->idCopy);
                    $user->idCopy = $idCopy;
                }

                if ($request->hasFile('profilePhoto')) {
                    $profilePhoto = FileUpload::updateFile($request->file('profilePhoto'), 'uploads/specialNeed', $user->profilePhoto);
                    $user->profilePhoto = $profilePhoto;
                }

                if ($request->hasFile('drivingLicense')) {
                    $drivingLicense = FileUpload::updateFile($request->file('drivingLicense'), 'uploads/specialNeed', $user->drivingLicense);
                    $user->drivingLicense = $drivingLicense;
                }

                if ($request->hasFile('goodConductCertificate')) {
                    $goodConductCertificate = FileUpload::updateFile($request->file('goodConductCertificate'), 'uploads/specialNeed', $user->goodConductCertificate);
                    $user->goodConductCertificate = $goodConductCertificate;
                }

            
                if ($request->hasFile('referenceLetter')) {
                    $referenceLetter = FileUpload::updateFile($request->file('referenceLetter'), 'uploads/specialNeed', $user->referenceLetter);
                    $user->referenceLetter = $referenceLetter;
                }

                $user->update([

                    'name' => $request->name,
                    'location' => $request->location,
                    'age' => $request->age,
                    'number_two' => $request->number_two,
                    'experience' => $request->experience,
                    'gender' => $request->gender,
                    'languages' => $request->languages,
                    'canDrive' => $request->canDrive,
                    'bio' => $request->bio,
                    'education' => $request->education,
                    'hospitalBasedCare' => $request->hospitalBasedCare,
                    'hospitalBasedYearsOfExperience' => $request->hospitalBasedYearsOfExperience,
                    'hospitalBasedReferenceContact' => $request->hospitalBasedReferenceContact,
                    'homeBasedCare' => $request->homeBasedCare,
                    'homeBasedYearsOfExperience' => $request->homeBasedYearsOfExperience,
                    'homeBasedReferenceContact' => $request->homeBasedReferenceContact,
                    'preferred' => $request->preferred,
                    'isRegisterPCK' => $request->isRegisterPCK,
                    'registrationNumber' => $request->registrationNumber,
                    'is_profile_completed' => $user->is_profile_completed,
                    'is_profile_verified' => $user->is_profile_verified,
                ]);

                $specialNeed = SpecialNeed::firstOrNew([
                    'user_id' => $user->id,
                ]);

                if ($request->hasFile('educationCertificate')) {
                    $educationCertificate = FileUpload::updateFile($request->file('educationCertificate'), 'uploads/specialNeed', $specialNeed->educationCertificate);
                    $specialNeed->educationCertificate = $educationCertificate;
                }


                if ($request->hasFile('practiceLicense')) {
                    $practiceLicense = FileUpload::updateFile($request->file('practiceLicense'), 'uploads/specialNeed', $specialNeed->practiceLicense);
                    $specialNeed->practiceLicense = $practiceLicense;
                }

                $specialNeed->fill([

                    'isRegisterPCK' => $request->isRegisterPCK,
                    'registrationNumber' => $request->registrationNumber,
                    'serviceFee' => $request->serviceFee,
                    'serviceFeeMonth' => $request->serviceFeeMonth,
                    'serviceFeeDay' => $request->serviceFeeDay,
                ]);

                $specialNeed->update();

                return response()->json([
                    'status' => true,
                    'message' => 'Special Caregiver Profile updated successfully',
                ], 200);
            }

        }

        if($user->role === 'agency'){

            $agency = Agency::where('user_id', $user->id)->first();
            $request->validate([
                'companyName' => 'nullable',
                'kraPin' => 'nullable',
                'companyRegistrationNumber' => 'nullable',
                'number' => 'nullable',
                'businessLocation' => 'nullable',
                'registrationDocument' => 'nullable',
                'agency_services' => 'nullable',
                'placementFee' => 'nullable',
                'replacementWindow' => 'nullable',
                'numberOfReplacement' => 'nullable',
            ]);

            DB::transaction(function () use ($request, $user) {

                $agency = Agency::firstOrNew([
                    'user_id' => $user->id,
                ]);

                $registrationDocument = null;
                if ($request->hasFile('registrationDocument')) {
                    $registrationDocument = FileUpload::updateFile(
                        $request->file('registrationDocument'),
                        'uploads/agency',
                        $agency->registrationDocument
                    );

                    $agency->registrationDocument = $registrationDocument;
                }

                $agency->fill([
                    'companyName' => $request->companyName,
                    'kraPin' => $request->kraPin,
                    'companyRegistrationNumber' => $request->companyRegistrationNumber,
                    'number' => $request->number,
                    'agency_services' => $request->agency_services,
                    'businessLocation' => $request->businessLocation,
                    'placementFee' => $request->placementFee,
                    'replacementWindow' => $request->replacementWindow,
                    'numberOfReplacement' => $request->numberOfReplacement,
                ]);

                $agency->update();
            });

            $user->update([
                'is_profile_completed' => $user->is_profile_completed,
                'is_profile_verified' => $user->is_profile_verified,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Agency profile updated successfully',
            ], 200);
        }  
        
        if($user->role === 'care_institutions') {
            $careInstitution = CareInstitution::where('user_id', $user->id)->first();
            $request->validate([

                'companyName' => 'nullable',
                'kraPin' => 'nullable',
                'companyRegistrationNumber' => 'nullable',
                'number' => 'nullable',
                'businessLocation' => 'nullable',
                'registrationDocument' => 'nullable',
            ]);

            DB::transaction(function () use ($request, $user) {

                $careInstitution = CareInstitution::firstOrNew([
                    'user_id' => $user->id,
                ]);

                $registrationDocument = null;
                if ($request->hasFile('registrationDocument')) {
                    $registrationDocument = FileUpload::storeFile(
                        $request->file('registrationDocument'),
                        'uploads/careInstitution'
                    );

                    $careInstitution->registrationDocument = $registrationDocument;
                }

                $careInstitution->fill([
                    'companyName' => $request->companyName,
                    'kraPin' => $request->kraPin,
                    'companyRegistrationNumber' => $request->companyRegistrationNumber,
                    'number' => $request->number,
                    'businessLocation' => $request->businessLocation,
                    'placementFee' => $request->placementFee,
                    'replacementWindow' => $request->replacementWindow,
                    'numberOfReplacement' => $request->numberOfReplacement,
                ]);

                $careInstitution->save();

                $user->update([
                    'is_profile_completed' => $user->is_profile_completed,
                    'is_profile_verified' => $user->is_profile_verified,
                ]);

            });

            return response()->json([
                'status' => true,
                'message' => 'Care institution profile update successfully',
            ], 200);
        }

    }

    public function getNotifications()
    {
        $user = auth()->user();
        $notifications = $user->notifications;
        return response()->json([
            'status' => true,
            'message' => 'Notifications retrieved successfully',
            'data' => $notifications,
        ], 200);
    }

}
