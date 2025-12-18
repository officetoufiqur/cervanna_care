<?php

namespace App\Http\Controllers;

use App\Models\Works;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WorksController extends Controller
{
    public function index() {
        $works = Works::all();

        return Inertia::render('Works/Index', [
            'works' => $works
        ]);
    }

    public function create() {
        return Inertia::render('Works/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string |max:500',
            'icon' => 'required|max:1000',
        ]);

        Works::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'icon' => $request->icon,
        ]);

        return redirect()->route('works.index')->with('message', 'Work created successfully.');
    }

    public function edit(Works $work) {
        return Inertia::render('Works/Edit', [
            'work' => $work
        ]);
    }

    public function update(Request $request, Works $work) {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string |max:500',
            'icon' => 'required|max:1000',
        ]);

        $work->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'icon' => $request->icon,
        ]);

        return redirect()->route('works.index')->with('message', 'Work updated successfully.');
    }

    public function destroy(Works $work) {
        $work->delete();

        return redirect()->route('works.index')->with('message', 'Work deleted successfully.');
    }
}
