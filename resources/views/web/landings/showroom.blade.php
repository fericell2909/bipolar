@extends('web.layouts.app_web')
@section('content')
    <img src="{{ asset('storage/bipolar-images/assets/bipolar-showroom.jpg') }}" class="img-responsive" alt="Bipolar">
    <div class="bipolar-page-container">
        <div class="row">
            <div class="col-md-8">
                <h1>Showroom</h1>
                <p>{!! __('bipolar.showroom.about') !!}</p>
            </div>
            <div class="col-md-4">
                <h1>{{ __('bipolar.showroom.find_us') }}</h1>
                <div class="table-responsie">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td><h6 class="text-uppercase">{{ __('bipolar.showroom.opening') }}</h6></td>
                                <td>{{ __('bipolar.showroom.schedule') }}</td>
                            </tr>
                            <tr>
                                <td><h6 class="text-uppercase">{{ __('bipolar.showroom.location') }}</h6></td>
                                <td>San Isidro</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection