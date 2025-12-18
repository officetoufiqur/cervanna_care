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
}
