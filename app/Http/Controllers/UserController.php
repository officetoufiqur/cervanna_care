<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;

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
            'name' => 'required',
            'is_profile_verified' => 'required',
        ]);
        $user = User::find($id);
        $user->update([
            'name' => $request->name,
            'is_profile_verified' => $request->is_profile_verified,
        ]);
        return redirect()->route('all-user.index')->with('message', 'User updated successfully');
    }

    public function specialistIndex()
    {
        $specialists = User::where('role', "!=" , "user")->where('role', "!=" , "admin")->orderBy('id', 'desc')->get();    

        return Inertia::render('User/SpecialistIndex', [
            'specialists' => $specialists,
        ]);
    }
}
