<?php

namespace App\Http\Controllers;

use App\Helpers\FileUpload;
use App\Models\HouseManager;
use App\Models\Nurse;
use App\Models\NurseAssistant;
use App\Models\Physiotherapist;
use App\Models\SpecialNeed;
use App\Models\User;
use App\Notifications\UserNotification;
use Illuminate\Http\Request;
use Inertia\Inertia;

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
        return Inertia::render('User/Specialist/SpecialistCreate');
    }


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


    public function physiotherapistUpdate(Request $request, $id)
    {

        $user = User::findOrFail($id);

        if ($request->hasFile('idCopy')) {
            FileUpload::deleteFile($user->idCopy);
            $idCopy = FileUpload::storeFile($request->file('idCopy'), 'uploads/physiotherapist');
            $user->idCopy = $idCopy;
        }

        if ($request->hasFile('profilePhoto')) {
            FileUpload::deleteFile($user->profilePhoto);
            $profilePhoto = FileUpload::storeFile($request->file('profilePhoto'), 'uploads/physiotherapist');
            $user->profilePhoto = $profilePhoto;
        }

        if ($request->hasFile('drivingLicense')) {
            FileUpload::deleteFile($user->drivingLicense);
            $drivingLicense = FileUpload::storeFile($request->file('drivingLicense'), 'uploads/physiotherapist');
            $user->drivingLicense = $drivingLicense;
        }

        if ($request->hasFile('goodConductCertificate')) {
            FileUpload::deleteFile($user->goodConductCertificate);
            $goodConductCertificate = FileUpload::storeFile($request->file('goodConductCertificate'), 'uploads/physiotherapist');
            $user->goodConductCertificate = $goodConductCertificate;
        }

        if ($request->hasFile('referenceLetter')) {
            FileUpload::deleteFile($user->referenceLetter);
            $referenceLetter = FileUpload::storeFile($request->file('referenceLetter'), 'uploads/physiotherapist');
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
            
            'is_profile_completed' => true,
            'type' => 'physiotherapist',
        ]);

        $physiotherapist = Physiotherapist::firstOrNew(['user_id' => $user->id]);

        if ($request->hasFile('eduCertificate')) {
            FileUpload::deleteFile($physiotherapist->eduCertificate);
            $eduCertificate = FileUpload::storeFile($request->file('eduCertificate'), 'uploads/physiotherapist');
            $physiotherapist->eduCertificate = $eduCertificate;
        }

        if ($request->hasFile('practiceLicense')) {
            FileUpload::deleteFile($physiotherapist->practiceLicense);
            $practiceLicense = FileUpload::storeFile($request->file('practiceLicense'), 'uploads/physiotherapist');
            $physiotherapist->practiceLicense = $practiceLicense;
        }

        $physiotherapist->fill([
            'experience' => $request->experience,
            'isRegisterPCK' => $request->isRegisterPCK,
            'registrationNumber' => $request->registrationNumber,
            'serviceFee' => $request->serviceFee,
            'serviceFeeDay' => $request->serviceFeeDay,
            'serviceFeeMonth' => $request->serviceFeeMonth,

        ]);


        $physiotherapist->save();

        return redirect()->route('specialist.index')->with('message', 'Physiotherapist profile updated successfully.');

    }

}
