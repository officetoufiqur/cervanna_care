<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Notifications\UserNotification;
use Illuminate\Support\Facades\Hash;
use App\Models\Agency;
use App\Models\CareInstitution;
use App\Helpers\FileUpload;

class UserController extends Controller
{
    public function userIndex()
    {
        $users = User::where('role', 'user')->orderBy('id', 'desc')->get();

        return Inertia::render('User/Index', [
            'users' => $users,
        ]);
    }

    public function userCreate()
    {
        return Inertia::render('User/Create');
    }

    public function userStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'number' => 'required',
            // 'profileImage' => 'nullable|image|mimes:jpeg,webp,png,jpg,gif|max:2048',
            'age' => 'required',
            'gender' => 'required',
            'password' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'number' => $request->number,
            'role' => 'user',
            'age' => $request->age,
            'gender' => $request->gender,
            'password' => bcrypt($request->password),
            'is_profile_verified' => true,
            'is_profile_completed' => true,
        ]);

        return redirect()->route('all-user.index')->with('message', 'User created successfully');
    }

    public function userEdit($id)
    {
        $user = User::find($id);

        return Inertia::render('User/Edit', [
            'user' => $user,
        ]);
    }

    public function userUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'number' => 'required',
            // 'profileImage' => 'nullable|image|mimes:jpeg,webp,png,jpg,gif|max:2048',
            'age' => 'required',
            'gender' => 'required',
        ]);
        $user = User::find($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'number' => $request->number,
            'age' => $request->age,
            'gender' => $request->gender,
        ]);

        $user->notify(new UserNotification('Profile status updated successfully', $user->id));

        return redirect()->route('all-user.index')->with('message', 'User updated successfully');
    }


    public function specialistEdit($id)
    {
       $specialist = User::find($id);

       if($specialist->subRole === 'house-manager') {
           $houseManager = User::with('houseManager')->find($id);
            return Inertia::render('User/HouseManagerEdit', [
                'specialist' => $houseManager,
            ]);
       }
       if($specialist->subRole === 'nurse') {
            $nurse = User::with('nurse')->find($id);
            return Inertia::render('User/NurseEdit', [
                'specialist' => $nurse,
            ]);
       }
       if($specialist->subRole === 'physiotherapist') {
            $physiotherapist = User::with('physiotherapist')->find($id);
            return Inertia::render('User/PhysiotherapistEdit', [
                'specialist' => $physiotherapist,
            ]);
       }
       if($specialist->subRole === 'nurse-aide-or-assistant') {
          $nurseAssistant = User::with('nurseAssistant')->find($id);
            return Inertia::render('User/NurseAssistantEdit', [
                'specialist' => $nurseAssistant,
            ]);
       }

       if($specialist->subRole === 'special-need-caregivers') {
           $specialNeed = User::with('specialNeed')->find($id);
            return Inertia::render('User/SpecialNeedEdit', [
                'specialist' => $specialNeed,
            ]);
       }


    }

    public function specialistUpdate(Request $request, $id)
    {
        $request->validate([
            'is_profile_verified' => 'required',
        ]);
        $specialist = User::find($id);
        $specialist->update([
            'is_profile_verified' => $request->is_profile_verified,
        ]);

        $specialist->notify(new UserNotification('Profile status updated successfully', $specialist->id));

        return redirect()->route('specialist.index')->with('message', 'Specialist updated successfully');
    }

    public function agencyIndex()
    {
        $agencies = User::with(['agency', 'careInstitution'])
            ->whereIn('role', ['agency', 'care_institutions'])
            ->orderBy('id', 'desc')
            ->get();

        return Inertia::render('User/Agency/AgencyIndex', [
            'agencies' => $agencies,
        ]);
    }

    public function agencyCreate()
    {
        return Inertia::render('User/Agency/AgencyCreate');
    }

    public function agencyStore(Request $request)
    {

        if ($request->role === 'agency') {

                $request->validate([

                    'email' => 'required',
                    'password' => 'required',
                    'number' => 'nullable',
                    'companyName' => 'nullable',
                    'kraPin' => 'nullable',
                    'companyRegistrationNumber' => 'nullable',
                    'alternative_number' => 'nullable',
                    'role' => 'required',
                    'businessLocation' => 'nullable',
                    'registrationDocument' => 'nullable',
                    'agency_services' => 'nullable',
                    'placementFee' => 'nullable',
                    'replacementWindow' => 'nullable',
                    'numberOfReplacement' => 'nullable',

                ]);

                $user = User::create([
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => $request->role,
                    'number' => $request->number,
                    'otp' => '123456',
                    'is_profile_completed' => true,
                    'is_profile_verified' => true,
                ]);


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

                return redirect()->route('agency.index')->with('message', 'Agency created successfully');

        }
        
        if($request->role === 'care_institutions'){

            $request->validate([
                'email' => 'required',
                'password' => 'required',
                'number' => 'nullable',
                'companyName' => 'nullable',
                'kraPin' => 'nullable',
                'companyRegistrationNumber' => 'nullable',
                'alternative_number' => 'nullable',
                'role' => 'required',
                'businessLocation' => 'nullable',
                'registrationDocument' => 'nullable',
            ]);

            $user = User::create([

                'email' => $request->email,
                'password' => Hash::make($request->password),
                'number' => $request->number,
                'otp' => '123456',
                'role' => $request->role,
                'is_profile_completed' => true,
                'is_profile_verified' => true,
            ]);

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
                'number' => $request->alternative_number,
                'businessLocation' => $request->businessLocation,
            ]);

            $careInstitution->save();

            return redirect()->route('agency.index')->with('message', 'Care institution created successfully');
        }

    }

    public function agencyEdit($id)
    {
        $agency = User::with(['agency', 'careInstitution'])
            ->findOrFail($id);

        return Inertia::render('User/Agency/AgencyEdit', [
            'agency' => $agency,
        ]);
    }

    public function agencyUpdate(Request $request, $id)
    {
        
        $user = User::findOrFail($id);


        if ($request->role === 'agency') {

            $request->validate([
                'email' => 'required|email',
                'number' => 'nullable',
                'companyName' => 'nullable',
                'kraPin' => 'nullable',
                'companyRegistrationNumber' => 'nullable',
                'alternative_number' => 'nullable',
                'role' => 'required',
                'businessLocation' => 'nullable',
                'registrationDocument' => 'nullable|mimes:pdf,png,jpg,jpeg,webp|max:2048',
                'agency_services' => 'nullable|array',
                'placementFee' => 'nullable',
                'replacementWindow' => 'nullable',
                'numberOfReplacement' => 'nullable',
            ]);

            $user->email = $request->email;
            $user->number = $request->number;
            $user->role = $request->role;
            $user->is_profile_completed = $request->is_profile_completed;
            $user->is_profile_verified = $request->is_profile_verified;
            $user->update();

            $agency = Agency::where('user_id', $user->id)->firstOrFail();

            $registrationDocument = null;
            if ($request->hasFile('registrationDocument')) {
                $registrationDocument = FileUpload::updateFile(
                    $request->file('registrationDocument'),
                    'uploads/agency',
                    $agency->registrationDocument
                );

                $agency->registrationDocument = $registrationDocument;
            }

            $agency->update([
                'companyName' => $request->companyName,
                'kraPin' => $request->kraPin,
                'companyRegistrationNumber' => $request->companyRegistrationNumber,
                'number' => $request->alternative_number,
                'agency_services' => $request->agency_services,
                'businessLocation' => $request->businessLocation,
                'placementFee' => $request->placementFee,
                'replacementWindow' => $request->replacementWindow,
                'numberOfReplacement' => $request->numberOfReplacement,
            ]);

            return redirect()->route('agency.index')->with('message', 'Agency updated successfully');
        }

        if ($request->role === 'care_institutions') {

            $request->validate([
                'email' => 'required|email',
                'number' => 'nullable',
                'companyName' => 'nullable',
                'kraPin' => 'nullable',
                'companyRegistrationNumber' => 'nullable',
                'alternative_number' => 'nullable',
                'role' => 'required',
                'businessLocation' => 'nullable',
                'registrationDocument' => 'nullable|mimes:pdf,png,jpg,jpeg,webp|max:2048',
            ]);

            $user->email = $request->email;
            $user->number = $request->number;
            $user->role = $request->role;
            $user->is_profile_completed = $request->is_profile_completed;
            $user->is_profile_verified = $request->is_profile_verified;
            $user->update();

            $careInstitution = CareInstitution::where('user_id', $user->id)->firstOrFail();



            $registrationDocument = null;
            if ($request->hasFile('registrationDocument')) {
                $registrationDocument = FileUpload::storeFile(
                    $request->file('registrationDocument'),
                    'uploads/careInstitution'
                );

                $careInstitution->registrationDocument = $registrationDocument;
            }



            $careInstitution->update([
                'companyName' => $request->companyName,
                'kraPin' => $request->kraPin,
                'companyRegistrationNumber' => $request->companyRegistrationNumber,
                'number' => $request->alternative_number,
                'businessLocation' => $request->businessLocation,
            ]);

            return redirect()->route('agency.index')->with('message', 'Care institution updated successfully');
        }
    }

    
}
