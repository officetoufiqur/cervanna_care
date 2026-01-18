<?php

namespace App\Http\Controllers\Api;

use App\Helpers\FileUpload;
use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\HouseManager;
use App\Models\Nurse;
use App\Models\NurseAssistant;
use App\Models\Physiotherapist;
use App\Models\SkillService;
use App\Models\SpecialNeed;
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

        } elseif ($user->role === 'care_institutions') {

        }

    }
}
