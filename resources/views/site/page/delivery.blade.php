@extends('layouts.site')
@section('body_class', 'about')
@section('meta_title', __('About'))
@section('meta_description', __('About'))
@section('breadcrumbs')
    <li class="breadcrumb-item active"
        itemprop="itemListElement"
        itemscope itemtype="https://schema.org/ListItem"
    >
        <span itemprop="name">
            {{ __('Delivery') }}
        </span>
        <meta itemprop="position" content="2"/>
    </li>
@endsection
@section('content')

    <main class="main-container bgc-gray">

        @include('site.components.breadcrumbs')

        <div class="container container-gap-sm">
            <div class="row">
                <div class="col-12" style="font-size: 16px">
                    <h1 class="text-center mb-2">{{ __('Delivery') }}</h1>
                    <h6 class="mb-4"
                        style="
                            width: 50%;
                            margin: 0 auto;
                            text-align: center;
                            line-height: 1.5;
                            color: #757575;"
                    >Наша цель, чтобы купленный в интернет-магазине «SandiStock» товар, в кратчайшие сроки был доставлен покупателю.</h6>

                    <div class="mb-4">
                        <img class="w-100" src="{{ asset('images/site/banners/' . LaravelLocalization::getCurrentLocale() . '/delivery.png') }}" alt="{{ __('Delivery') }}">
                    </div>

                    <h4 class="pt-4 mb-2">Условия доставки</h4>
                    <p class="mb-4">Доставка продукции по Украине осуществляется службой доставки «Новая Почта», указывая номер отделения или адреса для курьерской доставки. Оплата за доставку осуществляется покупателем при получении заказа, по тарифам службы доставки «Новая почта».</p>
                    <p class="mb-4">Заказы от 500 грн отправлются клиентам на отделение за счет интернет-магазина
                        «SandiStock», при заказах от 1000 грн можно выбрать курьерскую доставку, расходы за которую
                        несет наш магазин.</p>
                    <h4 class="pt-4 mb-4">Сроки отправления заказов?</h4>
                    <table>
                        <tbody>
                            <tr style="height: 75px;">
                                <td style="width: 80px; padding: 0 15px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Слой_1" x="0px" y="0px" viewBox="0 0 280 280" style="enable-background:new 0 0 280 280;" xml:space="preserve">
<g>
<g>
    <path d="M120.57,216.98c-13.66,0-24.78-11.11-24.78-24.78s11.11-24.78,24.78-24.78s24.78,11.11,24.78,24.78    S134.23,216.98,120.57,216.98z M120.57,174.51c-9.76,0-17.7,7.94-17.7,17.7s7.94,17.7,17.7,17.7s17.7-7.94,17.7-17.7    S130.33,174.51,120.57,174.51z"/>
</g>
<g>
    <path d="M236.48,216.98c-13.66,0-24.78-11.11-24.78-24.78s11.11-24.78,24.78-24.78c13.66,0,24.77,11.11,24.77,24.78    S250.14,216.98,236.48,216.98z M236.48,174.51c-9.76,0-17.7,7.94-17.7,17.7s7.94,17.7,17.7,17.7c9.76,0,17.7-7.94,17.7-17.7    S246.24,174.51,236.48,174.51z"/>
</g>
<g>
    <path d="M91.37,93.1H32.08c-1.95,0-3.54-1.58-3.54-3.54c0-1.95,1.58-3.54,3.54-3.54h59.28c1.95,0,3.54,1.58,3.54,3.54    C94.91,91.52,93.32,93.1,91.37,93.1z"/>
</g>
<g>
    <path d="M43.59,116.99H5.54c-1.95,0-3.54-1.58-3.54-3.54c0-1.95,1.58-3.54,3.54-3.54h38.05c1.95,0,3.54,1.58,3.54,3.54    C47.13,115.41,45.54,116.99,43.59,116.99z"/>
