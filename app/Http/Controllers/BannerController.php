<?php

namespace App\Http\Controllers;

use App\Helpers\FileUpload;
use App\Models\Banner;
use App\Models\NewsLetter;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BannerController extends Controller
{
    public function index()
    {
        $banner = Banner::get();

        return Inertia::render('Banner/Index', compact('banner'));
    }

    public function create()
    {
        return Inertia::render('Banner/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'sub_title' => 'required|string|max:255',
            'btn_text' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $file = FileUpload::storeFile($request->file('image'), 'uploads/banners');

        Banner::create([
            'title' => $request->title,
            'sub_title' => $request->sub_title,
            'btn_text' => $request->btn_text,
            'image' => $file,
        ]);

        return redirect()->route('banners.index')->with('message', 'Banner created successfully.');
    }

    public function edit($id)
    {
        $banner = Banner::find($id);

        return Inertia::render('Banner/Edit', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'sub_title' => 'required|string|max:255',
            'btn_text' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $banner = Banner::find($id);

        if ($request->hasFile('image')) {
            $file = FileUpload::updateFile($request->file('image'), 'uploads/banners', $banner->image);
            $banner->image = $file;
        }

        $banner->title = $request->title;
        $banner->sub_title = $request->sub_title;
        $banner->btn_text = $request->btn_text;
        $banner->save();

        return redirect()->route('banners.index')->with('message', 'Banner updated successfully.');
    }

    public function delete($id)
    {
        $banner = Banner::find($id);

        if ($banner->image) {
            FileUpload::deleteFile($banner->image);
        }
        $banner->delete();

        return redirect()->route('banners.index');
    }

       public function newsLetters()
    {
        $newsLetters = NewsLetter::first();

        return Inertia::render('Banner/NewsLetters', compact('newsLetters'));
    }


    public function newsLettersEdit($id)
    {
        $newsLetters = NewsLetter::find($id);
        return Inertia::render('Banner/EditNewsLetter', compact('newsLetters'));
    }

    public function newsLettersUpdate(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'sub_title' => 'required|string|max:255',
        ]);

        $newsLetters = NewsLetter::find($id);
        $newsLetters->title = $request->title;
        $newsLetters->sub_title = $request->sub_title;
        $newsLetters->save();

        return redirect()->route('news-letters')->with('message', 'News Letter updated successfully.');
    }
}
