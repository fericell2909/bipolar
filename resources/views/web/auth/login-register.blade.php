@extends('web.layouts.app_web')
@section('content')
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col-md-6">
                @includeWhen($loginRegister === 'login', 'web.auth.login-form')
                @includeWhen($loginRegister === 'register', 'web.auth.register-form')
            </div>
            <div class="col-md-6">
                @includeWhen($loginRegister === 'login', 'web.auth.register-form')
                @includeWhen($loginRegister === 'register', 'web.auth.login-form')
            </div>
        </div>
    </div>
    @push('script_plus')
        @include('web.partials.facebook')
    @endpush
@endsection