</g>
<g>
    <path d="M123.22,143.54H38.28c-1.95,0-3.54-1.58-3.54-3.54c0-1.95,1.58-3.54,3.54-3.54h84.94c1.95,0,3.54,1.58,3.54,3.54    C126.76,141.96,125.18,143.54,123.22,143.54z"/>
</g>
<g>
    <path d="M79.87,163.01H10.85c-1.95,0-3.54-1.58-3.54-3.54s1.58-3.54,3.54-3.54h69.02c1.95,0,3.54,1.58,3.54,3.54    S81.82,163.01,79.87,163.01z"/>
</g>
<g>
    <path d="M198.73,195.75h-56.93c-1.95,0-3.54-1.58-3.54-3.54c0-9.76-7.94-17.7-17.7-17.7s-17.7,7.94-17.7,17.7    c0,1.95-1.58,3.54-3.54,3.54h-34.8c-4.23,0-7.67-3.44-7.67-7.67V70.69c0-4.23,3.44-7.67,7.67-7.67h134.2    c4.23,0,7.67,3.44,7.67,7.67v117.39C206.4,192.3,202.96,195.75,198.73,195.75z M145.09,188.67h53.64c0.32,0,0.59-0.26,0.59-0.59    V70.69c0-0.32-0.26-0.59-0.59-0.59H64.53c-0.32,0-0.59,0.26-0.59,0.59v117.39c0,0.33,0.26,0.59,0.59,0.59h31.52    c1.72-11.99,12.06-21.24,24.52-21.24S143.37,176.68,145.09,188.67z"/>
</g>
<g>
    <path d="M274.53,195.67h-16.81c-1.92,0-3.47-1.55-3.47-3.47c0-9.8-7.97-17.77-17.77-17.77c-9.8,0-17.77,7.97-17.77,17.77    c0,1.92-1.55,3.47-3.47,3.47h-12.39c-1.92,0-3.47-1.55-3.47-3.47v-84.95c0-1.92,1.55-3.47,3.47-3.47h40.41    c1.2,0,2.31,0.62,2.95,1.64l29.26,47.17c1.65,2.66,2.52,5.73,2.52,8.86v30.74C278,194.12,276.45,195.67,274.53,195.67z     M260.94,188.74h10.12v-27.28c0-1.84-0.51-3.64-1.48-5.2l-28.24-45.53h-35.01v78.01h5.7c1.69-11.99,12.02-21.24,24.46-21.24    S259.25,176.75,260.94,188.74z"/>
</g>
</g>
</svg>
                                </td>
                                <td style="padding-right: 15px">день в день</td>
                                <td>При условии оформления заказа до 11:00 с понедельника по четверг</td>
                            </tr>
                            <tr style="height: 75px;">
                                <td style="width: 80px; padding: 0 15px">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Слой_1" x="0px" y="0px" viewBox="0 0 280 280" style="enable-background:new 0 0 280 280;" xml:space="preserve">
<g>
<g>
    <path d="M120.57,216.98c-13.66,0-24.78-11.11-24.78-24.78s11.11-24.78,24.78-24.78s24.78,11.11,24.78,24.78    S134.23,216.98,120.57,216.98z M120.57,174.51c-9.76,0-17.7,7.94-17.7,17.7s7.94,17.7,17.7,17.7s17.7-7.94,17.7-17.7    S130.33,174.51,120.57,174.51z"/>
</g>
<g>
    <path d="M236.48,216.98c-13.66,0-24.78-11.11-24.78-24.78s11.11-24.78,24.78-24.78c13.66,0,24.77,11.11,24.77,24.78    S250.14,216.98,236.48,216.98z M236.48,174.51c-9.76,0-17.7,7.94-17.7,17.7s7.94,17.7,17.7,17.7c9.76,0,17.7-7.94,17.7-17.7    S246.24,174.51,236.48,174.51z"/>
