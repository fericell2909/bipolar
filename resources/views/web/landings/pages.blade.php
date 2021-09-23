@extends('web.layouts.app_web')
@section('content')
  <?php /** @var \App\Models\Page $page */ ?>
{{--   @if(!is_null($page->main_image))
    <img src="{{ $page->main_image }}" style="width: 100%;" class="img-responsive" alt="{{ $page->title }}">
  @endif --}}
  <div class="bipolar-page-container">
    <div class="row">
      @if(\Request::is('info/showroom'))
        <div class="col-md-8">
          <h1>{{ $page->title }}</h1>
          {!! $page->body !!}
        </div>
        <div class="col-md-4">
          <h1>{{ __('bipolar.showroom.find_us') }}</h1>
          <div class="table-responsie">
            <table class="table">
              <tbody>
                @if($settings = \App\Models\Settings::first())
                  <tr>
                    <td><h6 class="text-uppercase" style="line-height: 2px">{{ __('bipolar.showroom.opening') }}</h6></td>
                    <td><span>{{ $settings->open_hours ?? __('bipolar.showroom.schedule') }}</span></td>
                  </tr>
                @endif
                <tr>
                  <td><h6 class="text-uppercase" style="line-height: 2px">{{ __('bipolar.showroom.location') }}</h6></td>
                  <td><span>San Isidro</span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      @else
        <div class="col-md-12">
          <h1>{{ $page->title }}</h1>
          {!! $page->body !!}
        </div>
      @endif
    </div>
  </div>
@endsection