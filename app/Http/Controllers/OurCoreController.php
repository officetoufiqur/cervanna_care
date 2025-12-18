<?php

namespace App\Http\Controllers;

use App\Models\OurCore;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OurCoreController extends Controller
{
    public function index() {
        $ourCore = OurCore::all();
        return Inertia::render('OurCore/Index', compact('ourCore'));
    }

    public function create() {
        return Inertia::render('OurCore/Create');
    }

    public function store(Request $request)
    {
         $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'icon' => 'required|string|max:1000',
        ]);

        OurCore::create([
            'title' => $request->title,
            'description' => $request->description,
            'icon' => $request->icon
        ]);

        return redirect()->route('our-cores.index')->with('message', 'Core created successfully.');
    }

    public function edit($id) {
        $core = OurCore::find($id);
        return Inertia::render('OurCore/Edit', compact('core'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'icon' => 'required|string|max:1000',
        ]);

        $ourCore = OurCore::find($id);
        $ourCore->update([
            'title' => $request->title,
            'description' => $request->description,
            'icon' => $request->icon
        ]);

        return redirect()->route('our-cores.index')->with('message', 'Core updated successfully.');
    }

    public function destroy($id) {
        OurCore::find($id)->delete();
        return redirect()->route('our-cores.index')->with('message', 'Core deleted successfully.');
    }
}
