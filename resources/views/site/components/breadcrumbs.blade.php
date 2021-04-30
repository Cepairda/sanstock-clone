<div class="container">
    <div class="main__breadcrumb">
        <ul class="main__breadcrumb-lg" itemscope itemtype="https://schema.org/BreadcrumbList">
            <li class="breadcrumb-item" itemprop="itemListElement"
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