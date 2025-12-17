<?php

namespace App\Http\Controllers;

use App\Helpers\FileUpload;
use App\Models\Faq;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FaqController extends Controller
{
    public function index()
    {
        $header = Faq::where('section', 'heading')->first();
        $faqs = Faq::where('section', 'faq')->get();

        return Inertia::render('Faqs/Index', [
            'faqs' => $faqs,
            'header' => $header
        ]);
    }

    public function create()
    {
        return Inertia::render('Faqs/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ]);

        Faq::create([
            'section' => 'faq',
            'question' => $request->question,
            'answer' => $request->answer,
        ]);

        return redirect()->route('faqs.index')->with('message', 'FAQ created successfully.');
    }

    public function edit(Faq $faq)
    {
        return Inertia::render('Faqs/Edit', [
            'faq' => $faq
        ]);
    }

    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ]);

        $faq->update([
            'question' => $request->question,
            'answer' => $request->answer,
        ]);

        return redirect()->route('faqs.index')->with('message', 'FAQ updated successfully.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return redirect()->route('faqs.index')->with('message', 'FAQ deleted successfully.');
    }

    public function faqsEdit($id)
    {
        $faq = Faq::find($id);
        return Inertia::render('Faqs/HeaderEdit', [
            'faq' => $faq
        ]);
    }

    public function faqsUpdate(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $faq = Faq::where('section', 'heading')->first();
        // return $faq;

         if ($request->hasFile('image')) {
            $file = FileUpload::updateFile($request->file('image'), 'uploads/banners', $faq->image);
            $faq->image = $file;
        }
        
        $faq->title = $request->title;
        $faq->subtitle = $request->subtitle;
        $faq->save();

        return redirect()->route('faqs.index')->with('message', 'FAQ header updated successfully.');
    }
}
