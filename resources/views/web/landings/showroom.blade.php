@extends('web.layouts.app_web')
@section('content')
    <img src="{{ asset('storage/bipolar-images/assets/bipolar-showroom.jpg') }}" class="img-responsive" alt="Bipolar">
    <div class="bipolar-container">
        <div class="row">
            <div class="col-md-8">
                <p class="title-text-content">Showroom</p>
                <p>{!! __('bipolar.showroom.about') !!}</p>
            </div>
            <div class="col-md-4">
                <p class="title-text-content">{{ __('bipolar.showroom.find_us') }}</p>
                <div class="table-responsie">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td><strong>{{ __('bipolar.showroom.opening') }}</strong></td>
                                <td>{{ __('bipolar.showroom.schedule') }}</td>
                            </tr>
                            <tr>
                                <td><strong>{{ __('bipolar.showroom.location') }}</strong></td>
                                <td>San Isidro</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection