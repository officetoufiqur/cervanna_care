<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;
use App\Models\HouseManager;
use App\Models\Nurse;
use App\Models\Physiotherapist;
use App\Models\NurseAssistant;
use App\Models\SpecialNeed;
use App\Helpers\FileUpload;
use App\Models\Skill;
use App\Notifications\UserNotification;

class SpecialistController extends Controller
{

    public function specialistIndex()
    {
        $specialists = User::where('role', 'specialist')->orderBy('id', 'desc')->get();

        return Inertia::render('User/Specialist/SpecialistIndex', [
            'specialists' => $specialists,
        ]);
    }

    public function specialistCreate()
    {
        // $type = request()->get('type');
        // if ($type === 'house-manager') {
        //     return Inertia::render('User/Specialist/HouseManagerCreate');
        // }

        // if ($type === 'nurse') {
        //    $skills = Skill::where('type', 'nurse')->get();
        //     return Inertia::render('User/Specialist/NurseCreate', [
        //         'skills' => $skills,
        //     ]);
        // }

        return Inertia::render('User/Specialist/SpecialistCreate');

        // if ($type === 'special-needs') {
        //     return Inertia::render('User/Specialist/SpecialNeedsCreate');
        // }
    }

    // public function specialistStore(Request $request)
    // {
    //     $type = request()->get('type');
    //     if ($type === 'house-manager') {
          


    //         $validated = $request->validate([
    //             'subRole' => 'required|string',
    //             'name' => 'required|string|max:255',
    //             'email' => 'required|email|unique:users,email',
    //             'password' => 'required|min:6',

    //             'number' => 'required|string',
    //             'number_two' => 'required|string',

    //             'education' => 'required|string',
    //             'experience' => 'required|string',
    //             'location' => 'required|string',
    //             'preferredRole' => 'required|string',
    //             'salaryRange' => 'required|string',

    //             'languages' => 'required|array|min:1',
    //             'preferred' => 'required|string',

    //             'isMother' => 'required|boolean',
    //             'ageOfKids' => 'required|array|min:1',
    //             'isHandelingPet' => 'required|boolean',

    //             'idCopy' => 'required|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',
    //             'profilePhoto' => 'required|file|mimes:jpg,jpeg,png,webp|max:2048',
    //             'drivingLicense' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',
    //             'firstAidCertificate' => 'required|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',
    //             'goodConductCertificate' => 'required|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',
    //         ]);

    //         /** FILE UPLOADS */
    //         $path = 'uploads/house-manager';

    //         $idCopy = FileUpload::storeFile($request->file('idCopy'), $path);
    //         $profilePhoto = FileUpload::storeFile($request->file('profilePhoto'), $path);
    //         $goodConductCertificate = FileUpload::storeFile($request->file('goodConductCertificate'), $path);
    //         $firstAidCertificate = FileUpload::storeFile($request->file('firstAidCertificate'), $path);

    //         $drivingLicense = $request->hasFile('drivingLicense')
    //             ? FileUpload::storeFile($request->file('drivingLicense'), $path)
    //             : null;

    //         /** USER */
    //         $user = User::create([
    //             'role' => 'specialist',
    //             'subRole' => $validated['subRole'],
    //             'name' => $validated['name'],
    //             'email' => $validated['email'],
    //             'password' => bcrypt($validated['password']),
    //             'number' => $validated['number'],
    //             'number_two' => $validated['number_two'],
    //             'education' => $validated['education'],
    //             'experience' => $validated['experience'],
    //             'location' => $validated['location'],
    //             'preferredRole' => $validated['preferredRole'],
    //             'languages' => $validated['languages'],
    //             'preferred' => $validated['preferred'],
    //             'salaryRange' => $validated['salaryRange'],
    //             'idCopy' => $idCopy,
    //             'profilePhoto' => $profilePhoto,
    //             'drivingLicense' => $drivingLicense,
    //             'goodConductCertificate' => $goodConductCertificate,
    //             'is_profile_completed' => true,
    //             'is_profile_verified' => true,
    //             'email_verified_at' => now(),
    //             'otp' => '123456',
    //         ]);

    //         /** HOUSE MANAGER */
    //         HouseManager::create([
    //             'user_id' => $user->id,
    //             'firstAidCertificate' => $firstAidCertificate,
    //             'isMother' => $validated['isMother'],
    //             'ageOfKids' => $validated['ageOfKids'],
    //             'isHandelingPet' => $validated['isHandelingPet'],
    //             'salaryRange' => $validated['salaryRange'],
    //             'experience' => $validated['experience'],
    //         ]);

    //         // Optional notification
    //         // $user->notify(new UserNotification('Specialist created successfully'));

    //         return redirect()
    //             ->route('specialist.index')
    //             ->with('success', 'Specialist created successfully');
    //     }

    //     if ($type === 'nurse') {

