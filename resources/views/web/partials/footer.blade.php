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
            @if($bipolarPage = bipolar_get_page_from_slug_in_list($pagesForFooter, "politicas-privacidad"))
              <li><a href="{{ route('page', $bipolarPage->slug) }}">{{ $bipolarPage->title }}</a></li>
            @endif
          </ul>
        </div>
			</div>
			<div class="col-sm-6 col-md-3">
        <div class="item-content">
          <p class="title-section">
            <span>{{ __('bipolar.footer.preferences') }}</span>
          </p>
          <ul>
            <li>{{ mb_strtoupper(__('bipolar.footer.change_currency')) }}</li>
            <li style="padding-left: 2em;"><a href="{{ route('change-currency', ['currency' => 'PEN']) }}">Soles (PEN)</a></li>
            <li style="padding-left: 2em;"><a href="{{ route('change-currency', ['currency' => 'USD']) }}">Dólares (USD)</a></li>
            <li>{{ mb_strtoupper(__('bipolar.footer.language')) }}</li>
            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
              <li>
                <a rel="alternate" hreflang="{{ $localeCode }}" style="padding-left: 2em;" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                  {{ ucfirst($properties['native']) }}
                </a>
              </li>
            @endforeach
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
            <a href="https://instagram.com/________bipolar________" target="_blank">
              <i class="fab fa-instagram"></i>
            </a>
            <a href="https://vm.tiktok.com/ZMdtdw1PH/" target="_blank">
              <i class="fab fa-tiktok"></i>
            </a>
            <a href="https://api.whatsapp.com/send?phone=51965367385&text=Hola%20Bipolar%21" target="_blank">
              <i class="fab fa-whatsapp"></i>
            </a>
          </div>
        </div>
        <img src="/images/logoperu.png" alt="Logo de Peru" style="width: 120px;">
			</div>
		</div>
	</div>
</footer>