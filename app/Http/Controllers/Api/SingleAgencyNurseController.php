<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InstitutionNurse;
use App\Models\AgencyEmployee;
use App\Helpers\FileUpload;
use App\Models\Agency;
use App\Models\Schedule;
use App\Models\CareInstitution;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SingleAgencyNurseController extends Controller
{

    // Agency Employee

    public function storeAgencyEmployee(Request $request)
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
        $agency_id = Agency::where('user_id', $user->id)->first();

        if($agency_id == null){
            return response()->json([
                'status' => false,
                'message' => 'Agency not found',
            ], 404);
        }

        $agencyEmployee = new AgencyEmployee();
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


        if($request->hasFile('idCopy')){
            $agencyEmployee->idCopy = FileUpload::storeFile($request->file('idCopy'), 'uploads/employees');
        }

        if($request->hasFile('profilePhoto')){
            $agencyEmployee->profilePhoto = FileUpload::storeFile($request->file('profilePhoto'), 'uploads/employees');
        }

        if($request->hasFile('drivingLicense')){
            $agencyEmployee->drivingLicense = FileUpload::storeFile($request->file('drivingLicense'), 'uploads/employees');
        }

        if($request->hasFile('goodConductCertificate')){
            $agencyEmployee->goodConductCertificate = FileUpload::storeFile($request->file('goodConductCertificate'), 'uploads/employees');
        }

        if($request->hasFile('aidCertificate')){
            $agencyEmployee->aidCertificate = FileUpload::storeFile($request->file('aidCertificate'), 'uploads/employees');
        }

        $agencyEmployee->save();


        return response()->json([
            'status' => true,
            'message' => 'Agency employee created successfully',
        ], 200);
    }

    public function updateAgencyEmployee(Request $request, $id)
    {

        $user = auth()->user();

        if($user->role !== 'agency') {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized',
            ], 401);
        }
       
        $agency_id = $user->agency->id;

        $request->validate([

            'name' => 'nullable',
            'educationLevel' => 'nullable',
            'location' => 'nullable',
            'experience' => 'nullable',
            'salaryRange' => 'nullable',
            'isMother' => 'nullable',
            'kidAges' => 'nullable',
            'handlePets' => 'nullable',
            'preferredRole' => 'nullable',
            'languages' => 'nullable',
            'cooking' => 'nullable',
            'housekeeping' => 'nullable',
            'childcare' => 'nullable',
            'preferred' => 'nullable',

            'idCopy' => 'nullable|image|mimes:pdf,jpg,jpeg,png,webp|max:2048',
            'profilePhoto' => 'nullable|image|mimes:pdf,jpg,jpeg,png,webp|max:2048',
            'drivingLicense' => 'nullable|image|mimes:pdf,jpg,jpeg,png,webp|max:2048',
            'goodConductCertificate' => 'nullable|image|mimes:pdf,jpg,jpeg,png,webp|max:2048',
            'aidCertificate' => 'nullable|image|mimes:pdf,jpg,jpeg,png,webp|max:2048',
        ]);    

        $agencyEmployee = AgencyEmployee::findOrFail($id);

        $agencyEmployee->agency_id = $agency_id;
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

        $idCopy = null;
        if ($request->hasFile('idCopy')) {
            $idCopy = FileUpload::updateFile($request->file('idCopy'), 'uploads/employees', $agencyEmployee->idCopy);
            $agencyEmployee->idCopy = $idCopy;

        }

        if ($request->hasFile('profilePhoto')) {
            $profilePhoto = FileUpload::updateFile(
                $request->file('profilePhoto'),
                'uploads/employees',
                $agencyEmployee->profilePhoto
            );
            $agencyEmployee->profilePhoto = $profilePhoto;
        }

        if ($request->hasFile('drivingLicense')) {
            $drivingLicense = FileUpload::updateFile(
                $request->file('drivingLicense'),
                'uploads/employees',
                $agencyEmployee->drivingLicense
            );
            $agencyEmployee->drivingLicense = $drivingLicense;
        }

        if ($request->hasFile('goodConductCertificate')) {
            $goodConductCertificate = FileUpload::updateFile(
                $request->file('goodConductCertificate'),
                'uploads/employees',
                $agencyEmployee->goodConductCertificate
            );
            $agencyEmployee->goodConductCertificate = $goodConductCertificate;
        }

        if ($request->hasFile('aidCertificate')) {
            $aidCertificate = FileUpload::updateFile(
                $request->file('aidCertificate'),
                'uploads/employees',
                $agencyEmployee->aidCertificate
            );
            $agencyEmployee->aidCertificate = $aidCertificate;
        }

        $agencyEmployee->update();


        $specialistId =  $agencyEmployee->id;

        $request->validate([
            'specialist_type' => 'nullable|string',
            'date'           => 'required|array',
            'date.*'         => 'date',
        ]);

        $schedule = Schedule::updateOrCreate(
            [
                'specialist_id' => $specialistId,
            ],
            [
                'specialist_type' => 'agency-employee',
                'date' => $request->date, 
            ]
        );


        return response()->json([
            'status' => true,
            'message' => 'Agency employee updated successfully',
            'data' => $agencyEmployee,
        ], 200);
    }

    public function deleteAgencyEmployee($id)
    {
        $agencyEmployee = AgencyEmployee::findOrFail($id);

        if($agencyEmployee->idCopy){
           Storage::delete('uploads/employees/'.$agencyEmployee->idCopy);
        }

        if($agencyEmployee->profilePhoto){
            Storage::delete('uploads/employees/'.$agencyEmployee->profilePhoto);
        }

        if($agencyEmployee->drivingLicense){
            Storage::delete('uploads/employees/'.$agencyEmployee->drivingLicense);
        }

        if($agencyEmployee->goodConductCertificate){
            Storage::delete('uploads/employees/'.$agencyEmployee->goodConductCertificate);
        }

        if($agencyEmployee->aidCertificate){
            Storage::delete('uploads/employees/'.$agencyEmployee->aidCertificate);
        }

        $agencyEmployee->delete();

        return response()->json([
            'status' => true,
            'message' => 'Agency employee deleted successfully',
        ], 200);
    }

    // Institution Nurse
    public function storeInstitutionNurse(Request $request)
    {

        $user = Auth::user();
        $care_institution_id = CareInstitution::where('user_id', $user->id)->first();

        if($user->role !== 'care_institutions') {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized',
            ], 401);
        }
       

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
            'practiceLicense' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',
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
            'educationCertificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',
            'idCopy' => 'nullable|image|mimes:pdf,jpg,jpeg,png,webp|max:2048',
            'profilePhoto' => 'nullable|image|mimes:pdf,jpg,jpeg,png,webp|max:2048',
        ]);    

        $institutionNurse = new InstitutionNurse();
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

        return response()->json([
            'status' => true,
            'message' => 'Institution nurse created successfully',
        ], 200);    
    }

    public function updateInstitutionNurse(Request $request, $id)
    {

        $user = Auth::user();
        $care_institution_id = CareInstitution::where('user_id', $user->id)->first();

        if($user->role !== 'care_institutions') {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized',
            ], 401);
        }
            

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
            'practiceLicense' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',
            'registrationNumber' => 'nullable|string|max:255',
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
            'educationCertificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',
            'idCopy' => 'nullable|image|mimes:pdf,jpg,jpeg,png,webp|max:2048',
            'profilePhoto' => 'nullable|image|mimes:pdf,jpg,jpeg,png,webp|max:2048',
        ]);    

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
        $institutionNurse->services = $request->services;


        if ($request->hasFile('practiceLicense')) {
            $practiceLicense = FileUpload::updateFile(
                $request->file('practiceLicense'),
                'uploads/institutionNurses',
                $institutionNurse->practiceLicense
            );
            $institutionNurse->practiceLicense = $practiceLicense;
        }

        if ($request->hasFile('idCopy')) {
            $idCopy = FileUpload::updateFile(
                $request->file('idCopy'),
                'uploads/institutionNurses',
                $institutionNurse->idCopy
            );
            $institutionNurse->idCopy = $idCopy;
        }


        if ($request->hasFile('profilePhoto')) {
            $profilePhoto = FileUpload::updateFile(
                $request->file('profilePhoto'),
                'uploads/institutionNurses',
                $institutionNurse->profilePhoto
            );
            $institutionNurse->profilePhoto = $profilePhoto;
        }


        if ($request->hasFile('educationCertificate')) {
            $educationCertificate = FileUpload::updateFile(
                $request->file('educationCertificate'),
                'uploads/institutionNurses',
                $institutionNurse->educationCertificate
            );
            $institutionNurse->educationCertificate = $educationCertificate;
        }

        $institutionNurse->update();


        $specialistId =  $institutionNurse->id;

        $request->validate([
            'specialist_type' => 'nullable|string',
            'date'           => 'required|array',
            'date.*'         => 'date',
        ]);

        $schedule = Schedule::updateOrCreate(
            [
                'specialist_id' => $specialistId,
            ],
            [
                'specialist_type' => 'institution-nurse',
                'date' => $request->date, 
            ]
        );




        return response()->json([
            'status' => true,
            'message' => 'Institution nurse updated successfully',
        ], 200);
    }

    public function deleteInstitutionNurse($id)
    {
        $institutionNurse = InstitutionNurse::findOrFail($id);

        if($institutionNurse->idCopy){
            Storage::delete('uploads/institutionNurses/'.$institutionNurse->idCopy);
        }

        if($institutionNurse->profilePhoto){
            Storage::delete('uploads/institutionNurses/'.$institutionNurse->profilePhoto);
        }

        if($institutionNurse->educationCertificate){
            Storage::delete('uploads/institutionNurses/'.$institutionNurse->educationCertificate);
        }

        $institutionNurse->delete();

        return response()->json([
            'status' => true,
            'message' => 'Institution nurse deleted successfully',
        ], 200);
    }   

}
