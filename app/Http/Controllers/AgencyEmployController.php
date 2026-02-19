<?php

namespace App\Http\Controllers;

use App\Helpers\FileUpload;
use App\Models\Agency;
use App\Models\AgencyEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AgencyEmployController extends Controller
{
    public function index()
    {
        $employees = AgencyEmployee::get();

        return Inertia::render('User/Agency/Employee/Index', [
            'employees' => $employees,
        ]);
    }

    public function create()
    {
        $agency = Agency::get();

        return Inertia::render('User/Agency/Employee/Create', [
            'agencies' => $agency,
        ]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'nullable',
            'educationLevel' => 'nullable',
            'location' => 'nullable',
            'experience' => 'nullable',
            'salaryRange' => 'nullable',
            'isMother' => 'nullable|boolean',
            'kidAges' => 'nullable',
            'handlePets' => 'nullable|boolean',
            'preferredRole' => 'nullable',
            'languages' => 'nullable',
            'cooking' => 'nullable',
            'housekeeping' => 'nullable',
            'childcare' => 'nullable',
            'preferred' => 'nullable',

            'idCopy' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',
            'profilePhoto' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',
            'drivingLicense' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',
            'goodConductCertificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',
            'aidCertificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',
        ]);

        $user = Auth::user();
        $agency_id = Agency::where('id', $request->agency_id)->first();

        if ($agency_id == null) {
            return redirect()->back()->with('error', 'Invalid agency selected');
        }

        $agencyEmployee = new AgencyEmployee;
        $agencyEmployee->agency_id = $agency_id->id;
        $agencyEmployee->name = $request->name;
        $agencyEmployee->educationLevel = $request->educationLevel;
        $agencyEmployee->location = $request->location;
        $agencyEmployee->experience = $request->experience;
        $agencyEmployee->salaryRange = $request->salaryRange;
        $agencyEmployee->isMother = $request->isMother;
        $agencyEmployee->kidAges = $request->kidAges;
        $agencyEmployee->handlePets = $request->handlePets;
        $agencyEmployee->preferredRole = $request->preferredRole;
        $agencyEmployee->languages = $request->languages;
        $agencyEmployee->cooking = $request->cooking;
        $agencyEmployee->housekeeping = $request->housekeeping;
        $agencyEmployee->childcare = $request->childcare;
        $agencyEmployee->preferred = $request->preferred;

        if ($request->hasFile('idCopy')) {
            $agencyEmployee->idCopy = FileUpload::storeFile($request->file('idCopy'), 'uploads/employees');
        }

        if ($request->hasFile('profilePhoto')) {
            $agencyEmployee->profilePhoto = FileUpload::storeFile($request->file('profilePhoto'), 'uploads/employees');
        }

        if ($request->hasFile('drivingLicense')) {
            $agencyEmployee->drivingLicense = FileUpload::storeFile($request->file('drivingLicense'), 'uploads/employees');
        }

        if ($request->hasFile('goodConductCertificate')) {
            $agencyEmployee->goodConductCertificate = FileUpload::storeFile($request->file('goodConductCertificate'), 'uploads/employees');
        }

        if ($request->hasFile('aidCertificate')) {
            $agencyEmployee->aidCertificate = FileUpload::storeFile($request->file('aidCertificate'), 'uploads/employees');
        }

        $agencyEmployee->save();

        return redirect()->route('agency-employees.index')->with('message', 'Agency employee created successfully');
    }

    public function edit($id)
    {
        $employee = AgencyEmployee::findOrFail($id);
        $agency = Agency::get();

        return Inertia::render('User/Agency/Employee/Edit', [
            'employee' => $employee,
            'agencies' => $agency,
        ]);
    }

    public function update(Request $request, $id)
    {
        $employee = AgencyEmployee::findOrFail($id);

        $employee->name = $request->name;
        $employee->educationLevel = $request->educationLevel;
        $employee->location = $request->location;
        $employee->experience = $request->experience;
        $employee->salaryRange = $request->salaryRange;
        $employee->isMother = $request->isMother;
        $employee->kidAges = $request->kidAges;
        $employee->handlePets = $request->handlePets;
        $employee->preferredRole = $request->preferredRole;
        $employee->languages = $request->languages;
        $employee->cooking = $request->cooking;
        $employee->housekeeping = $request->housekeeping;
        $employee->childcare = $request->childcare;
        $employee->preferred = $request->preferred;

        if ($request->hasFile('idCopy')) {
            FileUpload::deleteFile($employee->idCopy);
            $employee->idCopy = FileUpload::storeFile($request->file('idCopy'), 'uploads/employees');
        }

        if ($request->hasFile('profilePhoto')) {
            FileUpload::deleteFile($employee->profilePhoto);
            $employee->profilePhoto = FileUpload::storeFile($request->file('profilePhoto'), 'uploads/employees');
        }

        if ($request->hasFile('drivingLicense')) {
            FileUpload::deleteFile($employee->drivingLicense);
            $employee->drivingLicense = FileUpload::storeFile($request->file('drivingLicense'), 'uploads/employees');
        }

        if ($request->hasFile('goodConductCertificate')) {
            FileUpload::deleteFile($employee->goodConductCertificate);
            $employee->goodConductCertificate = FileUpload::storeFile($request->file('goodConductCertificate'), 'uploads/employees');
        }

        if ($request->hasFile('aidCertificate')) {
            FileUpload::deleteFile($employee->aidCertificate);
            $employee->aidCertificate = FileUpload::storeFile($request->file('aidCertificate'), 'uploads/employees');
        }

        $employee->save();

        return redirect()->route('agency-employees.index')->with('message', 'Agency employee updated successfully');
    }

    public function destroy($id)
    {
        $employee = AgencyEmployee::findOrFail($id);
        FileUpload::deleteFile($employee->idCopy);
        FileUpload::deleteFile($employee->profilePhoto);
        FileUpload::deleteFile($employee->drivingLicense);
        FileUpload::deleteFile($employee->goodConductCertificate);
        FileUpload::deleteFile($employee->aidCertificate);
        $employee->delete();

        return redirect()->route('agency-employees.index')->with('message', 'Agency employee deleted successfully');
    }
}
