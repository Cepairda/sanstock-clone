@extends('layouts.site')
@section('body_class', 'contacts')
@section('meta_title', __('Contacts'))
@section('meta_description', __('Contacts'))
@section('breadcrumbs')
    <li class="active"
        itemprop="itemListElement"
        itemscope itemtype="https://schema.org/ListItem"
    >
        <span itemprop="name">
            {{ __('Contacts') }}
        </span>
        <meta itemprop="position" content="2" />
    </li>
@endsection
@section('content')

    @include('site.components.breadcrumbs', ['title' => __('Contacts')])
{{--    <section>--}}
{{--        <div class="container-fluid">--}}
{{--            <div class="row">--}}
{{--                <div id="map" class="col-12" style="height: 500px; background-color: #999;"></div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
{{--    <section>--}}
{{--        <div class="container py-5">--}}
{{--            <div class="row">--}}
{{--                <div class="col-6">--}}
{{--                    <h5 class="">Контакты</h5>--}}
{{--                    <ul>--}}
{{--                        <li><span class="mr-1">Адрес:</span>Украина</li>--}}
{{--                        <li><span class="mr-1">Телефон:</span><a href="tel:08001230045">0 (800) 123-00-45</a></li>--}}
{{--                        <li><span class="mr-1">E-mail:</span><a href="mail:info@sandiplus.com.ua">info@sandiplus.com.ua</a></li>--}}
{{--                        <li><span class="mr-1">Режим работы:</span>Пн-Пт 10 am-8 pm</li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--                <div class="col-6">--}}
{{--                    <form action="">--}}
{{--                        <h5>Свяжитесь с нами</h5>--}}
{{--                        <div class="form-wrap">--}}
{{--                            <input class="form-input" id="contact-name" type="text" name="name" data-constraints="@Required">--}}
{{--                            <label class="form-label" for="contact-name">Ваше Имя *</label>--}}
{{--                        </div>--}}
{{--                        <div class="form-wrap">--}}
{{--                            <input class="form-input" id="contact-email" type="email" name="email" data-constraints="@Email @Required">--}}
{{--                            <label class="form-label" for="contact-email">Ваш e-mail *</label>--}}
{{--                        </div>--}}
{{--                        <div class="form-wrap">--}}
{{--                            <input class="form-input" id="contact-phone" type="text" name="phone" data-constraints="@Numeric">--}}
{{--                            <label class="form-label" for="contact-phone">Ваш телефон *</label>--}}
{{--                        </div>--}}
{{--                        <div class="form-wrap">--}}
{{--                            <textarea class="form-input" id="contact-message" name="message" data-constraints="@Required"></textarea>--}}
{{--                            <label class="form-label" for="contact-message">Сообщение *</label>--}}
{{--                        </div>--}}
{{--                        <button class="button button-primary" type="submit">Отправить</button>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}


{{--    <section>--}}
{{--        <!-- RD Google Map-->--}}
{{--        <div class="rd-google-map rd-google-map__model" data-zoom="15" data-y="40.643180" data-x="-73.9874068" data-styles="[{&quot;featureType&quot;:&quot;water&quot;,&quot;elementType&quot;:&quot;geometry&quot;,&quot;stylers&quot;:[{&quot;color&quot;:&quot;#e9e9e9&quot;},{&quot;lightness&quot;:17}]},{&quot;featureType&quot;:&quot;landscape&quot;,&quot;elementType&quot;:&quot;geometry&quot;,&quot;stylers&quot;:[{&quot;color&quot;:&quot;#f5f5f5&quot;},{&quot;lightness&quot;:20}]},{&quot;featureType&quot;:&quot;road.highway&quot;,&quot;elementType&quot;:&quot;geometry.fill&quot;,&quot;stylers&quot;:[{&quot;color&quot;:&quot;#ffffff&quot;},{&quot;lightness&quot;:17}]},{&quot;featureType&quot;:&quot;road.highway&quot;,&quot;elementType&quot;:&quot;geometry.stroke&quot;,&quot;stylers&quot;:[{&quot;color&quot;:&quot;#ffffff&quot;},{&quot;lightness&quot;:29},{&quot;weight&quot;:0.2}]},{&quot;featureType&quot;:&quot;road.arterial&quot;,&quot;elementType&quot;:&quot;geometry&quot;,&quot;stylers&quot;:[{&quot;color&quot;:&quot;#ffffff&quot;},{&quot;lightness&quot;:18}]},{&quot;featureType&quot;:&quot;road.local&quot;,&quot;elementType&quot;:&quot;geometry&quot;,&quot;stylers&quot;:[{&quot;color&quot;:&quot;#ffffff&quot;},{&quot;lightness&quot;:16}]},{&quot;featureType&quot;:&quot;poi&quot;,&quot;elementType&quot;:&quot;geometry&quot;,&quot;stylers&quot;:[{&quot;color&quot;:&quot;#f5f5f5&quot;},{&quot;lightness&quot;:21}]},{&quot;featureType&quot;:&quot;poi.park&quot;,&quot;elementType&quot;:&quot;geometry&quot;,&quot;stylers&quot;:[{&quot;color&quot;:&quot;#dedede&quot;},{&quot;lightness&quot;:21}]},{&quot;elementType&quot;:&quot;labels.text.stroke&quot;,&quot;stylers&quot;:[{&quot;visibility&quot;:&quot;on&quot;},{&quot;color&quot;:&quot;#ffffff&quot;},{&quot;lightness&quot;:16}]},{&quot;elementType&quot;:&quot;labels.text.fill&quot;,&quot;stylers&quot;:[{&quot;saturation&quot;:36},{&quot;color&quot;:&quot;#333333&quot;},{&quot;lightness&quot;:40}]},{&quot;elementType&quot;:&quot;labels.icon&quot;,&quot;stylers&quot;:[{&quot;visibility&quot;:&quot;off&quot;}]},{&quot;featureType&quot;:&quot;transit&quot;,&quot;elementType&quot;:&quot;geometry&quot;,&quot;stylers&quot;:[{&quot;color&quot;:&quot;#f2f2f2&quot;},{&quot;lightness&quot;:19}]},{&quot;featureType&quot;:&quot;administrative&quot;,&quot;elementType&quot;:&quot;geometry.fill&quot;,&quot;stylers&quot;:[{&quot;color&quot;:&quot;#fefefe&quot;},{&quot;lightness&quot;:20}]},{&quot;featureType&quot;:&quot;administrative&quot;,&quot;elementType&quot;:&quot;geometry.stroke&quot;,&quot;stylers&quot;:[{&quot;color&quot;:&quot;#fefefe&quot;},{&quot;lightness&quot;:17},{&quot;weight&quot;:1.2}]}]">--}}
{{--            <ul class="map_locations">--}}
{{--                <li data-y="40.643180" data-x="-73.9874068">--}}
{{--                    <dl>--}}
{{--                        <dt>Address:</dt>--}}
{{--                        <dd>4578 Marmora Road, Glasgow, D04 89GR</dd>--}}
{{--                    </dl>--}}
{{--                    <dl>--}}
{{--                        <dt>Phones:</dt>--}}
{{--                        <dd><a href="callto:#">(800) 123-0045</a>; <a href="callto:#">(800) 123-0046</a>--}}
{{--                        </dd>--}}
{{--                    </dl>--}}
{{--                    <dl>--}}
{{--                        <dt>We are open:</dt>--}}
{{--                        <dd>Mn-Fr: 10 am-8 pm</dd>--}}
{{--                    </dl>--}}
{{--                </li>--}}
{{--            </ul>--}}
{{--        </div>--}}
{{--    </section>--}}


    <section class="section-md bg-white">
        <div class="shell">
            <div class="range range-50">

                <div class="cell-sm-5 cell-md-4">
                    <h3>{{ __('Contacts') }}</h3>
                    <ul class="list-xs contact-info">
                        {{--<li>
                            <dl class="list-terms-minimal">
                                <dt>{{ __('Address') }}</dt>
                                <dd>Вулиця Шевченка, 327, корп. 2-2, Харків, Харківська область, 61000</dd>
                            </dl>
                        </li>--}}
                        <li>
                            <dl class="list-terms-minimal">
                                <dt>{{ __('Phone') }}</dt>
                                <dd>
                                    <ul class="list-semicolon">
                                        <li><a href="callto:0800210377">0-800-210-377</a></li>
                                        {{--<li><a href="callto:#">+380 (97) 917-94-94</a></li>--}}
                                        {{--<li><a href="callto:#">+380 (95) 917-94-94</a></li>--}}
                                        {{--<li><a href="callto:#">+380 (93) 917-94-94</a></li>--}}
                                    </ul>
                                </dd>
                            </dl>
                        </li>
                        <li>
                            <dl class="list-terms-minimal">
                                <dt>E-mail</dt>
                                <dd><a href="mailto:#">info@lidz.ua</a></dd>
                            </dl>
                        </li>

                        {{--<li>
                            <ul class="list-inline-sm">
                                <li><a class="icon icon-gray-4 icon-sm fa-facebook" href="#"></a></li>
                                <li><a class="icon icon-gray-4 icon-sm fa-twitter" href="#"></a></li>
                                <li><a class="icon icon-gray-4 icon-sm fa-google-plus" href="#"></a></li>
                                <li><a class="icon icon-gray-4 icon-sm fa-vimeo" href="#"></a></li>
                                <li><a class="icon icon-gray-4 icon-sm fa-youtube" href="#"></a></li>
                                <li><a class="icon icon-gray-4 icon-sm fa-pinterest-p" href="#"></a></li>
                            </ul>
                        </li>--}}
                    </ul>
                </div>

                <div class="cell-sm-7 cell-md-8">
                    <h3>{{ __('Get in Touch') }}</h3>
                    <!-- RD Mailform-->
                    <form class="rd-mailform rd-mailform_style-1" data-form-output="form-output-global" data-form-type="contact" method="post" action="{{ route('site.contact-form') }}">
                        @method('post')
                        {{ csrf_field() }}
                        <div class="form-wrap">
                            <input class="form-input" id="contact-name" type="text" name="name" data-constraints="@Required">
                            <label class="form-label" for="contact-name">{{ __('Name') }}</label>
                        </div>
                        <div class="form-wrap">
                            <input class="form-input" id="contact-email" type="email" name="email" data-constraints="@Email @Required">
                            <label class="form-label" for="contact-email">E-mail</label>
                        </div>
                        <div class="form-wrap">
                            <input class="form-input" id="contact-phone" type="text" name="phone" data-constraints="@Numeric">
                            <label class="form-label" for="contact-phone">{{ __('Phone') }}</label>
                        </div>
                        <div class="form-wrap">
                            <textarea class="form-input" id="contact-message" name="message" data-constraints="@Required"></textarea>
                            <label class="form-label" for="contact-message">{{ __('Message') }}</label>
                        </div>
                        <button class="button button-primary" type="submit">{{ __('Send') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
