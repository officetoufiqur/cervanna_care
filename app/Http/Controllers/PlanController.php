<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::all();
        return Inertia::render('Plan/Index', [
            'plans' => $plans,
        ]);
    }

    public function create()
    {
        return Inertia::render('Plan/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:plans,name',
            'price' => 'required',
            'description' => 'nullable',
        ]);

        Plan::create($request->all());

        return redirect()->route('plan.index')->with('message', 'Plan created successfully');
    }

    public function edit($id)
    {
        $plan = Plan::find($id);

        return Inertia::render('Plan/Edit', [
            'plan' => $plan,
        ]);
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|unique:plans,name,' . $id,
            'price' => 'required',
        ]);

        $plan = Plan::find($id);

        $plan->update($request->all());

        return redirect()->route('plan.index')->with('message', 'Plan updated successfully');
    }

    public function destroy($id)
    {
        $plan = Plan::find($id);

        $plan->delete();

        return redirect()->route('plan.index')->with('message', 'Plan deleted successfully');
    }
}
