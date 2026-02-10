<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Notifications\UserNotification;

class UserController extends Controller
{
    public function userIndex()
    {
        $users = User::where('role', 'user')->orderBy('id', 'desc')->get();

        return Inertia::render('User/Index', [
            'users' => $users,
        ]);
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
            'is_profile_verified' => 'required',
        ]);
        $user = User::find($id);
        $user->update([
            'is_profile_verified' => $request->is_profile_verified,
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

        return Inertia::render('User/AgencyIndex', [
            'agencies' => $agencies,
        ]);
    }

    public function agencyEdit($id)
    {
        $agency = User::with(['agency', 'careInstitution'])
            ->findOrFail($id);

        return Inertia::render('User/AgencyEdit', [
            'agency' => $agency,
        ]);
    }

    public function agencyUpdate(Request $request, $id)
    {
        $request->validate([
            'is_profile_verified' => 'required',
        ]);
        $agency = User::find($id);
        $agency->update([
            'is_profile_verified' => $request->is_profile_verified,
        ]);

        $agency->notify(new UserNotification('Profile status updated successfully', $agency->id));

        return redirect()->route('agency.index')->with('message', 'Agency updated successfully');
    }
    
}
