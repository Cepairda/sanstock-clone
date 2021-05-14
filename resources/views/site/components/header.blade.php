<!-- Header -->


<header>
    <!-- Top -->
    <div class="container">
        <div class="row">
            <div class="col-12">

                <div class="navbar-menu__item navbar-menu--top">

                    <div class="navbar-nav">

                        <ul>
                            <li class="nav-item d-flex align-items-center">
                                <a class="nav-link nav-link-contacts py-0" href="{{ asset('/') }}">
                                    <img src="{{ asset('images/logo/logo.svg') }}" width="150" alt="Sanstok">
                                </a>
                            </li>
                            <li class="nav-item">
                            <li class="nav-item">
                                <a class="nav-link nav-link-contacts" href="#">О нас</a></li>
                            <li class="nav-item">
                                <a class="nav-link nav-link-contacts" href="{{ asset('/contacts') }}">Доставка</a>
                            </li>
                            <li class="nav-item"><a class="nav-link nav-link-contacts" href="{{ asset('/contacts') }}">Контакты</a>
                            </li>
                            <li class="nav-item nav-link-phone"><i class="callback"></i><a class="nav-link"
                                                                                           href="tel:0800212124">0-800-21-21-24</a>
                            </li>
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
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
</header>

<!-- Bottom -->
<div style="position: sticky; top: 0; background: #fff; z-index: 1050; box-shadow: 0 3px 3px rgba(0, 0, 0, .05);">
    <div class="container" >
        <div class="row">
            <div class="col-12">
                <div class="header__bottom">
                    <div class="nav-menu">
                        @include('site.components.headerMenu')
                    </div>
                    <div class="list-item--4 px-5" style="flex-grow: 1">
                        <form class="header-menu__form" id="life-search" action="#" method="post" autocomplete="off">
                            {{ csrf_field() }}
                            <input type="text" id="input-search" class="input-search" name="search_value"
                                   value="{{ isset($search_value) ? $search_value : '' }}" minlength="3"
                                   placeholder="Введите поисковый запрос..."
                                   data-lang="{{ app()->getLocale() }}"
                                   required>
                            <button type="submit" class="header-menu__search">
                                <i class="fas icon-search"></i>Поиск
                            </button>
                        </form>
                    </div>
                    <div class="nav-item nav__actions">
                        <a class="nav__actions--link" href="{{ asset('/cart') }}">
                                        <span class="action-icon">
                                            <span class="action-counter" id="cart-count" hidden>-</span>
                                        </span>
                            <span class="action-name">Корзина</span>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>