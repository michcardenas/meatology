<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\City;

class LocationController extends Controller
{
    // Países
    public function countriesIndex()
    {
        $countries = Country::withCount('cities')->get();
        return view('admin.countries.index', compact('countries'));
    }

    public function countriesStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'shipping' => 'nullable|numeric|min:0|max:999999.99'
        ]);

        $country = Country::create($request->only('name', 'shipping'));

        return back()->with('success', 'State created successfully.');
    }

    public function countriesDestroy($id)
    {
        Country::findOrFail($id)->delete();
        return back()->with('success', 'Country deleted.');
    }

    // Ciudades
    public function citiesIndex()
    {
        $cities = City::with('country')->get();
        $countries = Country::all();
        return view('admin.cities.index', compact('cities', 'countries'));
    }

    public function citiesStore(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'country_id' => 'required|exists:countries,id',
        'tax' => 'nullable|numeric|min:0|max:999.99',
    ]);

    City::create($request->only('name', 'country_id', 'tax'));
    return back()->with('success', 'City created successfully.');
}

    public function citiesDestroy($id)
    {
        City::findOrFail($id)->delete();
        return back()->with('success', 'City deleted.');
    }

    public function citiesEdit(City $city)
{
    $countries = Country::all();
    return view('admin.cities.edit', compact('city', 'countries'));
}

public function citiesUpdate(Request $request, City $city)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'country_id' => 'required|exists:countries,id',
        'tax' => 'nullable|numeric|min:0|max:999.99',
    ]);

    $city->update($request->only('name', 'country_id', 'tax'));
    return redirect()->route('admin.cities.index')->with('success', 'City updated successfully.');
}
}
