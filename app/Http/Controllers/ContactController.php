<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function index() {
        $heading = ContactUs::where('section', 'contact')->first();
        $contact = ContactUs::where('section', 'card')->get();

        return Inertia::render('Contact/Index', [
            'heading' => $heading,
            'contacts' => $contact
        ]);
    }

    public function create() {
        return Inertia::render('Contact/Create');
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string',
            'icon' => 'required|string',
        ]);

        ContactUs::create([
            'section' => 'card',
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'icon' => $request->icon,
        ]);

        return redirect()->route('contacts.index')->with('message', 'Contact created successfully');
    }

    public function edit($id) {
        $contact = ContactUs::where('section', 'card')->find($id);

        return Inertia::render('Contact/Edit', [
            'contact' => $contact
        ]);
    }

    public function update(Request $request, $id) {
        $contact = ContactUs::where('section', 'card')->find($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string',
            'icon' => 'required|string',
        ]);

        $contact->title = $request->title;
        $contact->subtitle = $request->subtitle;
        $contact->icon = $request->icon;
        $contact->save();

        return redirect()->route('contacts.index')->with('message', 'Contact updated successfully');
    }

    public function destroy($id) {
        $contact = ContactUs::where('section', 'card')->find($id);
        $contact->delete();

        return redirect()->route('contacts.index')->with('message', 'Contact deleted successfully');
    }

    public function contactEdit($id) {
        $contact = ContactUs::where('section', 'contact')->find($id);

        return Inertia::render('Contact/HeaderEdit', [
            'contact' => $contact
        ]);
    }

    public function contactUpdate(Request $request, $id)
    {
        $contact = ContactUs::where('section', 'contact')->find($id);

        $request->validate([
            'heading' => 'required|string|max:255',
            'sub_heading' => 'required|string',
            'map' => 'required|string',
        ]);

        $contact->heading = $request->heading;
        $contact->sub_heading = $request->sub_heading;
        $contact->map = $request->map;
        $contact->save();

        return redirect()->route('contacts.index')->with('message', 'Contact updated successfully');
    }
}