    //         $validated = $request->validate([
    //             'subRole' => 'required|string|in:nurse',
    //             'name' => 'required|string|max:255',
    //             'email' => 'required|email|unique:users,email',
    //             'password' => 'required|min:6',

    //             'number' => 'required|string',
    //             'number_two' => 'nullable|string',

    //             'education' => 'required|string',
    //             'experience' => 'required|string',
    //             'location' => 'required|string',
    //             'preferredRole' => 'required|string',

    //             'languages' => 'required|array|min:1',
    //             'languages.*' => 'string',

    //             'preferred' => 'required|array',
    //             'preferred.*' => 'string',

    //             // ✅ SKILLS
    //             'skills' => 'required|array|min:1',
    //             'skills.*' => 'string',

    //             // ✅ EXTRA FIELDS
    //             'isNursingInKenya' => 'nullable|boolean',
    //             'registrationNumber' => 'nullable|string',

    //             'hospitalBasedCare' => 'nullable|boolean',
    //             'hospitalBasedYearsOfExperience' => 'nullable|string',
    //             'hospitalBasedReferenceContact' => 'nullable|string',

    //             'homeBasedCare' => 'nullable|boolean',
    //             'homeBasedYearsOfExperience' => 'nullable|string',
    //             'homeBasedReferenceContact' => 'nullable|string',

    //             'mobilityYears' => 'nullable|string',
    //             'bathingYears' => 'nullable|string',
    //             'feedingYears' => 'nullable|string',

    //             'serviceFeeDay' => 'required|string',
    //             'serviceFeeMonth' => 'required|string',

    //             'canDrive' => 'nullable|boolean',
    //             'gender' => 'nullable',
    //             'bio' => 'nullable|string',

    //             // ✅ FILES
    //             'idCopy' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',
    //             'profilePhoto' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
    //             'drivingLicense' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',
    //             'goodConductCertificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',
    //             'educationCertificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',
    //             'referenceLetter' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',
    //             'practiceLicense' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',
    //         ]);

    //         /** FILE UPLOADS */
    //         $path = 'uploads/nurse';

    //         $idCopy = $request->hasFile('idCopy')
    //             ? FileUpload::storeFile($request->file('idCopy'), $path)
    //             : null;

    //         $profilePhoto = $request->hasFile('profilePhoto')
    //             ? FileUpload::storeFile($request->file('profilePhoto'), $path)
    //             : null;

    //         $goodConductCertificate = $request->hasFile('goodConductCertificate')
    //             ? FileUpload::storeFile($request->file('goodConductCertificate'), $path)
    //             : null;

    //         $educationCertificate = $request->hasFile('educationCertificate')
    //             ? FileUpload::storeFile($request->file('educationCertificate'), $path)
    //             : null;

    //         $referenceLetter = $request->hasFile('referenceLetter')
    //             ? FileUpload::storeFile($request->file('referenceLetter'), $path)
    //             : null;

    //         $practiceLicense = $request->hasFile('practiceLicense')
    //             ? FileUpload::storeFile($request->file('practiceLicense'), $path)
    //             : null;

    //         $drivingLicense = $request->hasFile('drivingLicense')
    //             ? FileUpload::storeFile($request->file('drivingLicense'), $path)
    //             : null;

    //         /** USER */
    //         $user = User::create([
    //             'role' => 'specialist',
    //             'subRole' => $validated['subRole'],
    //             'name' => $validated['name'],
    //             'email' => $validated['email'],
    //             'password' => bcrypt($validated['password']),
    //             'number' => $validated['number'],
    //             'number_two' => $validated['number_two'] ?? null,
    //             'education' => $validated['education'],
    //             'experience' => $validated['experience'],
    //             'location' => $validated['location'],
    //             'preferredRole' => $validated['preferredRole'],

    //             'hospitalBasedCare' => $validated['hospitalBasedCare'] ?? null,
    //             'hospitalBasedYearsOfExperience' => $validated['hospitalBasedYearsOfExperience'] ?? null,
    //             'hospitalBasedReferenceContact' => $validated['hospitalBasedReferenceContact'] ?? null,

    //             'homeBasedCare' => $validated['homeBasedCare'] ?? null,
    //             'homeBasedYearsOfExperience' => $validated['homeBasedYearsOfExperience'] ?? null,
    //             'homeBasedReferenceContact' => $validated['homeBasedReferenceContact'] ?? null,
    //             'languages' => $validated['languages'],
    //             'preferred' => $validated['preferred'],
    //             'skills' => $validated['skills'],

    //             'bio' => $validated['bio'] ?? null,
    //             'gender' => $validated['gender'] ?? null,
    //             'canDrive' => $validated['canDrive'] ?? null,

    //             'idCopy' => $idCopy,
    //             'profilePhoto' => $profilePhoto,
    //             'drivingLicense' => $drivingLicense,
    //             'goodConductCertificate' => $goodConductCertificate,
    //             'referenceLetter' => $referenceLetter,

    //             'is_profile_completed' => true,
    //             'is_profile_verified' => true,
    //             'email_verified_at' => now(),
    //             'otp' => '123456',
    //         ]);

