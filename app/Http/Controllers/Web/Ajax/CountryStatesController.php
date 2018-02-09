<?php

namespace App\Http\Controllers\Web\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CountryState;
use App\Models\Country;

class CountryStatesController extends Controller
{
    public function get($countryId)
    {
        $country = Country::findOrFail($countryId);

        $countryStates = CountryState::whereCountryId($country->id)->get();

        $countryStates = $countryStates->transform(function ($countryState) {
            return [
                'id'   => $countryState->id,
                'text' => mb_strtoupper($countryState->name),
            ];
        })->toArray();

        return response()->json($countryStates);
    }
}
