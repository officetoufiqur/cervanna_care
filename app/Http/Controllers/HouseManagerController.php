<?php

namespace App\Http\Controllers;

use App\Helpers\FileUpload;
use App\Models\HouseManager;
use App\Models\User;
use Illuminate\Http\Request;

class HouseManagerController extends Controller
{
    public function houseManagerUpdate(Request $request, $id)
    {

        $user = User::findOrFail($id);

        if ($request->hasFile('idCopy')) {
            FileUpload::deleteFile($user->idCopy);
            $idCopy = FileUpload::storeFile($request->file('idCopy'), 'uploads/house-managers');
            $user->idCopy = $idCopy;
        }

        if ($request->hasFile('profilePhoto')) {
            FileUpload::deleteFile($user->profilePhoto);
            $profilePhoto = FileUpload::storeFile($request->file('profilePhoto'), 'uploads/house-managers');
            $user->profilePhoto = $profilePhoto;
        }

        if ($request->hasFile('drivingLicense')) {
            FileUpload::deleteFile($user->drivingLicense);
            $drivingLicense = FileUpload::storeFile($request->file('drivingLicense'), 'uploads/house-managers');
            $user->drivingLicense = $drivingLicense;
        }

        if ($request->hasFile('goodConductCertificate')) {
            FileUpload::deleteFile($user->goodConductCertificate);
            $goodConductCertificate = FileUpload::storeFile($request->file('goodConductCertificate'), 'uploads/house-managers');
            $user->goodConductCertificate = $goodConductCertificate;
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
            'type' => 'house-manager',
        ]);

        $houseManager = HouseManager::firstOrNew(['user_id' => $user->id]);

         if ($request->hasFile('firstAidCertificate')) {
            FileUpload::deleteFile($houseManager->firstAidCertificate);
            $firstAidCertificate = FileUpload::storeFile($request->file('firstAidCertificate'), 'uploads/house-managers');
            $houseManager->firstAidCertificate = $firstAidCertificate;
        }

        $houseManager->fill([
            'experience' => $request->experience,
            'experienceYear' => $request->experienceYear,
            'salaryRange' => $request->salaryRange,
            'isMother' => $request->isMother,
            'ageOfKids' => $request->ageOfKids,
            'isHandelingPet' => $request->isHandelingPet,
            'preferBeingA' => $request->preferBeingA

        ]);

        $houseManager->save();

        return redirect()->route('specialist.index')->with('message', 'House Manager profile updated successfully.');

    }
}
