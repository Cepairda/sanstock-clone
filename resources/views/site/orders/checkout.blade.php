@extends('layouts.site')
@section('body_class', 'checkout')
@section('meta_title', __('Checkout title'))
@section('meta_description',  __('Checkout description'))

@section('breadcrumbs')
    <li class="breadcrumb-item" itemprop="itemListElement"
        itemscope itemtype="https://schema.org/ListItem">
        <a href="{{ asset('/cart') }}" itemprop="item" content="{{ asset('/cart') }}">
            <span itemprop="name">{{ __('Cart') }}</span>
        </a>
        <meta itemprop="position" content="2"/>
    </li>
    <li class="breadcrumb-item active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
        <span itemprop="name">
           {{ __('Checkout') }}
        </span>
        <meta itemprop="position" content="3"/>
    </li>
@endsection

@section('content')

    <main class="main-container">
        @include('site.components.breadcrumbs')

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-12">

                    <div class="main-container__title">

                        <h1 class="">{{ __('Checkout order') }}</h1>

                    </div>

                </div>

                <div class="col-12 col-lg-8">

                    <div class="main__contacts-form">

                        <form action="{{ route('site.checkout') }}" method="POST">

                            {{ csrf_field() }}

                                <div class="row">

                                    <!-- Фамилия -->
                                    <div class="col-12 col-xl-6">
                                        <div class="form-group @error('new_mail_surname') is-invalid @enderror">
                                            <input id="new_mail_surname"
                                                   class="w-100"
                                                   type="text"
                                                   name="new_mail_surname"
                                                   required>
                                            <label class="required"
                                                   for="new_mail_surname">{{ __('Surname') }}</label>
                                            @error('new_mail_surname')
                                                <span class="invalid-feedback">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Имя -->
                                    <div class="col-12 col-xl-6">
                                        <div class="form-group @error('new_mail_name') is-invalid @enderror">
                                            <input id="new_mail_name"
                                                   class="w-100"
                                                   type="text"
                                                   name="new_mail_name"
                                                   value=""
                                                   required>
                                            <label class="required" for="new_mail_name">{{ __('Name') }}</label>
                                            @error('new_mail_name')
                                            <span class="invalid-feedback">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Отчество -->
                                    <div class="col-12 col-xl-6">
                                        <div class="form-group @error('new_mail_patronymic') is-invalid @enderror">
                                            <input id="new_mail_patronymic"
                                                   class="w-100"
                                                   type="text"
                                                   name="new_mail_patronymic"
                                                   value=""
                                                   required>
                                            <label class="required"
                                                   for="new_mail_patronymic">{{ __('Patronymic') }}</label>
                                            @error('new_mail_patronymic')
                                                <span class="invalid-feedback">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>



                                    <!-- Номер телефона -->
                                    <div class="col-12 col-xl-6">
                                        <div class="form-group form-group-static @error('new_mail_phone') is-invalid @enderror">
                                            <input id="new_mail_phone"
                                                   class="w-100"
                                                   type="tel"
                                                   name="new_mail_phone"
                                                   pattern="^\+38[\s]\(0\d{2}\)[\s]\d{3}[-]\d{2}[-]\d{2}$"
                                                   placeholder="+38 (0xx) xxx-xx-xx"
                                                   value="+38 &#40;"
                                                   size="19" maxlength="19" required>
                                            <label class="required" for="new_mail_phone">{{ __('Phone number') }} (+38 (0xx) xxx-xx-xx)</label>
                                            @error('new_mail_phone')
                                                <span class="invalid-feedback">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>

                                <div class="row container-delivery-form">

                                    <div class="col-12">
                                        <h4 class="pt-5 text-center font-weight-bold">{{ __('New mail') }}</h4>
                                    </div>


                                    <!-- Тип доставки -->
                                    <div class="col-12">
                                        <div class="form-group form-group-static @error('new_mail_delivery_type') is-invalid @enderror">
                                            <select id="new_mail_delivery_type"
                                                    class=""
                                                    name="new_mail_delivery_type"
                                                    data-placeholder="{{ __('Delivery type') }}"
                                                    style="padding: 4px;">
                                                <option value="storage_storage">{{ __('Delivery to the branch') }}</option>
                                                <option value="storage_door">{{ __('Delivery by address') }}</option>
                                            </select>

                                            <label for="new_mail_delivery_type">{{ __('Delivery type') }}</label>

                                            @error('new_mail_delivery_type')
                                                <span class="invalid-feedback">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Область -->
                                    <div class="col-12">
                                        <div class="form-group form-group-static @error('new_mail_region') is-invalid @enderror">
                                            <select id="new_mail_region"
                                                    class="js-example-basic-single1"
                                                    name="new_mail_region"
                                                    data-placeholder="{{ __('You need to select an region') }}"
                                                    required>
                                                <option value="" selected></option>
                                            </select>

                                            <label for="new_mail_region">{{ __('Region') }}</label>

                                            @error('new_mail_region')
                                                <span class="invalid-feedback">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>

                                    </div>

                                    <!-- Населенный пункт -->
                                    <div class="col-12">
                                        <div class="form-group form-group-static @error('new_mail_city') is-invalid @enderror">
                                            <select id="new_mail_city"
                                                    class="js-example-basic-single"
                                                    name="new_mail_city"
                                                    data-placeholder="{{ __('You need to select an locality') }}"
                                                    required
                                                    disabled>
                                                <option value="" selected></option>
                                            </select>

                                            <label class="font-weight-bold" for="new_mail_city">{{ __('Locality') }}</label>

                                            @error('new_mail_city')
                                                <span class="invalid-feedback">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Номер отделения -->
                                    <div class="col-12">
                                        <div class="form-group form-group-static @error('new_mail_warehouse') is-invalid @enderror">

                                            <select id="new_mail_warehouse"
                                                    name="new_mail_warehouse"
                                                    class="js-example-basic-single"
                                                    data-placeholder="{{ __('You need to choose a branch') }}"
                                                    required
                                                    disabled>
                                                <option value="" selected></option>
                                            </select>

                                            <label for="new_mail_warehouse">{{ __('Branch number') }}</label>

                                            @error('new_mail_warehouse')
                                                <span class="invalid-feedback">
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>
                                    </div>

                                    <!-- Адрес доставки -->
                                    <div class="col-12">
                                        <div class="form-group form-group-static @error('new_mail_street') is-invalid @enderror" hidden>

                                            <select id="new_mail_street"
                                                    name="new_mail_street"
                                                    class="js-example-basic-single"
                                                    data-placeholder="{{ __('You need to choose an address') }}"
                                                    required
                                                    disabled>
                                                <option value="" selected></option>
                                            </select>

                                            <label for="new_mail_street">{{ __('Delivery address') }}</label>
                                            @error('new_mail_street')
                                                <span class="invalid-feedback">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Номер дома -->
                                    <div class="col-12 col-xl-6">
                                        <div class="form-group @error('new_mail_house') is-invalid @enderror" hidden>
                                            <input id="new_mail_house"
                                                   name="new_mail_house"
                                                   class="w-100"
                                                   type="text"
                                                   required
                                                   disabled>
                                            <label for="new_mail_house">{{ __('House number') }}</label>
                                            @error('new_mail_house')
                                                <span class="invalid-feedback">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Квартира -->
                                    <div class="col-12 col-xl-6">
                                        <div class="form-group" hidden>
                                            <input id="new_mail_apartment"
                                                   name="new_mail_apartment"
                                                   class="w-100"
                                                   placeholder="{{ __('Enter apartment number') }}"
                                                   type="text">
                                            <label for="new_mail_apartment">{{ __('Flat') }}</label>
                                        </div>
                                    </div>

                                    <!-- Комментарий к заказу -->
                                    <div class="col-12">
                                        <div class="form-group">
                                            <textarea class="w-100" name="new_mail_comment" id="" cols="30" rows="10"></textarea>
                                            <label for="new_mail_comment">{{ __('Comment on the order') }}</label>
                                        </div>
                                    </div>

                                </div>

                            <div class="col-12">
                                <div class="pt-5 d-flex justify-content-end">
                                    <button class="button" type="submit">{{ __('Checkout') }}</button>
                                </div>

                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </main>

    @section('javascript')
        <script type="text/javascript" src="{{ mix('js/site/page/checkout.js') }}"></script>
    @endsection

@endsection
