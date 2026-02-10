<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;
use App\Models\HouseManager;
use App\Helpers\FileUpload;
use App\Models\Skill;

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
        $type = request()->get('type');
        if ($type === 'house-manager') {
            return Inertia::render('User/Specialist/HouseManagerCreate');
        }

        if ($type === 'nurse') {
           $skills = Skill::where('type', 'nurse')->get();
            return Inertia::render('User/Specialist/NurseCreate', [
                'skills' => $skills,
            ]);
        }

        // if ($type === 'physiotherapist') {
        //     return Inertia::render('User/Specialist/PhysiotherapistCreate');
        // }

        // if ($type === 'special-needs') {
        //     return Inertia::render('User/Specialist/SpecialNeedsCreate');
        // }
    }

    public function specialistStore(Request $request)
    {
        $type = request()->get('type');
        if ($type === 'house-manager') {
          


            $validated = $request->validate([
                'subRole' => 'required|string',
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',

                'number' => 'required|string',
                'number_two' => 'required|string',

                'education' => 'required|string',
                'experience' => 'required|string',
                'location' => 'required|string',
                'preferredRole' => 'required|string',
                'salaryRange' => 'required|string',

                'languages' => 'required|array|min:1',
                'preferred' => 'required|string',

                'isMother' => 'required|boolean',
                'ageOfKids' => 'required|array|min:1',
                'isHandelingPet' => 'required|boolean',

                'idCopy' => 'required|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                'profilePhoto' => 'required|file|mimes:jpg,jpeg,png,webp|max:2048',
                'drivingLicense' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                'firstAidCertificate' => 'required|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                'goodConductCertificate' => 'required|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',
            ]);

            /** FILE UPLOADS */
            $path = 'uploads/house-manager';

            $idCopy = FileUpload::storeFile($request->file('idCopy'), $path);
            $profilePhoto = FileUpload::storeFile($request->file('profilePhoto'), $path);
            $goodConductCertificate = FileUpload::storeFile($request->file('goodConductCertificate'), $path);
            $firstAidCertificate = FileUpload::storeFile($request->file('firstAidCertificate'), $path);

            $drivingLicense = $request->hasFile('drivingLicense')
                ? FileUpload::storeFile($request->file('drivingLicense'), $path)
                : null;

            /** USER */
            $user = User::create([
                'role' => 'specialist',
                'subRole' => $validated['subRole'],
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'number' => $validated['number'],
                'number_two' => $validated['number_two'],
                'education' => $validated['education'],
                'experience' => $validated['experience'],
                'location' => $validated['location'],
                'preferredRole' => $validated['preferredRole'],
                'languages' => $validated['languages'],
                'preferred' => $validated['preferred'],
                'salaryRange' => $validated['salaryRange'],
                'idCopy' => $idCopy,
                'profilePhoto' => $profilePhoto,
                'drivingLicense' => $drivingLicense,
                'goodConductCertificate' => $goodConductCertificate,
                'is_profile_completed' => true,
                'is_profile_verified' => true,
                'email_verified_at' => now(),
                'otp' => '123456',
            ]);

            /** HOUSE MANAGER */
            HouseManager::create([
                'user_id' => $user->id,
                'firstAidCertificate' => $firstAidCertificate,
                'isMother' => $validated['isMother'],
                'ageOfKids' => $validated['ageOfKids'],
                'isHandelingPet' => $validated['isHandelingPet'],
                'salaryRange' => $validated['salaryRange'],
                'experience' => $validated['experience'],
            ]);

            // Optional notification
            // $user->notify(new UserNotification('Specialist created successfully'));

            return redirect()
                ->route('specialist.index')
                ->with('success', 'Specialist created successfully');
        }
    }
}
