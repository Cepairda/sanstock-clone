@extends('layouts.site')
@section('body_class', 'contacts')
@section('meta_title', __('Contacts'))
@section('meta_description', __('Contacts'))
@section('breadcrumbs')
    <li class="breadcrumb-item active"
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


    <main class="main-container bgc-gray">

        @include('site.components.breadcrumbs', ['title' => __('Contacts')])

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-12">
                    <div class="main-container__title">
                        <h1>Контакты</h1>
                    </div>
                </div>

                <div class="col-sm-5  main__contacts-form">

                    <p class="main__contacts-form--title">Написати на Email</p>

                    <form class="contacts-form--lg" action="{{-- url('contact-form') --}}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="text" id="name" name="name" required>
                            <label for="name">Ваше ім'я</label>

                        </div>
                        <div class="form-group">
                            <input type="email" id="email" name="email" required>
                            <label for="email">Ваш E-mail</label>
                        </div>
                        <div class="form-group form-group-static">
                            <textarea type="text" class="" id="message" name="message" required placeholder="Ваше повідомлення"></textarea>
                            <p class="message_count"><span class="message_count-lg">0</span>/300</p>
                            <label for="message">Ваше повідомлення</label>
                        </div>

                        <div class="form-btn pt-4">
                            <button class="button" type="submit">Надіслати</button>
                        </div>
                    </form>
                </div>

                <div class="col-sm-5 main__contacts-dest mb-5">
                    <div class="contacts-dest__title">Гаряча лінія</div>
                    <p class="contacts-dest__descriptipon">З питань співпраці та ідеям поліпшення роботи компанії звертайтеся до Єдиного Call-Центру:</p>
                    <a class="footer__element-phone" href="tel:0800212124">0-800-21-21-24</a>
                </div>

            </div>

        </div>

        {{--<div class="container-fluid map-container">--}}

        {{--<div class="row">--}}

        {{--<div class="col-sm-12">--}}

        {{--<h2 class="text-center">@lang('site.pages.points') <br></h2>--}}

        {{--</div>--}}

        {{--<div id="map" style="height:500px; width: 100%;"></div>--}}

        {{--<script type="text/javascript">function initMap(){var map=new google.maps.Map(document.getElementById('map'),{zoom:11,center:{lat:41.876,lng:-87.624},styles:[ { "featureType": "administrative.locality", "elementType": "all", "stylers": [ { "hue": "#2c2e33" }, { "saturation": 7 }, { "lightness": 19 }, { "visibility": "on" } ] }, { "featureType": "administrative.locality", "elementType": "labels.text", "stylers": [ { "visibility": "on" }, { "saturation": "-3" } ] }, { "featureType": "administrative.locality", "elementType": "labels.text.fill", "stylers": [ { "color": "#f39247" } ] }, { "featureType": "landscape", "elementType": "all", "stylers": [ { "hue": "#ffffff" }, { "saturation": -100 }, { "lightness": 100 }, { "visibility": "simplified" } ] }, { "featureType": "poi", "elementType": "all", "stylers": [ { "hue": "#ee6e1f" }, { "saturation": -100 }, { "lightness": 100 }, { "visibility": "off" } ] }, { "featureType": "poi.school", "elementType": "geometry.fill", "stylers": [ { "color": "#f39247" }, { "saturation": "0" }, { "visibility": "on" } ] }, { "featureType": "road", "elementType": "geometry", "stylers": [ { "hue": "#ff6f00" }, { "saturation": "100" }, { "lightness": 31 }, { "visibility": "simplified" } ] }, { "featureType": "road", "elementType": "geometry.stroke", "stylers": [ { "color": "#f39247" }, { "saturation": "0" } ] }, { "featureType": "road", "elementType": "labels", "stylers": [ { "hue": "#008eff" }, { "saturation": -93 }, { "lightness": 31 }, { "visibility": "on" } ] }, { "featureType": "road.arterial", "elementType": "geometry.stroke", "stylers": [ { "visibility": "on" }, { "color": "#f3dbc8" }, { "saturation": "0" } ] }, { "featureType": "road.arterial", "elementType": "labels", "stylers": [ { "hue": "#bbc0c4" }, { "saturation": -93 }, { "lightness": -2 }, { "visibility": "simplified" } ] }, { "featureType": "road.arterial", "elementType": "labels.text", "stylers": [ { "visibility": "off" } ] }, { "featureType": "road.local", "elementType": "geometry", "stylers": [ { "hue": "#e9ebed" }, { "saturation": -90 }, { "lightness": -8 }, { "visibility": "simplified" } ] }, { "featureType": "transit", "elementType": "all", "stylers": [ { "hue": "#e9ebed" }, { "saturation": 10 }, { "lightness": 69 }, { "visibility": "on" } ] }, { "featureType": "water", "elementType": "all", "stylers": [ { "hue": "#e9ebed" }, { "saturation": -78 }, { "lightness": 67 }, { "visibility": "simplified" } ] } ]});var ctaLayer=new google.maps.KmlLayer({url:'http://www.google.com/maps/d/kml?forcekml=1&mid=1-ZPMN7fkigpXBNrHO9vIfYKa_Mejf0g7',map:map,})}</script>--}}

        {{--<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBXU3B31cEHr3fU2yGiUBMInbjSg4KelcI&callback=initMap&ver=asdaertsdasd"></script>--}}

        {{--</div>--}}

        {{--</div>--}}

    </main>

@endsection
