<?php

namespace App\Http\Controllers;

use App\Helpers\FileUpload;
use App\Models\CareInstitution;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class InstitutionController extends Controller
{
    public function index()
    {
        $institution = User::with('careInstitution')
            ->where('role', 'care_institutions')
            ->orderBy('id', 'desc')
            ->get();

        return Inertia::render('User/Institution/Index', [
            'institutions' => $institution,
        ]);
    }

    public function create()
    {
        return Inertia::render('User/Institution/Create');
    }

    public function store(Request $request)
    {
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
            'role' => 'care_institutions',
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

        return redirect()->route('institution.index')->with('message', 'Care institution created successfully');
    }

}
