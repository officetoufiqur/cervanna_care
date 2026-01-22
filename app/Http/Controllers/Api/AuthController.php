<?php

namespace App\Http\Controllers\Api;

use App\Helpers\FileUpload;
use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\Agency;
use App\Models\AgencyEmployee;
use App\Models\HouseManager;
use App\Models\Nurse;
use App\Models\NurseAssistant;
use App\Models\Physiotherapist;
use App\Models\SkillService;
use App\Models\SpecialNeed;
use App\Models\User;
use App\Models\CareInstitution;
use App\Models\InstitutionNurse;
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
        if ($user->role === 'user') {
            $user->is_profile_completed = true;
        }
        $user->save();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Email verified successfully',
            'data' => [
                'token' => $token,
                'role' => $user->role,
                'is_profile_completed' => $user->is_profile_completed,
            ],
        ], 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || ! Hash::check($request->password, $user->password)) {
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

                    'name' => 'required|string|max:255',
                    'education' => 'required|string|max:255',
                    'experience' => 'required|string|max:255',
                    'location' => 'required|string|max:255',
                    'preferredRole' => 'nullable|string|max:255',
                    'languages' => 'nullable|array|min:1',
                    'phone' => 'required|digits:10',
                    'salaryRange' => 'required|string|max:255',
                    'serviceOffered' => 'required|string|max:255',
                    'isMother' => 'required|boolean',
                    'ageOfKids' => 'nullable|array|min:1',
                    'isHandelingPet' => 'required|boolean',
                    'preferBeingA' => 'nullable|string|max:255',
                    'idCopy' => 'required|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'profilePhoto' => 'required|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'drivingLicense' => 'required|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'firstAidCertificate' => 'required|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'goodConductCertificate' => 'required|mimes:pdf,jpg,jpeg,png,webp|max:2048',

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
                    'preferredRole' => $request->preferredRole,
                    'languages' => $request->languages,
                    'number' => $request->phone,
                    'idCopy' => $idCopy,
                    'profilePhoto' => $profilePhoto,
                    'drivingLicense' => $drivingLicense,
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
                    'serviceOffered' => $request->serviceOffered,
                    'isMother' => $request->isMother,
                    'ageOfKids' => $request->ageOfKids,
                    'isHandelingPet' => $request->isHandelingPet,
                    'preferBeingA' => $request->preferBeingA,

                ]);

                $houseManager->save();

                return response()->json([
                    'status' => true,
                    'message' => 'House Manager Profile created successfully',
                ], 200);

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

                    'hospitalBasedCare' => 'nullable',
                    'hospitalBasedYearsOfExperience' => 'nullable',
                    'hospitalBasedReferenceContact' => 'nullable|string|max:255',

                    'homeBasedCare' => 'nullable',
                    'homeBasedYearsOfExperience' => 'nullable',
                    'homeBasedReferenceContact' => 'nullable|string|max:255',

                    'number_two' => 'nullable|digits:10',
                    'isNursingInKenya' => 'nullable',
                    'skills' => 'nullable|array|min:1',
                    'mobilityYears' => 'nullable',
                    'bathingYears' => 'nullable',
                    'feedingYears' => 'nullable',
                    'serviceFee' => 'nullable|integer',

                    'idCopy' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'profilePhoto' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
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
                    'experience' => $request->experience,
                    'gender' => $request->gender,
                    'preferredRole' => $request->preferredRole,
                    'languages' => $request->languages,
                    'canDrive' => $request->canDrive,
                    'bio' => $request->bio,
                    'education' => $request->education,
                    'location' => $request->location,
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

                $nurse = Nurse::firstOrNew([
                    'user_id' => $user->id,
                ]);

                $educationCertificate = null;
                if ($request->hasFile('educationCertificate')) {
                    $educationCertificate = FileUpload::storeFile($request->file('educationCertificate'), 'uploads/nurse');
                    $nurse->educationCertificate = $educationCertificate;
                }

                $nurse->fill([

                    'isNursingInKenya' => $request->isNursingInKenya,
                    'mobilityYears' => $request->mobilityYears,
                    'bathingYears' => $request->bathingYears,
                    'feedingYears' => $request->feedingYears,
                    'serviceFee' => $request->serviceFee,

                ]);

                $nurse->save();

                if ($request->filled('skills')) {
                    $nurse->skills()->sync($request->skills);
                }

                // if ($request->skills) {
                //     foreach ($request->skills as $skill) {
                //         $skillService = new SkillService;
                //         $skillService->nurse_id = $nurse->id;
                //         $skillService->skill_id = $skill;
                //         $skillService->save();
                //     }
                // }

                return response()->json([
                    'status' => true,
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
                    'number_two' => 'nullable|digits:10',

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
                    'experience' => $request->experience,
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
                    'registrationNumber' => $request->registrationNumber,
                    'serviceFee' => $request->serviceFee,
                ]);

                $physiotherapist->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Physiotherapist Profile updated successfully',
                ], 200);
            }

            if ($user->subRole === 'nurse-aide-or-assistant') {

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
                    'hospitalBasedCare' => 'nullable',
                    'hospitalBasedYearsOfExperience' => 'nullable',
                    'hospitalBasedReferenceContact' => 'nullable|string|max:255',
                    'homeBasedCare' => 'nullable',
                    'homeBasedYearsOfExperience' => 'nullable',
                    'homeBasedReferenceContact' => 'nullable|string|max:255',
                    'preferred' => 'nullable|array|min:1',

                    'number_two' => 'nullable|digits:10',
                    'skills' => 'nullable|array|min:1',
                    'mobilityYears' => 'nullable',
                    'bathingYears' => 'nullable',
                    'feedingYears' => 'nullable',
                    'serviceFee' => 'nullable|integer',

                    'idCopy' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'profilePhoto' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'goodConductCertificate' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'drivingLicense' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'referenceLetter' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'educationCertificate' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',

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
                    'bathingYears' => $request->bathingYears,
                    'feedingYears' => $request->feedingYears,
                    'serviceFee' => $request->serviceFee,

                ]);

                $nurse_assistant->save();

                if ($request->filled('skills')) {
                    $nurse_assistant->skills()->sync($request->skills);
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Nurse Ade Assistant Profile updated successfully',
                ], 200);
            }

            if ($user->subRole === 'special-need-caregivers') {

                $request->validate([

                    'name' => 'nullable|string|max:255',
                    'location' => 'nullable|string|max:255',
                    'age' => 'nullable',
                    'number_two' => 'nullable|digits:10',
                    'experience' => 'nullable|string|max:255',
                    'gender' => 'nullable|string|max:255',
                    'languages' => 'nullable|array|min:1',
                    'canDrive' => 'nullable|boolean',
                    'bio' => 'nullable',
                    'education' => 'nullable|string|max:255',
                    'hospitalBasedCare' => 'nullable',
                    'hospitalBasedYearsOfExperience' => 'nullable',
                    'hospitalBasedReferenceContact' => 'nullable|string|max:255',
                    'homeBasedCare' => 'nullable',
                    'homeBasedYearsOfExperience' => 'nullable',
                    'homeBasedReferenceContact' => 'nullable|string|max:255',
                    'preferred' => 'nullable|array|min:1',
                    'isRegisterPCK' => 'nullable|boolean',
                    'registrationNumber' => 'nullable',
                    'serviceFee' => 'nullable',

                    'idCopy' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'profilePhoto' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'goodConductCertificate' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'drivingLicense' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'referenceLetter' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'educationCertificate' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                    'practiceLicense' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:2048',

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
                    'serviceFee' => $request->serviceFee,

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
                    'registrationNumber' => $request->registrationNumber,
                    'serviceFee' => $request->serviceFee,

                ]);

                $specialNeed->save();

                return response()->json([
                    'message' => 'Special Caregiver Profile updated successfully',
                ], 200);
            }

        } elseif ($user->role === 'agency') {

            $request->validate([
                'companyName' => 'required|string|max:255',
                'kraPin' => 'required|string|max:255',
                'companyRegistrationNumber' => 'required|string|max:255',
                'number' => 'required|string|max:255',
                'businessLocation' => 'required|string|max:255',
                'registrationDocument' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                'agency_services' => 'nullable|array|min:1',
                'placementFee' => 'required',
                'replacementWindow' => 'required',
                'numberOfReplacement' => 'required',

                'employees' => 'nullable|array|min:1',

                'employees.*.name' => 'required_with:employees|string|max:255',
                'employees.*.educationLevel' => 'required_with:employees|string',
                'employees.*.location' => 'required_with:employees|string',
                'employees.*.experience' => 'required_with:employees|string',
                'employees.*.salaryRange' => 'required_with:employees|string',
                'employees.*.isMother' => 'required_with:employees|boolean',
                'employees.*.kidAges' => 'nullable|string',
                'employees.*.handlePets' => 'required_with:employees|boolean',
                'employees.*.preferredRole' => 'required_with:employees|string',
                'employees.*.languages' => 'required_with:employees|string',
                'employees.*.cooking' => 'required_with:employees|boolean',
                'employees.*.housekeeping' => 'required_with:employees|boolean',
                'employees.*.childcare' => 'required_with:employees|boolean',
                'employees.*.liveType' => 'required_with:employees|string',

                'employees.*.idCopy' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                'employees.*.profilePhoto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                'employees.*.drivingLicense' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                'employees.*.goodConductCertificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                'employees.*.aidCertificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',
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
                    'is_profile_completed' => true,
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
            });

            return response()->json([
                'message' => 'Agency profile and employees registered successfully',
            ], 200);

        } elseif ($user->role === 'care_institutions') {
            $request->validate([

                'companyName' => 'required|string|max:255',
                'kraPin' => 'required|string|max:255',
                'companyRegistrationNumber' => 'required|string|max:255',
                'number' => 'required|string|max:255',
                'businessLocation' => 'required|string|max:255',
                'registrationDocument' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',

                'institutionNurses' => 'nullable|array|min:1',

                'institutionNurses.*.fullName' => 'required_with:institutionNurses|string|max:255',
                'institutionNurses.*.age' => 'required_with:institutionNurses|string|max:255',
                'institutionNurses.*.location' => 'required_with:institutionNurses|string|max:255',
                'institutionNurses.*.experience' => 'required_with:institutionNurses|string|max:255',
                'institutionNurses.*.gender' => 'required_with:institutionNurses|string|max:255',
                'institutionNurses.*.education' => 'required_with:institutionNurses|string|max:255',
                'institutionNurses.*.canDrive' => 'required_with:institutionNurses|string|max:255',
                'institutionNurses.*.preferredRole' => 'required_with:institutionNurses|string|max:255',
                'institutionNurses.*.languages' => 'required_with:institutionNurses|array|min:1',
                // 'institutionNurses.*.educationCertificate' => 'required_with:institutionNurses|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                'institutionNurses.*.isNursingInKenya' => 'required_with:institutionNurses|string|max:255',
                'institutionNurses.*.hospitalBasedCare' => 'required_with:institutionNurses|boolean',
                'institutionNurses.*.services' => 'required|array|min:1',
                'institutionNurses.*.hospitalBasedYearsOfExperience' => 'required_with:institutionNurses|integer',
                'institutionNurses.*.hospitalBasedReferenceContact' => 'required_with:institutionNurses|string|max:255',
                'institutionNurses.*.homeBasedCare' => 'required_with:institutionNurses|boolean',
                'institutionNurses.*.homeBasedYearsOfExperience' => 'required_with:institutionNurses|integer',
                'institutionNurses.*.homeBasedReferenceContact' => 'required_with:institutionNurses|string|max:255',
                'institutionNurses.*.mobilityYears' => 'required_with:institutionNurses|string|max:255',
                'institutionNurses.*.bathingYears' => 'required_with:institutionNurses|string|max:255',
                'institutionNurses.*.feedingYears' => 'required_with:institutionNurses|string|max:255',
                'institutionNurses.*.serviceFee' => 'required_with:institutionNurses|integer',
                'institutionNurses.*.bio' => 'required_with:institutionNurses|string|max:255',
                // 'institutionNurses.*.idCopy' => 'required_with:institutionNurses|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                // 'institutionNurses.*.profilePhoto' => 'required_with:institutionNurses|image|mimes:jpg,jpeg,png,webp|max:2048',
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

                        $institutionNurse = new InstitutionNurse();
                        $institutionNurse->care_institution_id = $careInstitution->id;
                        $institutionNurse->fill($nurseData);

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

                        if (!empty($nurseData['services'])) {
                            $institutionNurse->skills()->sync($nurseData['services']);
                        }
                    }

                }

                $user->update([

                    'is_profile_completed' => true,
                ]);
                
            });

            return response()->json([
                'message' => 'Care institution profile and nurses registered successfully',
            ], 200);
        }

    }
}
