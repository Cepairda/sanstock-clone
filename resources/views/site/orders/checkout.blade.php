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

                        <h1 class="">Оформлення</h1>

                    </div>

                </div>

                <div class="col-8">
                    <div class="main__contacts-form">

                        <form action="">

                                <div class="row">

                                    <!-- Фамилия -->
                                    <div class="col-6">

                                        <div class="form-group">
                                            <input id="new_mail_surname"
                                                   class="w-100"
                                                   type="text"
                                                   name="new_mail_surname"
                                                   required>
                                            <label class="required"
                                                   for="new_mail_surname">Фамилия</label>
                                        </div>

                                    </div>

                                    <!-- Отчество -->
                                    <div class="col-6">
                                        <div class="form-group">
                                            <input id="new_mail_patronymic"
                                                   class="w-100"
                                                   type="text"
                                                   name="new_mail_patronymic"
                                                   value=""
                                                   required>
                                            <label class="required"
                                                   for="new_mail_patronymic">Отчество</label>
                                        </div>
                                    </div>

                                    <!-- Имя -->
                                    <div class="col-6">

                                        <div class="form-group">
                                            <input id="new_mail_name"
                                                   class="w-100"
                                                   type="text"
                                                   name="new_mail_name"
                                                   value=""
                                                   required>
                                            <label class="required" for="new_mail_name">Имя</label>
                                        </div>

                                    </div>

                                    <!-- Номер телефона -->
                                    <div class="col-6">
                                        <div class="form-group">
                                            <input id="new_mail_phone"
                                                   class="w-100"
                                                   type="tel"
                                                   name="new_mail_phone"
                                                   required
                                                   pattern="^\+38[\s]\(0\d{2}\)[\s]\d{3}[-]\d{2}[-]\d{2}$"
                                                   size="19" maxlength="19">
                                            <label class="required" for="new_mail_phone">Номер телефона (+38 (0xx) xxx-xx-xx)</label>
                                        </div>
                                    </div>

                                </div>

                                <div class="row container-delivery-form">

                                    <div class="col-12">
                                        <h4 class="pt-5 text-center font-weight-bold">Новая почта</h4>
                                    </div>


                                    <!-- Тип доставки -->
                                    <div class="col-12">
                                        <div class="form-group form-group-static">

                                            <select id="new_mail_delivery_type"
                                                    class=""
                                                    name="new_mail_delivery_type"
                                                    data-placeholder="Тип доставки"
                                                    required>
                                                <option value="storage_storage">Доставка на отделение</option>
                                                <option value="storage_door">Доставка за адресом</option>
                                            </select>

                                            <label for="new_mail_delivery_type">Тип доставки</label>

                                        </div>
                                    </div>

                                    <!-- Область -->
                                    <div class="col-12">

                                        <div class="form-group form-group-static">

                                            <select id="new_mail_region"
                                                    class="js-example-basic-single1"
                                                    name="new_mail_region"
                                                    data-placeholder="Нужно выбрать область"
                                                    required>
                                                <option value=""></option>
                                            </select>

                                            <label for="new_mail_region">Область</label>

                                        </div>

                                    </div>

                                    <!-- Населенный пункт -->
                                    <div class="col-12">

                                        <div class="form-group form-group-static">


                                            <select id="new_mail_city"
                                                    class="js-example-basic-single"
                                                    name="new_mail_city"
                                                    data-placeholder="Нужно выбрать населенный пункт"
                                                    disabled
                                                    required>
                                            </select>

                                            <label class="font-weight-bold" for="new_mail_city">Населенный пункт</label>

                                        </div>

                                    </div>

                                    <!-- Номер отделения -->
                                    <div class="col-12">

                                        <div class="form-group form-group-static">

                                            <select id="new_mail_warehouse"
                                                    name="new_mail_warehouse"
                                                    class="js-example-basic-single"
                                                    data-placeholder="Нужно выбрать отделение"
                                                    disabled
                                                    required>
                                            </select>

                                            <label for="new_mail_warehouse">Номер отделения</label>

                                        </div>

                                    </div>

                                    <!-- Адрес доставки -->
                                    <div class="col-12">

                                        <div class="form-group form-group-static">

                                            <select id="new_mail_street"
                                                    name="new_mail_street"
                                                    class="js-example-basic-single"
                                                    data-placeholder="Нужно выбрать адрес"
                                                    disabled
                                                    required>
                                            </select>

                                            <label for="new_mail_street">Адрес доставки</label>

                                        </div>

                                    </div>

                                    <!-- Номер дома -->
                                    <div class="col-6">
                                        <div class="form-group">
                                            <input id="new_mail_house"
                                                   name="new_mail_house"
                                                   class="w-100"
                                                   type="text"
                                                   required>

                                            <label for="new_mail_house">Номер дома</label>
                                        </div>
                                    </div>

                                    <!-- Квартира -->
                                    <div class="col-6">

                                        <div class="form-group">
                                            <input id="new_mail_apartment"
                                                   name="new_mail_apartment"
                                                   class="w-100"
                                                   type="text">
                                            <label for="new_mail_apartment">Квартира</label>
                                        </div>

                                    </div>

                                    <!-- Комментарий к заказу -->
                                    <div class="col-12">

                                        <div class="form-group">
                                            <textarea class="w-100" name="" id="" cols="30" rows="10" required></textarea>
                                            <label for="new_mail_apartment">Комментарий к заказу</label>
                                        </div>

                                    </div>

                                </div>

                            <div class="col-12">
                                <div class="pt-5 d-flex justify-content-end">
                                    <button class="button" type="submit">Оформить</button>
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