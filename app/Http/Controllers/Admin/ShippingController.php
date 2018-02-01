<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CountryState;
use App\Models\Country;

class ShippingController extends Controller
{
    public function create()
    {
        $countries = Country::orderBy('name')->get();
        $countryStates = CountryState::with('country')->get();
        $countryStatesSelect = [];

        $countryStates->sortBy(function ($countryState) {
            return "{$countryState->country->name} - {$countryState->name}";
        })
        ->each(function ($countryState) use (&$countryStatesSelect) {
            $countryStatesSelect[$countryState->id] = "{$countryState->country->name} - {$countryState->name}";
        });

        $countries = $countries->mapWithKeys(function ($country) {
            return [$country->id => $country->name];
        });

        return view('admin.shipping.new', compact('countryStatesSelect', 'countries'));
    }

    public function store(Request $request)
    {
        dd($request->all());
    }
}
