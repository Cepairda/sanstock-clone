<div class="container">
    <div class="row">
        <div class="breadcrumb-custom">
            <ul itemtype="https://schema.org/BreadcrumbList">
                <li class="breadcrumb-custom__item" itemprop="itemListElement"
                    itemscope itemtype="https://schema.org/ListItem">
                    <a href="{{ asset('/') }}" itemprop="item" content="{{ asset('/') }}">
                        <span itemprop="name">Главная</span>
                    </a>
                    <meta itemprop="position" content="1"/>
                </li>
                @yield('breadcrumbs')
            </ul>
        </div>
    </div>
</div>