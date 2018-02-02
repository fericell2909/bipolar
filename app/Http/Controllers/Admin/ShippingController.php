<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CountryState;
use App\Models\Country;
use App\Models\Shipping;
use App\Models\ShippingInclude;
use App\Models\ShippingExclude;
use App\Http\Requests\Admin\ShippingNewRequest;
use App\Http\Requests\Admin\ShippingEditPriceRequest;

class ShippingController extends Controller
{
    public function index()
    {
        $shippings = Shipping::orderByDesc('id')->with('includes.country', 'excludes')->get();

        return view('admin.shipping.index', compact('shippings'));
    }

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

    public function store(ShippingNewRequest $request)
    {
        $shipping = new Shipping;
        $shipping->title = $request->input('title');
        $shipping->active = false;
        $shipping->save();

        if ($request->get('all_countries') === 1) {
            $includeCountry = new ShippingInclude;
            $includeCountry->all_countries = true;
            $includeCountry->save();
        }

        if ($request->filled('include_countries')) {
            $this->saveIncludedCountries($request->input('include_countries'), $shipping);
        }

        if ($request->filled('include_states')) {
            $this->saveIncludedStates($request->input('include_states'), $shipping);
        }

        if ($request->filled('exclude_countries')) {
            $this->saveExcludedCountries($request->input('exclude_countries'), $shipping);
        }

        if ($request->filled('exclude_states')) {
            $this->saveExcludedStates($request->input('exclude_states'), $shipping);
        }

        return redirect()->route('settings.shipping.edit.price', $shipping->id);
    }

    public function edit($shippingId)
    {
        $shipping = Shipping::findOrFail($shippingId);
        $countries = Country::orderBy('name')->get();
        $countryStates = CountryState::with('country')->get();
        $shipping->load('includes.country', 'excludes.country', 'includes.country_state', 'excludes.country_state');
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

        $hasAllWorldSelected = $shipping->includes->contains(function ($shippingInclude) {
            return boolval($shippingInclude->all_countries) === true;
        });

        $includedCountriesIds = $shipping->includes
            ->filter(function ($shippingInclude) {
                return $shippingInclude->country;
            })
            ->pluck('country.id')
            ->toArray();

        $excludedCountriesIds = $shipping->excludes
            ->filter(function ($shippingExclude) {
                return $shippingExclude->country;
            })
            ->pluck('country.id')
            ->toArray();

        $includedStatesIds = $shipping->includes
            ->filter(function ($shippingInclude) {
                return $shippingInclude->country_state;
            })
            ->pluck('country_state.id')
            ->toArray();

        $excludedStatesIds = $shipping->excludes
            ->filter(function ($shippingExclude) {
                return $shippingExclude->country_state;
            })
            ->pluck('country_state.id')
            ->toArray();

        return view('admin.shipping.edit', compact(
            'shipping',
            'countryStatesSelect',
            'countries',
            'hasAllWorldSelected',
            'includedCountriesIds',
            'excludedCountriesIds',
            'includedStatesIds',
            'excludedStatesIds'
        ));
    }

    public function update(ShippingNewRequest $request, $shippingId)
    {
        $shipping = Shipping::findOrFail($shippingId);
        $shipping->title = $request->input('title');
        $shipping->save();

        if ($request->get('all_countries') === 1) {
            $hasAllWorldSelected = $shipping->includes->contains(function ($shippingInclude) {
                return boolval($shippingInclude->all_countries) === true;
            });
            if ($hasAllWorldSelected === false) {
                $includeCountry = new ShippingInclude;
                $includeCountry->all_countries = true;
                $includeCountry->save();
            }
        }

        if ($request->filled('include_countries')) {
            $this->saveIncludedCountries($request->input('include_countries'), $shipping);
        } else {
            $this->saveIncludedCountries([], $shipping);
        }

        if ($request->filled('include_states')) {
            $this->saveIncludedStates($request->input('include_states'), $shipping);
        } else {
            $this->saveIncludedStates([], $shipping);
        }

        if ($request->filled('exclude_countries')) {
            $this->saveExcludedCountries($request->input('exclude_countries'), $shipping);
        } else {
            $this->saveExcludedCountries([], $shipping);
        }

        if ($request->filled('exclude_states')) {
            $this->saveExcludedStates($request->input('exclude_states'), $shipping);
        } else {
            $this->saveExcludedStates([], $shipping);
        }

        flash()->success('Actualizado correctamente');

        return redirect()->route('settings.shipping.index');
    }

    public function editPriceShipping($shippingId)
    {
        $shipping = Shipping::findOrFail($shippingId);

        return view('admin.shipping.edit_prices', compact('shipping'));
    }

    public function updatePriceShipping(ShippingEditPriceRequest $request, $shippingId)
    {
        $shipping = Shipping::findOrFail($shippingId);
        $shipping->g200 = $request->input('g200');
        $shipping->g500 = $request->input('g500');
        $shipping->kg1 = $request->input('kg1');
        $shipping->kg2 = $request->input('kg2');
        $shipping->kg3 = $request->input('kg3');
        $shipping->kg4 = $request->input('kg4');
        $shipping->kg5 = $request->input('kg5');
        $shipping->kg6 = $request->input('kg6');
        $shipping->kg7 = $request->input('kg7');
        $shipping->kg8 = $request->input('kg8');
        $shipping->kg9 = $request->input('kg9');
        $shipping->kg10 = $request->input('kg10');
        $shipping->save();

        return redirect()->route('settings.shipping.index');
    }

    public function activate($shippingId, $activate)
    {
        $shipping = Shipping::findOrFail($shippingId);
        $shipping->active = boolval($activate);
        $shipping->save();

        flash()->success('Se cambió el estado con éxito');

        return redirect()->back();
    }

    private function saveIncludedCountries(array $countriesIds, Shipping $shipping)
    {
        $shipping->included_countries()->sync($countriesIds);
    }

    private function saveIncludedStates(array $statesIds, Shipping $shipping)
    {
        $shipping->included_states()->sync($statesIds);
    }

    private function saveExcludedCountries(array $countriesIds, Shipping $shipping)
    {
        $shipping->excluded_countries()->sync($countriesIds);
    }

    private function saveExcludedStates(array $statesIds, Shipping $shipping)
    {
        $shipping->excluded_states()->sync($statesIds);
    }
}
