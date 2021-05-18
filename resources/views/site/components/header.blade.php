<!-- Header -->

<!-- Top -->
<div class="header-top">
    <div class="container">
        <div class="row">
            <div class="col-12">

                <nav class="header-nav">

                    <ul class="header-nav__wrap">

                        <li class="header-nav__item">
                            <a href="{{ asset('/') }}">
                                <img src="{{ asset('images/logo/logo.svg') }}" width="150" alt="Sanstok">
                            </a>
                        </li>

                        <li class="header-nav__item">
                            <a class="disabled" href="#">{{ __('About us') }}</a>
                        </li>

                        <li class="header-nav__item">
                            <a href="{{ asset('/contacts') }}">Контакты</a>
                        </li>

                        <li class="header-nav__item">
                            <a class="disabled" href="#">{{ __('Delivery') }}</a>
                        </li>

                        <li class="header-nav__item">
                            <a class="disabled" href="#">{{ __('FAQ') }}</a>
                        </li>



                        <li class="header-nav__item ml-auto">
                            <div class="header-nav__item--phone">
                                <span class="icon-callback"></span>
                                <a href="tel:0800212124">0-800-21-21-24</a >
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
                        @include('site.components.headerMenu')
                    </div>
                    <div class="header__search">
                        <form class="header__search--form header-menu__form" id="life-search" action="{{ route('site.products.search') }}" method="get" autocomplete="off">
                            <input type="text" id="input-search" class="input-search" name="search_value"
                                   value="{{ isset($search_value) ? $search_value : '' }}" minlength="3"
                                   placeholder="{{ __('Search placeholder') }}"
                                   data-lang="{{ app()->getLocale() }}"
                                   required>
                            <button type="submit" class="form-submit">{{ __('Search') }}</button>
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