    //         /** NURSE */
    //         Nurse::create([
    //             'user_id' => $user->id,

    //             'experience' => $validated['experience'],

    //             'isNursingInKenya' => $validated['isNursingInKenya'] ?? null,
    //             'registrationNumber' => $validated['registrationNumber'] ?? null,

    //             'educationCertificate' => $educationCertificate,
    //             'practiceLicense' => $practiceLicense,

    //             'mobilityYears' => $validated['mobilityYears'] ?? null,
    //             'bathingYears' => $validated['bathingYears'] ?? null,
    //             'feedingYears' => $validated['feedingYears'] ?? null,

    //             'serviceFeeDay' => $validated['serviceFeeDay'],
    //             'serviceFeeMonth' => $validated['serviceFeeMonth'],
    //         ]);

    //         return redirect()
    //             ->route('specialist.index')
    //             ->with('success', 'Nurse created successfully');
    //     }

        
    // }     


    public function specialistStore(Request $request)
    {          

                $request->validate([
                    'name' => 'required|string|max:255',
                    'email' => 'required|email|max:255',
                    'password' => 'required',
                    'number' => 'required',
                    'location' => 'required|string|max:255',
                    'experience' => 'required',
                    'subRole' => 'required',
                ]);


                if($request->subRole == 'house-manager') {

                    $user = User::create([
                        'name' => $request->name,
                        'location' => $request->location,
                        'email' => $request->email,
                        'password' => bcrypt($request->password),
                        'number' => $request->number,
                        'type' => 'house-manager',
                        'role' => 'specialist',
                        'email_verified_at' => now(),
                        'otp' => '123456',
                        'subRole' => $request->subRole,
                    ]);

                    $houseManager = HouseManager::firstOrNew([
                        'user_id' => $user->id,
                    ]);

                    $houseManager->fill([
                        'experience' => $request->experience,
                    ]);

                    $houseManager->save();
                    
                }

                if($request->subRole == 'nurse') {

                    $user = User::create([
                        'name' => $request->name,
                        'location' => $request->location,
                        'email' => $request->email,
                        'password' => bcrypt($request->password),
                        'number' => $request->number,
                        'type' => 'house-manager',
                        'role' => 'specialist',
                        'email_verified_at' => now(),
                        'otp' => '123456',
                        'subRole' => $request->subRole,
                    ]);

                    $nurse = Nurse::firstOrNew([
                        'user_id' => $user->id,
                    ]);

                    $nurse->fill([
                        'experience' => $request->experience,
                    ]);

                    $nurse->save();
                    
                }

                if($request->subRole == 'physiotherapist') {

                    $user = User::create([
                        'name' => $request->name,
                        'location' => $request->location,
                        'email' => $request->email,
                        'password' => bcrypt($request->password),
                        'number' => $request->number,
                        'type' => 'house-manager',
                        'role' => 'specialist',
                        'email_verified_at' => now(),
                        'otp' => '123456',
                        'subRole' => $request->subRole,
                    ]);

                    $physiotherapist = Physiotherapist::firstOrNew([
                        'user_id' => $user->id,
                    ]);

                    $physiotherapist->fill([
                        'experience' => $request->experience,
                    ]);

                    $physiotherapist->save();
                    
                }

                if($request->subRole == 'nurse-aide-or-assistant') {

                    $user = User::create([
                        'name' => $request->name,
                        'location' => $request->location,
                        'email' => $request->email,
                        'password' => bcrypt($request->password),
                        'number' => $request->number,
                        'type' => 'house-manager',
                        'role' => 'specialist',
                        'email_verified_at' => now(),
                        'otp' => '123456',
                        'subRole' => $request->subRole,
                    ]);

                    $nurseAideOrAssistant = NurseAssistant::firstOrNew([
                        'user_id' => $user->id,
                    ]);

                    $nurseAideOrAssistant->fill([
                        'experience' => $request->experience,
                    ]);

                    $nurseAideOrAssistant->save();
                    
                }

                if($request->subRole == 'special-need-caregivers') {

                    $user = User::create([
                        'name' => $request->name,
                        'location' => $request->location,
                        'email' => $request->email,
                        'password' => bcrypt($request->password),
                        'number' => $request->number,
                        'type' => 'house-manager',
                        'role' => 'specialist',
                        'email_verified_at' => now(),
                        'otp' => '123456',
                        'subRole' => $request->subRole,
                    ]);

                    $specialNeedCaregivers = SpecialNeed::firstOrNew([
                        'user_id' => $user->id,
                    ]);

                    $specialNeedCaregivers->fill([
                        'experience' => $request->experience,
                    ]);

                    $specialNeedCaregivers->save();
                    
                }



               $user->notify(new UserNotification('Specialist profile created successfully', $user->specialist_id, $user->id));

               return redirect()->route('specialist.index')->with('success', 'Specialist created successfully');

            
    }



}
