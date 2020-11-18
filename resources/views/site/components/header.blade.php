<!-- Header -->
<header class="page-header">
    <div class="header-topline">
        <div class="container">
            <div class="row">
                <div class="col-12 header-topline__wrap" style="padding-top: 15px; padding-bottom: 15px;font-size: 12px">
                    <div><a href="#">UA</a> / <span>RU</span></div>
                </div>
            </div>
        </div>
    </div>
    <div>
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
                                    <a class="brand-name" href="{{ route('/') }}">
                                        <img src="{{ asset('images/site/logo-150x150.jpg') }}" alt="" width="50"/>
                                    </a>
                                </div>
                            </div>
                            <!-- RD Navbar Nav-->
                            <div class="rd-navbar-nav-wrap rd-navbar-search_not-collapsable" style="position:relative; justify-content: center">
                                <ul class="rd-navbar-items-list rd-navbar-search_collapsable" style="position: absolute; right: 0;">
                                    <li>
                                        <button class="rd-navbar-search__toggle rd-navbar-fixed--hidden"
                                                data-rd-navbar-toggle=".rd-navbar-search-wrap"></button>
                                    </li>
                                    <li class="rd-navbar-nav-wrap__shop"><a
                                                class="icon icon-md linear-icon-heart link-primary"
                                                href="#"></a></li>
                                </ul>
                                <!-- RD Search-->
                                <div class="rd-navbar-search rd-navbar-search_toggled rd-navbar-search_not-collapsable">
                                    <form class="rd-search" action="search-results.html" method="GET"
                                          data-search-live="rd-search-results-live">
                                        <div class="form-wrap">
                                            <input class="form-input" id="rd-navbar-search-form-input" type="text"
                                                   name="s"
                                                   autocomplete="off">
                                            <label class="form-label" for="rd-navbar-search-form-input">Enter
                                                keyword</label>
                                            <div class="rd-search-results-live" id="rd-search-results-live"></div>
                                        </div>
                                        <button class="rd-search__submit" type="submit"></button>
                                    </form>
                                    <div class="rd-navbar-fixed--hidden">
                                        <button class="rd-navbar-search__toggle"
                                                data-custom-toggle=".rd-navbar-search-wrap"
                                                data-custom-toggle-disable-on-blur="true"></button>
                                    </div>
                                </div>
                                <div class="rd-navbar-search_collapsable">
                                    <ul class="rd-navbar-nav">
                                        <li>
                                            <a href="#">Для ванной комнаты</a>
                                            <ul class="rd-navbar-dropdown">
                                                <li><a href="#">Home Default</a></li>
                                                <li><a href="#">Home Business</a></li>
                                                <li><a href="#">Home Commercial</a></li>
                                                <li>
                                                    <a href="#">Headers</a>
                                                    <ul class="rd-navbar-dropdown">
                                                        <li><a href="#">Header Default</a></li>
                                                        <li><a href="#">Header Creative</a></li>
                                                        <li><a href="#">Header Transparent</a></li>
                                                    </ul>
                                                </li>
                                                <li><a href="#">Footers</a>
                                                    <ul class="rd-navbar-dropdown">
                                                        <li><a href="#">Footer Corporate</a></li>
                                                        <li><a href="#">Footer Minimal</a></li>
                                                        <li><a href="#">Footer Modern</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="#">Для кухни</a>
                                            <ul class="rd-navbar-dropdown">
                                                <li><a href="#">Catalog List</a></li>
                                                <li><a href="#">Catalog Grid</a></li>
                                                <li><a href="#">Single Product</a></li>
                                                <li><a href="#">Cart</a></li>
                                                <li><a href="#">Checkout</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="#">Керамика</a>
                                        </li>
                                        <li>
                                            <a href="#">Аксессуары</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>