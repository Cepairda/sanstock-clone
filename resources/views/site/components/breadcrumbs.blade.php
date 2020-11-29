<section class="breadcrumbs-custom">
    <div class="shell">
        <div class="breadcrumbs-custom__inner">

            <p class="breadcrumbs-custom__title">{{ 'Нет заголовка' ?? $someVariable }}</p>

            <ul class="breadcrumbs-custom__path">
                <li><a href="/">{{ __('Home') }}</a></li>
                @yield('breadcrumbs')



{{--                <li><a href="#">{{ 'Пусто' ?? $someVariable }}</a></li>--}}

{{--                <li class="active">{{ 'Пусто' ?? $someVariable }}</li>--}}

            </ul>
        </div>
    </div>
</section>
