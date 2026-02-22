<?php

namespace App\Http\Controllers;

use App\Helpers\FileUpload;
use App\Models\Nurse;
use App\Models\NurseAssistant;
use App\Models\SpecialNeed;
use App\Models\User;
use Illuminate\Http\Request;

class NurseController extends Controller
{
    public function nurseUpdate(Request $request, $id)
    {

        $user = User::findOrFail($id);

        if ($request->hasFile('idCopy')) {
            FileUpload::deleteFile($user->idCopy);
            $idCopy = FileUpload::storeFile($request->file('idCopy'), 'uploads/nurse');
            $user->idCopy = $idCopy;
        }

        if ($request->hasFile('profilePhoto')) {
            FileUpload::deleteFile($user->profilePhoto);
            $profilePhoto = FileUpload::storeFile($request->file('profilePhoto'), 'uploads/nurse');
            $user->profilePhoto = $profilePhoto;
        }

        if ($request->hasFile('drivingLicense')) {
            FileUpload::deleteFile($user->drivingLicense);
            $drivingLicense = FileUpload::storeFile($request->file('drivingLicense'), 'uploads/nurse');
            $user->drivingLicense = $drivingLicense;
        }

        if ($request->hasFile('goodConductCertificate')) {
            FileUpload::deleteFile($user->goodConductCertificate);
            $goodConductCertificate = FileUpload::storeFile($request->file('goodConductCertificate'), 'uploads/nurse');
            $user->goodConductCertificate = $goodConductCertificate;
        }

        if ($request->hasFile('referenceLetter')) {
            FileUpload::deleteFile($user->referenceLetter);
            $referenceLetter = FileUpload::storeFile($request->file('referenceLetter'), 'uploads/nurse');
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
            'type' => 'nurse',
        ]);

        $nurse = Nurse::firstOrNew(['user_id' => $user->id]);

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

        return redirect()->route('specialist.index')->with('message', 'Nurse profile updated successfully.');

    }

    public function nurseAssistantUpdate(Request $request, $id)
    {

        $user = User::findOrFail($id);

        if ($request->hasFile('idCopy')) {
            FileUpload::deleteFile($user->idCopy);
            $idCopy = FileUpload::storeFile($request->file('idCopy'), 'uploads/nurse');
            $user->idCopy = $idCopy;
        }

        if ($request->hasFile('profilePhoto')) {
            FileUpload::deleteFile($user->profilePhoto);
            $profilePhoto = FileUpload::storeFile($request->file('profilePhoto'), 'uploads/nurse');
            $user->profilePhoto = $profilePhoto;
        }

        if ($request->hasFile('drivingLicense')) {
            FileUpload::deleteFile($user->drivingLicense);
            $drivingLicense = FileUpload::storeFile($request->file('drivingLicense'), 'uploads/nurse');
            $user->drivingLicense = $drivingLicense;
        }

        if ($request->hasFile('goodConductCertificate')) {
            FileUpload::deleteFile($user->goodConductCertificate);
            $goodConductCertificate = FileUpload::storeFile($request->file('goodConductCertificate'), 'uploads/nurse');
            $user->goodConductCertificate = $goodConductCertificate;
        }

        if ($request->hasFile('referenceLetter')) {
            FileUpload::deleteFile($user->referenceLetter);
            $referenceLetter = FileUpload::storeFile($request->file('referenceLetter'), 'uploads/nurse');
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
            'type' => 'nurse-assistant',
        ]);

        $nurse = NurseAssistant::firstOrNew(['user_id' => $user->id]);

        if ($request->hasFile('educationCertificate')) {
            FileUpload::deleteFile($nurse->educationCertificate);
            $educationCertificate = FileUpload::storeFile($request->file('educationCertificate'), 'uploads/nurse');
            $nurse->educationCertificate = $educationCertificate;
        }

        $nurse->fill([
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

        return redirect()->route('specialist.index')->with('message', 'Nurse profile updated successfully.');

    }

    public function specialistNeedUpdate(Request $request, $id)
    {

        $user = User::findOrFail($id);

        if ($request->hasFile('idCopy')) {
            FileUpload::deleteFile($user->idCopy);
            $idCopy = FileUpload::storeFile($request->file('idCopy'), 'uploads/specialist-need');
            $user->idCopy = $idCopy;
        }

        if ($request->hasFile('profilePhoto')) {
            FileUpload::deleteFile($user->profilePhoto);
            $profilePhoto = FileUpload::storeFile($request->file('profilePhoto'), 'uploads/specialist-need');
            $user->profilePhoto = $profilePhoto;
        }

        if ($request->hasFile('drivingLicense')) {
            FileUpload::deleteFile($user->drivingLicense);
            $drivingLicense = FileUpload::storeFile($request->file('drivingLicense'), 'uploads/specialist-need');
            $user->drivingLicense = $drivingLicense;
        }

        if ($request->hasFile('goodConductCertificate')) {
            FileUpload::deleteFile($user->goodConductCertificate);
            $goodConductCertificate = FileUpload::storeFile($request->file('goodConductCertificate'), 'uploads/specialist-need');
            $user->goodConductCertificate = $goodConductCertificate;
        }

        if ($request->hasFile('referenceLetter')) {
            FileUpload::deleteFile($user->referenceLetter);
            $referenceLetter = FileUpload::storeFile($request->file('referenceLetter'), 'uploads/specialist-need');
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
            'type' => 'special-need',
        ]);

        $specialNeed = SpecialNeed::firstOrNew(['user_id' => $user->id]);

        if ($request->hasFile('educationCertificate')) {
            FileUpload::deleteFile($specialNeed->educationCertificate);
            $educationCertificate = FileUpload::storeFile($request->file('educationCertificate'), 'uploads/specialist-need');
            $specialNeed->educationCertificate = $educationCertificate;
        }

        $specialNeed->fill([
            'experience' => $request->experience,
            'isRegisterPCK' => $request->isRegisterPCK,
            'registrationNumber' => $request->registrationNumber,
            'practiceLicense' => $request->practiceLicense,
            'serviceFee' => $request->serviceFee,
            'serviceFeeDay' => $request->serviceFeeDay,
            'serviceFeeMonth' => $request->serviceFeeMonth,
        ]);


        $specialNeed->save();

        return redirect()->route('specialist.index')->with('message', 'Special need profile updated successfully.');

    }
}
