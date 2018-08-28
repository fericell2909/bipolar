@extends('web.layouts.app_web')
@section('content')
  <?php /** @var \Illuminate\Support\Collection $historics */ ?>
  @foreach($historics->chunk(2) as $chunk)
    <div class="row no-gutters bipolar-historic">
        @foreach($chunk as $historic)
          @if($inverse)
            @include("web.partials.historic-photo", ['name' => $historic->name, 'photo' => $historic->photo, 'inverse' => true])
            @include("web.partials.historic-name", ['name' => $historic->name, 'photo' => $historic->photo, 'inverse' => true])
          @else
            @include("web.partials.historic-name", ['name' => $historic->name, 'photo' => $historic->photo, 'inverse' => false])
            @include("web.partials.historic-photo", ['name' => $historic->name, 'photo' => $historic->photo, 'inverse' => false])
          @endif
        @endforeach
    </div>
    @php($inverse = !$inverse)
  @endforeach
@endsection
{{-- Don't move. This is here for prevent z-index issue --}}
@push('js_plus')
<div class="modal fade" id="showHistoricModal" tabindex="-1" role="dialog" aria-labelledby="showHistoricModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <img src="https://placehold.it/794x527" alt="Bipolar" class="image-historic-preview w-100">
      </div>
    </div>
  </div>
</div>
@endpush