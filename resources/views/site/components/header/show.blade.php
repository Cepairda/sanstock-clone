<!-- Header -->

<!-- Top -->
<div class="header-top">
    <div class="container">
        <div class="row">
            <div class="col-12">

                <div class="header-top__btn" hidden>

                    <button id="open-nav" type="button" class="open"></button>

                </div>

                <nav class="header-nav">

                    <ul class="header-nav__wrap">

                        <li class="header-nav__item">
                            <div>
                                <a href="{{ asset('/') }}">
                                    <img src="{{ asset('images/logo/logo.svg') }}" width="150" alt="Sanstok">
                                </a>
                                <button id="close-nav" type="button" class="close">
                                    <span>&times;</span>
                                </button>
                            </div>
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

                        <li class="header-nav__item item-right">
                            <div class="header-nav__item--phone">
                                <span class="icon-callback"></span>
                                <a href="tel:0800217122">0-800-21-71-22</a >
                            </div>
                        </li>
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