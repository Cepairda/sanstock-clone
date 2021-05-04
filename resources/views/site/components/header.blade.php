<!-- Header -->
{{--<header class="page-header">
    <div class="header-topline">
        <div class="container">
            <div class="row">
                <div class="col-12 header-topline__languages">
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
                </div>
            </div>
        </div>
    </div>
    <div class="rd-navbar-height">
        <div class="container">
            <div class="row">
                <!-- RD Navbar-->
                <div class="col-12 rd-navbar-wrap">
                    <nav class="rd-navbar rd-navbar_inverse"
                         data-layout="rd-navbar-fixed"
                         data-sm-layout="rd-navbar-fixed"
                         data-sm-device-layout="rd-navbar-fixed"
                         data-md-layout="rd-navbar-static"
                         data-md-device-layout="rd-navbar-fixed"
                         data-lg-device-layout="rd-navbar-static"
                         data-lg-layout="rd-navbar-static"
                         data-stick-up-clone="false"
                         data-sm-stick-up="true"
                         data-md-stick-up="true"
                         data-lg-stick-up="true"
                         data-md-stick-up-offset="120px"
                         data-lg-stick-up-offset="35px"
                         data-body-class="">
                        <div class="rd-navbar-inner rd-navbar-search-wrap">
                            <!-- RD Navbar Panel-->
                            <div class="rd-navbar-panel rd-navbar-search_collapsable">
                                <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap">
                                    <span></span>
                                </button>
                                <!-- RD Navbar Brand-->
                                <div class="rd-navbar-brand">
                                    <a class="brand-name" href="{{ route('site./') }}">
                                        <img src="{{ asset('images/site/logo.svg') }}" alt="50" width="50"/>
                                    </a>
                                </div>
                            </div>
                            <!-- RD Navbar Nav-->
                            <div class="rd-navbar-nav-wrap rd-navbar-search_not-collapsable">
                                <ul class="rd-navbar-items-list rd-navbar-search_collapsable">
                                    <li>
                                        <button class="rd-navbar-search__toggle rd-navbar-fixed--hidden"
                                                data-rd-navbar-toggle=".rd-navbar-search-wrap"></button>
                                    </li>
                                    <li class="rd-navbar-nav-wrap__shop">
                                        <a class="icon icon-md linear-icon-heart link-primary" href="{{ route('site.favorites') }}"></a>
                                        <span class="header-favorites-count">0</span>
                                    </li>
                                </ul>
                                <!-- RD Search-->
                                <div class="rd-navbar-search rd-navbar-search_toggled rd-navbar-search_not-collapsable">
                                    <form class="rd-search" action="{{ route('site.products.search') }}" method=""
                                          data-search-live="rd-search-results-live">
                                        <div class="form-wrap">
                                            <input class="form-input" id="rd-navbar-search-form-input" type="text"
                                                   name="query"
                                                   autocomplete="off">
                                            <label class="form-label" for="rd-navbar-search-form-input">{{ __('Enter keyword') }}</label>
                                            <div class="rd-search-results-live" id="rd-search-results-live"></div>
                                        </div>
                                        <div class="rd-search__submit"></div>
                                    </form>
                                    <div class="rd-navbar-fixed--hidden">
                                        <button class="rd-navbar-search__toggle"
                                                data-custom-toggle=".rd-navbar-search-wrap"
                                                data-custom-toggle-disable-on-blur="true"></button>
                                    </div>
                                </div>
                                <div class="rd-navbar-search_collapsable">
                                    @include('site.components.categories', ['ul_class' => 'rd-navbar-nav'])
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>--}}
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
                        <img src="{{ asset('images/logo.png') }}" alt="SanStock" title="SanStock">
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
                                <li class="nav-item nav-comparison">
                                    <a class="nav-link icon- nav-link-comparison pr-0" href="#">
                                        <span class="favorites-item">Сравнение</span>
                                        <span class="comparison-lg" id="comparison-count">0</span>
                                    </a>
                                </li>
                                <li class="nav-item nav-favorites">
                                    <a class="nav-link icon- nav-link-favorites pr-0" href="#">
                                        <span class="favorites-item">Корзина</span>
                                        <span class="favorites-lg" id="favorites-count">0</span>
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
                                <a href="tel:0800212124">0-800-21-21-24</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>
