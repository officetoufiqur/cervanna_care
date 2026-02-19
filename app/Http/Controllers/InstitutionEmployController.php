<?php

namespace App\Http\Controllers;

use App\Helpers\FileUpload;
use App\Models\CareInstitution;
use App\Models\InstitutionNurse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InstitutionEmployController extends Controller
{
    public function index()
    {
        $employees = InstitutionNurse::get();

        return Inertia::render('User/Institution/Employee/Index', [
            'employees' => $employees,
        ]);
    }

    public function create()
    {
        $institutions = CareInstitution::select('id', 'companyName')->get();

        return Inertia::render('User/Institution/Employee/Create', [
            'institutions' => $institutions,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([

            'fullName' => 'nullable|string|max:255',
            'age' => 'nullable|integer',
            'location' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:255',
            'education' => 'nullable|string|max:255',
            'canDrive' => 'nullable|boolean',
            'preferredRole' => 'nullable|string|max:255',
            'languages' => 'nullable|array|min:1',
            'isNursingInKenya' => 'nullable|boolean',
            'registrationNumber' => 'nullable',
            'hospitalBasedCare' => 'nullable|boolean',
            'services' => 'nullable|array|min:1',
            'hospitalBasedYearsOfExperience' => 'nullable|integer',
            'hospitalBasedReferenceContact' => 'nullable|string|max:255',
            'homeBasedCare' => 'nullable|boolean',
            'homeBasedYearsOfExperience' => 'nullable|integer',
            'homeBasedReferenceContact' => 'nullable|string|max:255',
            'mobilityYears' => 'nullable|string|max:255',
            'bathingYears' => 'nullable|string|max:255',
            'feedingYears' => 'nullable|string|max:255',
            'serviceFee' => 'nullable|integer',
            'serviceFeeDay' => 'nullable',
            'serviceFeeMonth' => 'nullable',
            'bio' => 'nullable|string|max:255',
            'practiceLicense' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',
            'educationCertificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',
            'idCopy' => 'nullable|image|mimes:pdf,jpg,jpeg,png,webp|max:2048',
            'profilePhoto' => 'nullable|image|mimes:pdf,jpg,jpeg,png,webp|max:2048',
        ]);

        $care_institution_id = CareInstitution::where('id', $request->care_institution_id)->first();

        $institutionNurse = new InstitutionNurse;
        $institutionNurse->care_institution_id = $care_institution_id->id;
        $institutionNurse->fullName = $request->fullName;
        $institutionNurse->age = $request->age;
        $institutionNurse->location = $request->location;
        $institutionNurse->experience = $request->experience;
        $institutionNurse->gender = $request->gender;
        $institutionNurse->education = $request->education;
        $institutionNurse->canDrive = $request->canDrive;
        $institutionNurse->preferredRole = $request->preferredRole;
        $institutionNurse->languages = $request->languages;
        $institutionNurse->isNursingInKenya = $request->isNursingInKenya;
        $institutionNurse->registrationNumber = $request->registrationNumber;
        $institutionNurse->hospitalBasedCare = $request->hospitalBasedCare;
        $institutionNurse->services = $request->services;
        $institutionNurse->hospitalBasedYearsOfExperience = $request->hospitalBasedYearsOfExperience;
        $institutionNurse->hospitalBasedReferenceContact = $request->hospitalBasedReferenceContact;
        $institutionNurse->homeBasedCare = $request->homeBasedCare;
        $institutionNurse->homeBasedYearsOfExperience = $request->homeBasedYearsOfExperience;
        $institutionNurse->homeBasedReferenceContact = $request->homeBasedReferenceContact;
        $institutionNurse->mobilityYears = $request->mobilityYears;
        $institutionNurse->bathingYears = $request->bathingYears;
        $institutionNurse->feedingYears = $request->feedingYears;
        $institutionNurse->serviceFee = $request->serviceFee;
        $institutionNurse->serviceFeeDay = $request->serviceFeeDay;
        $institutionNurse->serviceFeeMonth = $request->serviceFeeMonth;
        $institutionNurse->bio = $request->bio;

        if ($request->hasFile('practiceLicense')) {
            $institutionNurse->practiceLicense = FileUpload::storeFile(
                $request->file('practiceLicense'),
                'uploads/institutionNurses'
            );
        }

        if ($request->hasFile('idCopy')) {
            $institutionNurse->idCopy = FileUpload::storeFile(
                $request->file('idCopy'),
                'uploads/institutionNurses'
            );
        }

        if ($request->hasFile('profilePhoto')) {
            $institutionNurse->profilePhoto = FileUpload::storeFile(
                $request->file('profilePhoto'),
                'uploads/institutionNurses'
            );
        }

        if ($request->hasFile('educationCertificate')) {
            $institutionNurse->educationCertificate = FileUpload::storeFile(
                $request->file('educationCertificate'),
                'uploads/institutionNurses'
            );
        }

        $institutionNurse->save();

        return redirect()->route('institution-employees.index')->with('message', 'Institution Nurse created successfully.');
    }

    public function edit($id)
    {
        $employee = InstitutionNurse::findOrFail($id);
        $institutions = CareInstitution::select('id', 'companyName')->get();

        return Inertia::render('User/Institution/Employee/Edit', [
            'employee' => $employee,
            'institutions' => $institutions,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([

            'fullName' => 'nullable|string|max:255',
            'age' => 'nullable|integer',
            'location' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:255',
            'education' => 'nullable|string|max:255',
            'canDrive' => 'nullable|boolean',
            'preferredRole' => 'nullable|string|max:255',
            'languages' => 'nullable|array|min:1',
            'isNursingInKenya' => 'nullable|boolean',
            'registrationNumber' => 'nullable',
            'hospitalBasedCare' => 'nullable|boolean',
            'services' => 'nullable|array|min:1',
            'hospitalBasedYearsOfExperience' => 'nullable|integer',
            'hospitalBasedReferenceContact' => 'nullable|string|max:255',
            'homeBasedCare' => 'nullable|boolean',
            'homeBasedYearsOfExperience' => 'nullable|integer',
            'homeBasedReferenceContact' => 'nullable|string|max:255',
            'mobilityYears' => 'nullable|string|max:255',
            'bathingYears' => 'nullable|string|max:255',
            'feedingYears' => 'nullable|string|max:255',
            'serviceFee' => 'nullable|integer',
            'serviceFeeDay' => 'nullable',
            'serviceFeeMonth' => 'nullable',
            'bio' => 'nullable|string|max:255',
            'practiceLicense' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',
            'educationCertificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',
            'idCopy' => 'nullable|image|mimes:pdf,jpg,jpeg,png,webp|max:2048',
            'profilePhoto' => 'nullable|image|mimes:pdf,jpg,jpeg,png,webp|max:2048',
        ]);

        $care_institution_id = CareInstitution::where('id', $request->care_institution_id)->first();

        $institutionNurse = InstitutionNurse::findOrFail($id);
        $institutionNurse->care_institution_id = $care_institution_id->id;
        $institutionNurse->fullName = $request->fullName;
        $institutionNurse->age = $request->age;
        $institutionNurse->location = $request->location;
        $institutionNurse->experience = $request->experience;
        $institutionNurse->gender = $request->gender;
        $institutionNurse->education = $request->education;
        $institutionNurse->canDrive = $request->canDrive;
        $institutionNurse->preferredRole = $request->preferredRole;
        $institutionNurse->languages = $request->languages;
        $institutionNurse->isNursingInKenya = $request->isNursingInKenya;
        $institutionNurse->registrationNumber = $request->registrationNumber;
        $institutionNurse->hospitalBasedCare = $request->hospitalBasedCare;
        $institutionNurse->services = $request->services;
        $institutionNurse->hospitalBasedYearsOfExperience = $request->hospitalBasedYearsOfExperience;
        $institutionNurse->hospitalBasedReferenceContact = $request->hospitalBasedReferenceContact;
        $institutionNurse->homeBasedCare = $request->homeBasedCare;
        $institutionNurse->homeBasedYearsOfExperience = $request->homeBasedYearsOfExperience;
        $institutionNurse->homeBasedReferenceContact = $request->homeBasedReferenceContact;
        $institutionNurse->mobilityYears = $request->mobilityYears;
        $institutionNurse->bathingYears = $request->bathingYears;
        $institutionNurse->feedingYears = $request->feedingYears;
        $institutionNurse->serviceFee = $request->serviceFee;
        $institutionNurse->serviceFeeDay = $request->serviceFeeDay;
        $institutionNurse->serviceFeeMonth = $request->serviceFeeMonth;
        $institutionNurse->bio = $request->bio;

        if ($request->hasFile('practiceLicense')) {
            FileUpload::deleteFile($institutionNurse->practiceLicense);
            $institutionNurse->practiceLicense = FileUpload::storeFile(
                $request->file('practiceLicense'),
                'uploads/institutionNurses'
            );
        }

        if ($request->hasFile('idCopy')) {
            FileUpload::deleteFile($institutionNurse->idCopy);
            $institutionNurse->idCopy = FileUpload::storeFile($request->file('idCopy'), 'uploads/institutionNurses');
        }

        if ($request->hasFile('profilePhoto')) {
            FileUpload::deleteFile($institutionNurse->profilePhoto);
            $institutionNurse->profilePhoto = FileUpload::storeFile(
                $request->file('profilePhoto'),
                'uploads/institutionNurses'
            );
        }

        if ($request->hasFile('educationCertificate')) {
            FileUpload::deleteFile($institutionNurse->educationCertificate);
            $institutionNurse->educationCertificate = FileUpload::storeFile(
                $request->file('educationCertificate'),
                'uploads/institutionNurses'
            );
        }

        $institutionNurse->save();

        return redirect()->route('institution-employees.index')->with('message', 'Institution Nurse updated successfully.');
    }

    public function destroy($id)
    {
        $institutionNurse = InstitutionNurse::findOrFail($id);

        // Delete associated files
        FileUpload::deleteFile($institutionNurse->practiceLicense);
        FileUpload::deleteFile($institutionNurse->idCopy);
        FileUpload::deleteFile($institutionNurse->profilePhoto);
        FileUpload::deleteFile($institutionNurse->educationCertificate);

        $institutionNurse->delete();

        return redirect()->route('institution-employees.index')->with('message', 'Institution Nurse deleted successfully.');
    }
}
