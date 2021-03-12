<section class="breadcrumbs-custom">
    <div class="shell">
        <div class="breadcrumbs-custom__inner">

            @if(isset($h1))
                <h1 class="breadcrumbs-custom__title">{{ $title ?? '' }}</h1>
            @else
                <div class="breadcrumbs-custom__title">{{ $title ?? '' }}</div>
            @endif
            <ul class="breadcrumbs-custom__path" itemscope itemtype="https://schema.org/BreadcrumbList">
                <li itemprop="itemListElement"
                    itemscope itemtype="https://schema.org/ListItem"
                >
                    <a href="/" itemprop="item">
                        <span itemprop="name">
                            {{ __('Home') }}
                        </span>
                    </a>
                    <meta itemprop="position" content="1" />
                </li>
                @yield('breadcrumbs')
{{--                <li><a href="#">{{ 'Пусто' ?? $someVariable }}</a></li>--}}
{{--                <li class="active">{{ 'Пусто' ?? $someVariable }}</li>--}}
            </ul>
        </div>
    </div>
</section>
