<div class="content-newsletter" style="background-image: url({{ $showBackground ? $imageBackground->background_suscribe : '' }});">
  <div class="container-content">
    <div class="text-center">
      <i class="fas fa-2x fa-envelope"></i>
    </div>
    <div class="newsletter-title">{{ __('bipolar.home.suscribe') }}</div>
    <div class="newsletter-subtitle">{{ __('bipolar.home.suscribe_details') }}</div>
    {!! Form::open(['route' => 'register.newsletter', 'id' => 'form-suscribe' ,  'class' => 'form-suscribe']) !!}
    @csrf
    <div class="form-group">
      {!! Form::text('name', null, [ 'id' => 'name' , 'class' => 'form-control', 'placeholder' => __('bipolar.home.name'), 'required' => true]) !!}
    </div>
    <div class="form-group">
      {!! Form::email('email', null, [ 'id' => 'email' ,'class' => 'form-control', 'placeholder' => __('bipolar.home.email'), 'required' => true]) !!}
    </div>
    {{-- <button id="newsletter-submit-button" class="btn btn-dark btn-rounded">{{ __('bipolar.home.send') }}</button> --}}
    <input type="hidden" name="recaptcha" id="recaptcha">
    <button class="btn btn-dark-rounded"  onclick="onClickNewsLetterForm(event)">Enviar</button>
    {!! Form::close() !!}
  </div>
</div>