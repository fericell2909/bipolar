@extends('web.layouts.app_web')
@section('content')
  <div class="background-title-image">
    <h1>{{ __('bipolar.my_account.title') }}</h1>
  </div>
  <div class="container">
    <p>
      {{ __('bipolar.my_account.hello', ['username' => \Auth::user()->name]) }} <a style="text-decoration:underline;" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('bipolar.my_account.logout') }}</a>). 
      {{ __('bipolar.my_account.from_your_account') }} <a style="text-decoration:underline;" href="{{ route('profile') }}">{{ __('bipolar.my_account.edit') }}.</a>
    </p>
    {!! Form::open(['route' => 'logout', 'style' => 'display:none', 'id' => 'logout-form']) !!}
    {!! Form::close() !!}
    <div class="table-responsive">
      <table class="table-buys">
        <thead>
          <tr>
            <th>{{ __('bipolar.my_account.order') }}</th>
            <th>{{ __('bipolar.my_account.date') }}</th>
            <th>{{ __('bipolar.my_account.state') }}</th>
            <th>Total</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach($buys as $buy)
            <tr>
              <td><a href="{{ route('confirmation', $buy->id) }}" class="order-link">#{{ $buy->id }}</a></td>
              <td>{{ $buy->created_at->format('d-m-Y') }}</td>
              <td>{{ $buy->status }}</td>
              <td><span class="price">{{ $buy->totalCurrency }}</span> por {{ $buy->details->count() }} items</td>
              <td class="order-actions">
                @if($buy->status === config('constants.BUY_INCOMPLETE_STATUS') || $buy->status === config('constants.BUY_PROCESSING_STATUS'))
                  <button class="btn btn-dark-rounded bipolar-delete-buy" data-confirmation="{{ __('bipolar.buy.delete_question') }}" data-buy-hash-id="{{ $buy->hash_id }}">
                    {{ __('bipolar.my_account.cancel') }}
                  </button>
                @endif
                <a href="{{ route('confirmation', $buy->id) }}" class="btn btn-dark-rounded">{{ __('bipolar.my_account.view') }}</a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection