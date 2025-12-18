<?php

namespace App\Http\Controllers;

use App\Helpers\FileUpload;
use App\Models\Service;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ServiceController extends Controller
{
    public function index()
    {
        $heading = Service::where('section', 'heading')->first();
        $services = Service::where('section', 'services')->get();

        return Inertia::render('Service/Index', [
            'heading' => $heading,
            'services' => $services,
        ]);
    }

    public function create()
    {
        return Inertia::render('Service/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string |max:500',
            'icon' => 'required|string|max:1000',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $file = FileUpload::storeFile($request->file('image'), 'uploads/services');

        $service = new Service;
        $service->section = 'services';
        $service->title = $request->title;
        $service->subtitle = $request->subtitle;
        $service->icon = $request->icon;
        $service->image = $file;
        $service->save();

        return redirect()->route('services.index')->with('message', 'Service created successfully.');
    }

    public function edit($id)
    {
        $service = Service::find($id);

        return Inertia::render('Service/Edit', [
            'service' => $service,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string |max:500',
            'icon' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $service = Service::find($id);

        if ($request->hasFile('image')) {
            $file = FileUpload::updateFile($request->file('image'), 'uploads/services', $service->image);
            $service->image = $file;
        }

        $service->title = $request->title;
        $service->subtitle = $request->subtitle;
        $service->icon = $request->icon;
        $service->save();

        return redirect()->route('services.index')->with('message', 'Service updated successfully.');
    }

    public function destroy($id)
    {
        $service = Service::find($id);
        if ($service->image) {
            FileUpload::deleteFile($service->image);
        }
        $service->delete();

        return redirect()->route('services.index')->with('message', 'Service deleted successfully.');
    }

    public function serviceEdit($id)
    {
        $service = Service::find($id);

        return Inertia::render('Service/HeaderEdit', [
            'service' => $service,
        ]);
    }

    public function serviceUpdate(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string |max:500',
        ]);

        $service = Service::find($id);
        $service->title = $request->title;
        $service->subtitle = $request->subtitle;
        $service->save();

        return redirect()->route('services.index')->with('message', 'Service updated successfully.');
    }
    
}
