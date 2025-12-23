<?php

namespace App\Http\Controllers;

use App\Helpers\FileUpload;
use App\Models\Event;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('items')->get();

        return Inertia::render('Event/Index', [
            'events' => $events,
        ]);
    }

    public function create()
    {
        return Inertia::render('Event/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'items' => 'nullable|array|min:1',
            'items.*.name' => 'nullable|string|max:255',
        ]);

        $file = FileUpload::storeFile($request->file('image'), 'uploads/events');

        $event = Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $file,
        ]);

        if ($request->has('items')) {
            foreach ($request->items as $item) {
                $event->items()->create([
                    'name' => $item['name'] ?? null,
                ]);
            }
        }

        return redirect()->route('events.index')->with('message', 'Event created successfully.');
    }

    public function edit($id)
    {
        $event = Event::with('items')->findOrFail($id);
        return Inertia::render('Event/Edit', [
            'event' => $event,
        ]);
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'items' => 'nullable|array|min:1',
            'items.*.name' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file = FileUpload::updateFile($request->file('image'), $event->image, 'uploads/events');
            $event->image = $file;
        }

        $event->title = $request->title;
        $event->description = $request->description;
        $event->save();

        if ($request->has('items')) {
            $event->items()->delete();
            foreach ($request->items as $item) {
                $event->items()->create([
                    'name' => $item['name'] ?? null,
                ]);
            }
        }

        return redirect()->route('events.index')->with('message', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        if ($event->image) {
            FileUpload::deleteFile($event->image);
        }
        $event->delete();

        return redirect()->route('events.index')->with('message', 'Event deleted successfully.');
    }
}