</g>
<g>
    <path d="M91.37,93.1H32.08c-1.95,0-3.54-1.58-3.54-3.54c0-1.95,1.58-3.54,3.54-3.54h59.28c1.95,0,3.54,1.58,3.54,3.54    C94.91,91.52,93.32,93.1,91.37,93.1z"/>
</g>
<g>
    <path d="M43.59,116.99H5.54c-1.95,0-3.54-1.58-3.54-3.54c0-1.95,1.58-3.54,3.54-3.54h38.05c1.95,0,3.54,1.58,3.54,3.54    C47.13,115.41,45.54,116.99,43.59,116.99z"/>
</g>
<g>
    <path d="M123.22,143.54H38.28c-1.95,0-3.54-1.58-3.54-3.54c0-1.95,1.58-3.54,3.54-3.54h84.94c1.95,0,3.54,1.58,3.54,3.54    C126.76,141.96,125.18,143.54,123.22,143.54z"/>
</g>
<g>
    <path d="M79.87,163.01H10.85c-1.95,0-3.54-1.58-3.54-3.54s1.58-3.54,3.54-3.54h69.02c1.95,0,3.54,1.58,3.54,3.54    S81.82,163.01,79.87,163.01z"/>
</g>
<g>
    <path d="M198.73,195.75h-56.93c-1.95,0-3.54-1.58-3.54-3.54c0-9.76-7.94-17.7-17.7-17.7s-17.7,7.94-17.7,17.7    c0,1.95-1.58,3.54-3.54,3.54h-34.8c-4.23,0-7.67-3.44-7.67-7.67V70.69c0-4.23,3.44-7.67,7.67-7.67h134.2    c4.23,0,7.67,3.44,7.67,7.67v117.39C206.4,192.3,202.96,195.75,198.73,195.75z M145.09,188.67h53.64c0.32,0,0.59-0.26,0.59-0.59    V70.69c0-0.32-0.26-0.59-0.59-0.59H64.53c-0.32,0-0.59,0.26-0.59,0.59v117.39c0,0.33,0.26,0.59,0.59,0.59h31.52    c1.72-11.99,12.06-21.24,24.52-21.24S143.37,176.68,145.09,188.67z"/>
</g>
<g>
    <path d="M274.53,195.67h-16.81c-1.92,0-3.47-1.55-3.47-3.47c0-9.8-7.97-17.77-17.77-17.77c-9.8,0-17.77,7.97-17.77,17.77    c0,1.92-1.55,3.47-3.47,3.47h-12.39c-1.92,0-3.47-1.55-3.47-3.47v-84.95c0-1.92,1.55-3.47,3.47-3.47h40.41    c1.2,0,2.31,0.62,2.95,1.64l29.26,47.17c1.65,2.66,2.52,5.73,2.52,8.86v30.74C278,194.12,276.45,195.67,274.53,195.67z     M260.94,188.74h10.12v-27.28c0-1.84-0.51-3.64-1.48-5.2l-28.24-45.53h-35.01v78.01h5.7c1.69-11.99,12.02-21.24,24.46-21.24    S259.25,176.75,260.94,188.74z"/>
</g>
</g>
</svg>
                                </td>
                                <td style="padding-right: 15px">на следующий день</td>
                                <td>При условии оформления заказа после 11:00 с понедельника по четверг</td>
                            </tr>
                            <tr style="height: 75px;">
                                <td style="width: 80px; padding: 0 15px">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Слой_1" x="0px" y="0px" viewBox="0 0 280 280" style="enable-background:new 0 0 280 280;" xml:space="preserve">
<g>
<g>
    <path d="M120.57,216.98c-13.66,0-24.78-11.11-24.78-24.78s11.11-24.78,24.78-24.78s24.78,11.11,24.78,24.78    S134.23,216.98,120.57,216.98z M120.57,174.51c-9.76,0-17.7,7.94-17.7,17.7s7.94,17.7,17.7,17.7s17.7-7.94,17.7-17.7    S130.33,174.51,120.57,174.51z"/>
