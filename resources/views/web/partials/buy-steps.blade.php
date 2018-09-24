<section class="container">
  <section class="bipolar-steps">
    @if($buyStatus = array_get($buyStatuses, config('constants.BUY_PROCESSING_STATUS')))
      <article class="bipolar-steps__one">
        <header class="bipolar-steps__one__line">
          <img src="{{ asset('images/circle-on-soft-line.svg') }}" alt="">
        </header>
        <footer class="bipolar-steps__one__title">{{ __('bipolar.buy.statuses.processing') }}</footer>
        <footer class="bipolar-steps__one__date">{{ $buyStatus->created_at->format('d/m/Y') }}</footer>
      </article>
    @else
      <article class="bipolar-steps__one">
        <header class="bipolar-steps__one__line">
          <img src="{{ asset('images/circle-off-soft-line.svg') }}" alt="">
        </header>
        <footer class="bipolar-steps__one__title bipolar-steps__one__title--disabled">{{ __('bipolar.buy.statuses.processing') }}</footer>
        <footer class="bipolar-steps__one__date bipolar-steps__one__date--disabled">--/--/--</footer>
      </article>
    @endif
    @if($buy->showroom)
      @if($buyStatus = array_get($buyStatuses, config('constants.BUY_PICKUP_STATUS')))
        <article class="bipolar-steps__one">
          <header class="bipolar-steps__one__line">
            <img src="{{ !is_null(array_get($buyStatuses, config('constants.BUY_CULMINATED_STATUS'))) ? asset('images/circle-on-hard-line.svg') : asset('images/circle-on-soft-line.svg') }}" alt="">
          </header>
          <footer class="bipolar-steps__one__title">{{ __('bipolar.buy.statuses.pickup') }}</footer>
          <footer class="bipolar-steps__one__date">{{ $buyStatus->created_at->format('d/m/Y') }}</footer>
        </article>
      @else
        <article class="bipolar-steps__one">
          <header class="bipolar-steps__one__line">
            <img src="{{ asset('images/circle-off-soft-line.svg') }}" alt="">
          </header>
          <footer class="bipolar-steps__one__title bipolar-steps__one__title--disabled">{{ __('bipolar.buy.statuses.pickup') }}</footer>
          <footer class="bipolar-steps__one__date bipolar-steps__one__date--disabled">--/--/--</footer>
        </article>
      @endif
    @else
      @if($buyStatus = array_get($buyStatuses, config('constants.BUY_SENT_STATUS')))
        <article class="bipolar-steps__one">
          <header class="bipolar-steps__one__line">
            <img src="{{ !is_null(array_get($buyStatuses, config('constants.BUY_TRANSIT_STATUS'))) ? asset('images/circle-on-hard-line.svg') : asset('images/circle-on-soft-line.svg') }}" alt="">
          </header>
          <footer class="bipolar-steps__one__title">{{ __('bipolar.buy.statuses.sent') }}</footer>
          <footer class="bipolar-steps__one__date">{{ $buyStatus->created_at->format('d/m/Y') }}</footer>
        </article>
      @else
        <article class="bipolar-steps__one">
          <header class="bipolar-steps__one__line">
            <img src="{{ asset('images/circle-off-soft-line.svg') }}" alt="">
          </header>
          <footer class="bipolar-steps__one__title bipolar-steps__one__title--disabled">{{ __('bipolar.buy.statuses.sent') }}</footer>
          <footer class="bipolar-steps__one__date bipolar-steps__one__date--disabled">--/--/--</footer>
        </article>
      @endif
      @if($buyStatus = array_get($buyStatuses, config('constants.BUY_TRANSIT_STATUS')))
        <article class="bipolar-steps__one">
          <header class="bipolar-steps__one__line">
            <img src="{{ !is_null(array_get($buyStatuses, config('constants.BUY_CULMINATED_STATUS'))) ? asset('images/circle-on-hard-line.svg') : asset('images/circle-on-soft-line.svg') }}" alt="">
          </header>
          <footer class="bipolar-steps__one__title">{{ __('bipolar.buy.statuses.transit') }}</footer>
          <footer class="bipolar-steps__one__date">{{ $buyStatus->created_at->format('d/m/Y') }}</footer>
        </article>
      @else
        <article class="bipolar-steps__one">
          <header class="bipolar-steps__one__line">
            <img src="{{ asset('images/circle-off-soft-line.svg') }}" alt="">
          </header>
          <footer class="bipolar-steps__one__title bipolar-steps__one__title--disabled">{{ __('bipolar.buy.statuses.transit') }}</footer>
          <footer class="bipolar-steps__one__date bipolar-steps__one__date--disabled">--/--/--</footer>
        </article>
      @endif
    @endif
    @if($buyStatus = array_get($buyStatuses, config('constants.BUY_CULMINATED_STATUS')))
      <article class="bipolar-steps__one">
        <header class="bipolar-steps__one__line">
          <img src="{{ asset('images/circle-on.svg') }}" alt="">
        </header>
        <footer class="bipolar-steps__one__title">{{ __('bipolar.buy.statuses.culminated') }}</footer>
        <footer class="bipolar-steps__one__date">{{ $buyStatus->created_at->format('d/m/Y') }}</footer>
      </article>
    @else
      <article class="bipolar-steps__one">
        <header class="bipolar-steps__one__line">
          <img src="{{ asset('images/circle-off.svg') }}" alt="">
        </header>
        <footer class="bipolar-steps__one__title bipolar-steps__one__title--disabled">{{ __('bipolar.buy.statuses.culminated') }}</footer>
        <footer class="bipolar-steps__one__date bipolar-steps__one__date--disabled">--/--/--</footer>
      </article>
    @endif
  </section>
</section>