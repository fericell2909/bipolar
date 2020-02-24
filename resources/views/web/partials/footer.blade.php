<?php /** @var \Illuminate\Support\Collection $pagesForFooter */ ?>
<footer class="bipolar-footer">
	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-md-3">
				<div class="item-content">
					<p class="title-section">
						<span>{{ __('bipolar.footer.location') }}</span>
					</p>
					<ul>
						<li>{{ mb_strtoupper('Av. Santa Cruz 496') }} <br> {{ mb_strtoupper('San Isidro, Lima - Perú') }}</li>
						<li>(+51) 965.367.385</li>
						<li>EMAIL: BIPOLAR@BIPOLAR.COM.PE</li>
					</ul>
				</div>
			</div>
			<div class="col-sm-6 col-md-3">
        <div class="item-content">
          <p class="title-section">
            <span>Info</span>
          </p>
          <ul>
            @if($bipolarPage = bipolar_get_page_from_slug_in_list($pagesForFooter, "shipping"))
              <li><a href="{{ route('page', $bipolarPage->slug) }}">{{ $bipolarPage->title }}</a></li>
            @endif
            @if($bipolarPage = bipolar_get_page_from_slug_in_list($pagesForFooter, "exchange-and-return"))
              <li><a href="{{ route('page', $bipolarPage->slug) }}">{{ $bipolarPage->title }}</a></li>
            @endif
            @if($bipolarPage = bipolar_get_page_from_slug_in_list($pagesForFooter, "care-tips"))
              <li><a href="{{ route('page', $bipolarPage->slug) }}">{{ $bipolarPage->title }}</a></li>
            @endif
          </ul>
        </div>
			</div>
			<div class="col-sm-6 col-md-3">
        <div class="item-content">
          <p class="title-section">
            <span>{{ __('bipolar.footer.company') }}</span>
          </p>
          <ul>
            <li>
              <a href="{{ route('home') }}">Home</a>
            </li>
            @if($bipolarPage = bipolar_get_page_from_slug_in_list($pagesForFooter, "bipolar"))
              <li><a href="{{ route('page', $bipolarPage->slug) }}">{{ $bipolarPage->title }}</a></li>
            @endif
            @if($bipolarPage = bipolar_get_page_from_slug_in_list($pagesForFooter, "showroom"))
              <li><a href="{{ route('page', $bipolarPage->slug) }}">{{ $bipolarPage->title }}</a></li>
            @endif
            <li>
              <a href="{{ route('shop') }}">Shop</a>
            </li>
            <li>
              <a href="{{ route('landings.newsletter') }}">Newsletter</a>
            </li>
            <li>
              <a href="{{ route('landings.blog') }}">Blog</a>
            </li>
            <li>
              <a href="{{ route('landings.contacto') }}">{{ __('bipolar.contact.contact_us') }}</a>
            </li>
          </ul>
        </div>
			</div>
			<div class="col-sm-6 col-md-3">
        <div class="item-content">
          <p class="title-section">
            <span>{{ __('bipolar.footer.contact') }}</span>
          </p>
          <div class="footer-icons">
            <a href="mailto:bipolar@bipolar.com.pe">
              <i class="fas fa-envelope"></i>
            </a>
            <a href="https://www.facebook.com/bipolar.zapatos" target="_blank">
              <i class="fab fa-facebook"></i>
            </a>
            <a href="https://instagram.com/bipolar_zapatos" target="_blank">
              <i class="fab fa-instagram"></i>
            </a>
          </div>
        </div>
			</div>
		</div>
	</div>
</footer>