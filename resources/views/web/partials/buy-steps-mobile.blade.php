<section class="container">
  <section class="bipolar-steps-mobile">
    <h4 class="bipolar-steps-mobile__title">{{ __('bipolar.buy.status') }}</h4>
    @if($buyStatus = array_get($buyStatuses, config('constants.BUY_PROCESSING_STATUS')))
      <h4 class="bipolar-steps-mobile__subtitle">
        <i class="fas fa-check"></i>
        {{ __('bipolar.buy.statuses.processing') }}
      </h4>
      <h4 class="bipolar-steps-mobile__subtitle">{{ $buyStatus->created_at->format('d/m/Y') }}</h4>
    @else
      <h4 class="bipolar-steps-mobile__subtitle bipolar-steps__one__title--disabled">{{ __('bipolar.buy.statuses.processing') }}</h4>
      <h4 class="bipolar-steps-mobile__subtitle bipolar-steps__one__title--disabled">--/--/--</h4>
    @endif
    @if($buy->showroom)
      @if($buyStatus = array_get($buyStatuses, config('constants.BUY_PICKUP_STATUS')))
        <h4 class="bipolar-steps-mobile__subtitle">{{ __('bipolar.buy.statuses.pickup') }}</h4>
        <h4 class="bipolar-steps-mobile__subtitle">{{ $buyStatus->created_at->format('d/m/Y') }}</h4>
      @else
        <h4 class="bipolar-steps-mobile__subtitle bipolar-steps__one__title--disabled">{{ __('bipolar.buy.statuses.pickup') }}</h4>
        <h4 class="bipolar-steps-mobile__subtitle bipolar-steps__one__date--disabled">--/--/--</h4>
      @endif
    @else
      @if($buyStatus = array_get($buyStatuses, config('constants.BUY_SENT_STATUS')))
        <h4 class="bipolar-steps-mobile__subtitle">{{ __('bipolar.buy.statuses.sent') }}</h4>
        <h4 class="bipolar-steps-mobile__subtitle">{{ $buyStatus->created_at->format('d/m/Y') }}</h4>
      @else
        <h4 class="bipolar-steps-mobile__subtitle bipolar-steps__one__title--disabled">{{ __('bipolar.buy.statuses.sent') }}</h4>
        <h4 class="bipolar-steps-mobile__subtitle bipolar-steps__one__date--disabled">--/--/--</h4>
      @endif
      @if($buyStatus = array_get($buyStatuses, config('constants.BUY_TRANSIT_STATUS')))
        <h4 class="bipolar-steps-mobile__subtitle">{{ __('bipolar.buy.statuses.transit') }}</h4>
        <h4 class="bipolar-steps-mobile__subtitle">{{ $buyStatus->created_at->format('d/m/Y') }}</h4>
      @else
        <h4 class="bipolar-steps-mobile__subtitle bipolar-steps__one__title--disabled">{{ __('bipolar.buy.statuses.transit') }}</h4>
        <h4 class="bipolar-steps-mobile__subtitle bipolar-steps__one__date--disabled">--/--/--</h4>
      @endif
    @endif
    @if($buyStatus = array_get($buyStatuses, config('constants.BUY_CULMINATED_STATUS')))
      <h4 class="bipolar-steps-mobile__subtitle">{{ __('bipolar.buy.statuses.culminated') }}</h4>
      <h4 class="bipolar-steps-mobile__subtitle">{{ $buyStatus->created_at->format('d/m/Y') }}</h4>
    @else
      <h4 class="bipolar-steps-mobile__subtitle bipolar-steps__one__title--disabled">{{ __('bipolar.buy.statuses.culminated') }}</h4>
      <h4 class="bipolar-steps-mobile__subtitle bipolar-steps__one__date--disabled">--/--/--</h4>
    @endif
  </section>
</section>
