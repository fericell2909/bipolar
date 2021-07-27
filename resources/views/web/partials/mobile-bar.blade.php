<?php /** @var \App\Instances\CartBipolar $bipolarCart */ ?>
<section class="header-mobile d-block d-sm-block d-md-none" 
  style="padding-left: 0; padding-right: 0; 
    background: url('https://bipolar.nyc3.digitaloceanspaces.com/images/logomobilebg.png'); background-position: center;
    background-size: 100%;
    height: 140px;">
    <div style="display: none;justify-content: center;align-content: space-between;">
   {{--  <div class="col-md-offset-4 col-md-4"> --}}
    <div style="background: none; width: 100%;height: 2px; border-top: 3px solid #fcbeb9; margin-top: 28px"></div>
        <a href="{{ route('home') }}">
          <img src="https://bipolar.nyc3.digitaloceanspaces.com/images/LogoLetrasrosadas.svg" 
            width="286"
            style="margin-top: 6px;
            margin-left: -5px;
            margin-right: -15px;">
        </a>
      <div style="background: none; width: 100%;height: 2px; border-top: 3px solid #fcbeb9; margin-top: 28px"></div>
    </div>
</section>
<section class="header-mobile-menu d-block d-sm-block d-md-none">
  <div class="menu-button">
    <button type="button" class="navbar-toggle bipolar-navbar-toggle collapsed" data-toggle="collapse" data-target="#responsive-menu-black" aria-expanded="false" aria-controls="navbar">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar top-bar" style="background: #000;"></span>
      <span class="icon-bar middle-bar" style="background: #000;"></span>
      <span class="icon-bar bottom-bar" style="background: #000;"></span>
    </button>
    <span class="menu-text-header-mobile">MENU</span>
  </div>
  <div class="cart-white-mobile bipolar-shopping-cart-content">
    <img src="https://bipolar.nyc3.digitaloceanspaces.com/images/cartnegro.svg" width="35"  style="cursor: pointer;" onclick="$('.cart-inside-mobile').toggle();">
    <span class="cart-number-count-inverse" style="color: #fcbeb9;
    background-color: #000;">{{ isset($bipolarCart) ? $bipolarCart->count() : 0 }}</span>
    <div class="cart-inside-mobile">
      @if(isset($bipolarCart) ? $bipolarCart->count() > 0 : false)
        <ul class="cart-list">
          @foreach($bipolarCart->content() as $cartDetail)
          <li>
            <a href="{{ route('shop.product', $cartDetail->product->slug) }}" class="product-link-cart">
              <img src="{{ optional($cartDetail->product->mainPhoto())->url ?? 'https://placehold.it/300x300' }}" alt="{{ $cartDetail->product->name }}">
              {{ $cartDetail->product->name }}
            </a>
            <span class="quantity">{{ $cartDetail->quantity }} x {{ $cartDetail->total_currency }}</span>
            <a href="{{ route('cart.remove', $cartDetail->hash_id) }}" class="product-delete-cart"><img src="{{ asset('images/close.svg') }}" width="20" alt="Delete"></a>
          </li>
          @endforeach
        </ul>
        <div class="total">
          <strong>Total:</strong>
          <span class="amount">{{ $bipolarCart->totalCurrency() }}</span>
        </div>
        <div class="buttons">
          <a href="{{ route('cart') }}" class="btn btn-dark btn-rounded">{{ __('bipolar.navbar.see_cart') }}</a>
          <a href="{{ route('checkout') }}" class="btn btn-dark btn-rounded">Checkout</a>
        </div>
      @else
        <div class="empty-cart">
          <h4 class="text-center text-uppercase">{{ __('bipolar.navbar.empty_cart') }}</h4>
          <p class="text-center">{{ __('bipolar.navbar.empty_cart_detail') }}</p>
        </div>
      @endif
    </div>
  </div>
</section>
<ul id="responsive-menu-black" class="responsive-menu-black collapse">
  <li><a href="{{ route('home') }}"><span>Home</span></a></li>
  @if($bipolarPage = bipolar_get_page_from_slug_in_list($pagesForFooter, "bipolar"))
    <li><a href="{{ route('page', $bipolarPage->slug) }}"><span>{{ $bipolarPage->title }}</span></a></li>
  @endif
  @if($bipolarPage = bipolar_get_page_from_slug_in_list($pagesForFooter, "showroom"))
    <li><a href="{{ route('page', $bipolarPage->slug) }}"><span>{{ $bipolarPage->title }}</span></a></li>
  @endif
  <li><a href="{{ route('shop') }}"><span>Shop</span></a></li>
  <li><a href="{{ route('landings.newsletter') }}"><span>Newsletter</span></a></li>
  <li><a href="{{ route('landings.blog') }}"><span>Blog</span></a></li>
  <li><a href="{{ route('landings.contacto') }}"><span>{{ __('bipolar.navbar.contact_us') }}</span></a></li>
  <li>
    <a href="{{ route('myaccount') }}"><span class="text-gothan-light">{{ __('bipolar.navbar.my_account') }}</span></a>
    <a href="{{ route('wishlist') }}"><i class="fas fa-heart"></i> <span class="text-uppercase text-gothan-light">Wishlist</span></a>
  </li>
</ul>
