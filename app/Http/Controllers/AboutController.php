<?php

namespace App\Http\Controllers;

use App\Helpers\FileUpload;
use App\Models\About;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AboutController extends Controller
{
    public function index()
    {
        $about = About::with('items')->first();

        return Inertia::render('About/Index', compact('about'));
    }

    public function edit($id)
    {
        $about = About::with('items')->find($id);

        return Inertia::render('About/Edit', compact('about'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'items' => 'required|array',
            'items.*.tag' => 'required|string|max:255',
            'items.*.tag_icon' => 'required|string',
        ]);

        $about = About::findOrFail($id);

        if($request->hasFile('image')) {
            $file = FileUpload::updateFile($request->file('image'), 'uploads/abouts', $about->image);
            $about->image = $file;
        }

        $about->title = $request->title;
        $about->description = $request->description;
        $about->save();

        $about->items()->delete();

        foreach($request->items as $item) {
            $about->items()->create([
                'tag' => $item['tag'],
                'tag_icon' => $item['tag_icon'],
            ]);
        }

        return redirect()->route('about.index')->with('success', 'About updated successfully.');
    
    }
}
