<?php

namespace App\Http\Controllers;

use App\Models\Choose;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChooseController extends Controller
{
    public function index()
    {
        $chooses = Choose::all();
        return Inertia::render('Choose/Index', compact('chooses'));
    }

    public function create()
    {
        return Inertia::render('Choose/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:500',
            'icon' => 'required|string|max:1000',
        ]);

        Choose::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'icon' => $request->icon,
        ]);

        return redirect()->route('chooses.index')->with('message', 'Choose created successfully.');
    }

    public function edit($id)
    {
        $choose = Choose::find($id);
        return Inertia::render('Choose/Edit', compact('choose'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:500',
            'icon' => 'required|string',
        ]);

        $choose = Choose::find($id);
        $choose->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'icon' => $request->icon,
        ]);

        return redirect()->route('chooses.index')->with('message', 'Choose updated successfully.');
    }

    public function destroy($id)
    {
        Choose::find($id)->delete();
        return redirect()->route('chooses.index')->with('message', 'Choose deleted successfully.');
    }
}
