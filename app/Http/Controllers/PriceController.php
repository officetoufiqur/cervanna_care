<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Price;
use Inertia\Inertia;

class PriceController extends Controller
{
    public function index()
    {
        $prices = Price::all();
        return Inertia::render('Price/Index', [
            'prices' => $prices,
        ]);
    }

    public function create()
    {
        return Inertia::render('Price/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
        ]);

        Price::create($request->all());

        return redirect()->route('price.index')->with('message', 'Price created successfully');
    }

    public function edit($id)
    {
        $price = Price::find($id);

        return Inertia::render('Price/Edit', [
            'price' => $price,
        ]);
    }

    public function update(Request $request, $id)
    {
        $price = Price::find($id);

        $price->update($request->all());

        return redirect()->route('price.index')->with('message', 'Price updated successfully');
    }

    public function destroy($id)
    {
        $price = Price::find($id);

        $price->delete();

        return redirect()->route('price.index')->with('message', 'Price deleted successfully');
    }
}
