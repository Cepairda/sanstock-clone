<!-- Header -->
<header>
    <div class="head fixed-top bgc-white">
        <div class="container header">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="navbar-mb">
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarNavAltMarkup"
                            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <a class="navbar-brand" href="{{ asset('/') }}">
                        <img class="w-100"  src="{{ asset('images/logo.png') }}" alt="SanStock" title="SanStock">
                    </a>
                    <div class="navbar-mb__lf-cont">
                        <form class="header-menu__form" action="#" method="post">
                            {{ csrf_field() }}
                            <input type="search" class="input-search" name="search_value"
                                   value="{{ isset($search_value) ? $search_value : '' }}" minlength="3" required>
                            <button class="header-menu__search">
                                <i class="icon-search"></i>
                            </button>
                        </form>
                        {{--<div class="navbar-mb__favorites icon-favorites"></div>--}}
                    </div>
                </div>
                <div class="navbar-menu collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-menu__item navbar-menu--top">
                        <div class="navbar-nav">
                            <ul>

                                <li class="nav-item"><a class="nav-link nav-link-contacts" href="#">Контакты</a></li>

                                <li class="nav-item nav-link-phone"><i class="callback"></i><a class="nav-link" href="tel:0800212124">0-800-21-21-24</a></li>

                                <li class="nav-item nav-language">
                                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                        @if(LaravelLocalization::getCurrentLocale() == $localeCode)
                                            <span class="lang-item">{{ $localeCode == 'uk' ? 'ua' : $localeCode }}</span>
                                        @else
                                            <a class="lang-item"
                                               href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, []) }}">
                                                {{ $localeCode == 'uk' ? 'ua' : $localeCode }}
                                            </a>
                                        @endif
                                    @endforeach
                                </li>
                                <li class="nav-item nav-cart">
                                    <a class="nav-link icon- nav-link-favorites pr-0" href="{{ asset('/cart') }}">
                                        <span class="favorites-item">Корзина</span>
                                        <span class="favorites-lg" id="cart-count" hidden>-</span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <div class="header-line"></div>

                    <div class="header__bottom">

                        <ul class="nav-menu">

                            @include('site.components.headerMenu')

                        </ul>
                        <div class="list-item--4 col-lg-3 col-xl-4">
                            <form class="header-menu__form" id="life-search" action="#" method="post" autocomplete="off">
                                {{ csrf_field() }}
                                <input type="text" id="input-search" class="input-search" name="search_value"
                                       value="{{ isset($search_value) ? $search_value : '' }}" minlength="3"
                                       data-lang="{{ app()->getLocale() }}"
                                       required>
                                <button type="submit" class="header-menu__search">
                                    <i class="fas icon-search"></i>Поиск
                                </button>
                            </form>
                        </div>

                    </div>

                    <div class="navbar-menu__item navbar-menu--call">
                        <p class="menu-call__title">@lang('site.content.hotline'):</p>
                        <ul>
                            <li class="menu-call__phone">
                                <a href="tel:0800000000">0-800-00-00-00</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>