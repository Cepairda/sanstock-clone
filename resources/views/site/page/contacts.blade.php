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
                        <h1>{{ __('Contacts') }}</h1>
                    </div>
                </div>

                <div class="col-sm-5  main__contacts-form">

                    <p class="main__contacts-form--title">{{ __('Write to Email') }}</p>

                    <form class="contacts-form--lg" action="{{-- url('contact-form') --}}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="text" id="name" name="name" required>
                            <label for="name">{{ __('Name') }}</label>

                        </div>
                        <div class="form-group">
                            <input type="email" id="email" name="email" required>
                            <label for="email">E-mail</label>
                        </div>

                        <div class="form-group">
                            <textarea class="w-100" name="message" id="message" cols="30" rows="10" required></textarea>
                            <label for="message">{{ __('Your message') }}</label>
                        </div>

                        <div class="form-btn pt-4">
                            <button class="button" type="submit">{{ __('Send message') }}</button>
                        </div>
                    </form>
                </div>

                <div class="col-sm-5 main__contacts-dest mb-5">
                    <div class="contacts-dest__title">{{ __('Hot line') }}</div>
                    {{--<p class="contacts-dest__descriptipon">З питань співпраці та ідеям поліпшення роботи компанії звертайтеся до Єдиного Call-Центру:</p>--}}
                    <a class="footer__element-phone text-center" href="tel:0800212124">0-800-21-21-24</a>
                </div>

            </div>

        </div>

    </main>

@endsection
