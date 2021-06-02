<!-- Header -->

<!-- Top -->
<div class="header-top">
    <div class="container">
        <div class="row">
            <div class="col-12">



                <nav class="header-nav">
                    <ul class="header-nav__wrap">
                        <!-- Logo -->
                        <li class="header-nav__item">
                                <a href="{{ asset('/') }}">
                                    <img src="{{ asset('images/logo/logo.svg') }}" width="150" alt="Sanstok">
                                </a>
                        </li>
                        <!-- Close -->
                        <li class="header-nav__item item-close">
                            <span class="text-right" data-action="nav-toggle">
                                {{ __('Back') }}
                                <svg width="16" height="16" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><polyline fill="none" stroke="#8a8a8a" stroke-width="1.03" points="7 4 13 10 7 16"></polyline></svg>
                            </span>
                        </li>
                        <li class="header-nav__item">
                            <a href="{{ asset('/about-us') }}">{{ __('About us') }}</a>
                        </li>
                        <li class="header-nav__item">
                            <a href="{{ asset('/contacts') }}">{{ __('Contacts') }}</a>
                        </li>
                        <li class="header-nav__item">
                            <a href="{{ asset('/delivery') }}">{{ __('Delivery') }}</a>
                        </li>
                        <li class="header-nav__item">
                            <a class="disabled" href="#">{{ __('FAQ') }}</a>
                        </li>
                        <!-- Phone -->
                        <li class="header-nav__item item-right">
                            <div class="header-nav__item--phone">
                                <span class="icon-callback"></span>
                                <a href="tel:0800217122">0-800-21-71-22</a >
                            </div>
                        </li>
                        <!-- Localization -->
                        <li class="header-nav__item">
                            <div class="language__inner">
                                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                    @if(LaravelLocalization::getCurrentLocale() == $localeCode)
                                        <span class="language__inner--active">{{ $localeCode == 'uk' ? 'ua' : $localeCode }}</span>
                                    @else
                                        <a class="language__inner--link" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, []) }}">
                                            {{ $localeCode == 'uk' ? 'ua' : $localeCode }}
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </li>
                        <!-- Toggle -->
                        <li class="header-nav__item item-toggle">
                            <button class="item-toggle__close" data-action="nav-toggle" type="button">
                                <svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="6" y="4" width="12" height="1"></rect><rect x="6" y="9" width="12" height="1"></rect>
                                    <rect x="6" y="14" width="12" height="1"></rect><rect x="2" y="4" width="2" height="1"></rect>
                                    <rect x="2" y="9" width="2" height="1"></rect><rect x="2" y="14" width="2" height="1"></rect>
                                </svg>
                            </button>
                        </li>
                    </ul>
                </nav>

            </div>
        </div>
    </div>
</div>

<!-- Bottom -->
<header class="header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="header__inner">
                    <div class="header__menu nav-menu">
                        @include('site.components.header.menu')
                    </div>
                    <div class="header__search">
                        <form id="life-search" class="header__search--form" action="{{ route('site.products.search') }}" method="get" autocomplete="off">
                            <div class="search-container">
                                <input id="search-input"
                                       class="search-input"
                                       name="query"
                                       type="text"
                                       value="{{ isset($search_value) ? $search_value : '' }}"
                                       minlength="3"
                                       placeholder="{{ __('Search placeholder') }}"
                                       data-lang="{{ app()->getLocale() }}"
                                       required>
                                <div class="search-result"></div>
                            </div>
                            <button type="submit" class="search-submit">{{ __('Search') }}</button>
                        </form>
                    </div>
                    <div class="nav-item nav__actions header__actions">
                        <a class="header__actions--link" href="{{ asset('/cart') }}">
                            <span class="action-icon">
                                <span class="action-counter" id="cart-count" hidden>-</span>
                            </span>
                            <span class="action-name">{{ __('Cart') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- End Header -->
