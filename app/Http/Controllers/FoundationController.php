<?php

namespace App\Http\Controllers;

use App\Helpers\FileUpload;
use App\Models\Foundation;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FoundationController extends Controller
{
    public function index(){
        $foundation = Foundation::first();

        return Inertia::render('Foundation/Index', compact('foundation'));
    }

    public function edit($id)
    {
        $foundation = Foundation::find($id);
        return Inertia::render('Foundation/Edit', compact('foundation'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'heading' => 'required|string|max:255',
            'subheading' => 'required|string|max:255',
            'vision_title' => 'required|string|max:255',
            'vision_subtitle' => 'required|string|max:255',
            'mission_title' => 'required|string|max:255',
            'mission_subtitle' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $foundation = Foundation::findOrFail($id);

        if($request->hasFile('image')) {
            if($foundation->image) {
                FileUpload::deleteFile($foundation->image);
            }
            $file = FileUpload::storeFile($request->file('image'), 'uploads/foundations');
            $foundation->image = $file;
        }

        $foundation->heading = $request->heading;
        $foundation->subheading = $request->subheading;
        $foundation->vision_title = $request->vision_title;
        $foundation->vision_subtitle = $request->vision_subtitle;
        $foundation->mission_title = $request->mission_title;
        $foundation->mission_subtitle = $request->mission_subtitle;
        $foundation->save();

        return redirect()->route('foundation.index')->with('message', 'Foundation updated successfully.');
    }
}
