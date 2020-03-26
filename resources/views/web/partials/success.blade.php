<div class="container">
  <div class="bipolar-success-message">
    <i class="fas fa-fw fa-check-circle"></i>
    <div class="success-content">
    <span>{{ __('bipolar.shop.added', ['product' => $product]) }}</span>
    <a href="{{ route('cart') }}" class="btn btn-dark-rounded">{{ __('bipolar.navbar.see_cart') }}</a>
    </div>
  </div>
</div>