</g>
<g>
    <path d="M236.48,216.98c-13.66,0-24.78-11.11-24.78-24.78s11.11-24.78,24.78-24.78c13.66,0,24.77,11.11,24.77,24.78    S250.14,216.98,236.48,216.98z M236.48,174.51c-9.76,0-17.7,7.94-17.7,17.7s7.94,17.7,17.7,17.7c9.76,0,17.7-7.94,17.7-17.7    S246.24,174.51,236.48,174.51z"/>
</g>
<g>
    <path d="M91.37,93.1H32.08c-1.95,0-3.54-1.58-3.54-3.54c0-1.95,1.58-3.54,3.54-3.54h59.28c1.95,0,3.54,1.58,3.54,3.54    C94.91,91.52,93.32,93.1,91.37,93.1z"/>
</g>
<g>
    <path d="M43.59,116.99H5.54c-1.95,0-3.54-1.58-3.54-3.54c0-1.95,1.58-3.54,3.54-3.54h38.05c1.95,0,3.54,1.58,3.54,3.54    C47.13,115.41,45.54,116.99,43.59,116.99z"/>
</g>
<g>
    <path d="M123.22,143.54H38.28c-1.95,0-3.54-1.58-3.54-3.54c0-1.95,1.58-3.54,3.54-3.54h84.94c1.95,0,3.54,1.58,3.54,3.54    C126.76,141.96,125.18,143.54,123.22,143.54z"/>
</g>
<g>
    <path d="M79.87,163.01H10.85c-1.95,0-3.54-1.58-3.54-3.54s1.58-3.54,3.54-3.54h69.02c1.95,0,3.54,1.58,3.54,3.54    S81.82,163.01,79.87,163.01z"/>
</g>
<g>
    <path d="M198.73,195.75h-56.93c-1.95,0-3.54-1.58-3.54-3.54c0-9.76-7.94-17.7-17.7-17.7s-17.7,7.94-17.7,17.7    c0,1.95-1.58,3.54-3.54,3.54h-34.8c-4.23,0-7.67-3.44-7.67-7.67V70.69c0-4.23,3.44-7.67,7.67-7.67h134.2    c4.23,0,7.67,3.44,7.67,7.67v117.39C206.4,192.3,202.96,195.75,198.73,195.75z M145.09,188.67h53.64c0.32,0,0.59-0.26,0.59-0.59    V70.69c0-0.32-0.26-0.59-0.59-0.59H64.53c-0.32,0-0.59,0.26-0.59,0.59v117.39c0,0.33,0.26,0.59,0.59,0.59h31.52    c1.72-11.99,12.06-21.24,24.52-21.24S143.37,176.68,145.09,188.67z"/>
</g>
<g>
    <path d="M274.53,195.67h-16.81c-1.92,0-3.47-1.55-3.47-3.47c0-9.8-7.97-17.77-17.77-17.77c-9.8,0-17.77,7.97-17.77,17.77    c0,1.92-1.55,3.47-3.47,3.47h-12.39c-1.92,0-3.47-1.55-3.47-3.47v-84.95c0-1.92,1.55-3.47,3.47-3.47h40.41    c1.2,0,2.31,0.62,2.95,1.64l29.26,47.17c1.65,2.66,2.52,5.73,2.52,8.86v30.74C278,194.12,276.45,195.67,274.53,195.67z     M260.94,188.74h10.12v-27.28c0-1.84-0.51-3.64-1.48-5.2l-28.24-45.53h-35.01v78.01h5.7c1.69-11.99,12.02-21.24,24.46-21.24    S259.25,176.75,260.94,188.74z"/>
</g>
</g>
</svg>
                                </td>
                                <td style="padding-right: 15px">в понедельник</td>
                                <td>При условии оформления заказа в пятницу после 11:00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </main>

@endsection