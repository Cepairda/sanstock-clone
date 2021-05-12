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

                        <h1 class="">Оформити</h1>

                    </div>

                </div>

                <div class="col-8">
                    <div class="main__contacts-form">

                        <form action="">

                                <div class="row">

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

                                <div class="row">

                                    <div class="col-12">
                                        <h4 class="pt-5 text-center font-weight-bold">Новая почта</h4>
                                    </div>

                                    <div class="col-12">

                                        <div class="form-group form-group-static">

                                            <select class="js-example-basic-single"
                                                    name="new_mail_region"
                                                    data-placeholder="Нужно выбрать область"
                                                    required>
                                                <option value=""></option>
                                                <option value="AL">Alabama</option>
                                                <option value="WY">Wyoming</option>
                                            </select>

                                            <label for="new_mail_region">Область</label>

                                        </div>

                                    </div>

                                    <div class="col-12">

                                        <div class="form-group form-group-static">


                                            <select class="js-example-basic-single"
                                                    name="new_mail_city"
                                                    data-placeholder="Нужно выбрать населенный пункт"
                                                    required>
                                                <option value=""></option>
                                                <option value="AL">test-1</option>
                                                <option value="WY">test-2</option>
                                            </select>

                                            <label class="font-weight-bold" for="new_mail_city">Населенный пункт</label>

                                        </div>

                                    </div>

                                    <div class="col-12">

                                        <div class="form-group form-group-static">

                                            <select id="new_mail_warehouse"
                                                    name="new_mail_warehouse"
                                                    class="js-example-basic-single"
                                                    data-placeholder="Нужно выбрать отделение"
                                                    required>
                                                <option value="AL">test-1</option>
                                                <option value="WY">test-2</option>
                                            </select>

                                            <label for="new_mail_warehouse">Номер отделения</label>
                                        </div>

                                    </div>

                                    <div class="col-6">

                                        <div class="form-group form-group-static">

                                            <select class=""
                                                    name="new_mail_region"
                                                    data-placeholder="Наложенный платеж"
                                                    required>
                                                <option value="Да">Да</option>
                                                <option value="Нет">Нет</option>
                                            </select>

                                            <label for="new_mail_region">Наложенный платеж</label>

                                        </div>

                                    </div>

                                    <div class="col-6">

                                        <div class="form-group">

                                            <input id="new_mail_name"
                                                   class="w-100"
                                                   type="text"
                                                   name="new_mail_payment_sum"
                                                   value=""
                                                   required>
                                            <label class="required" for="new_mail_payment_sum">Сумма</label>

                                        </div>

                                    </div>

                                    <div class="col-12">

                                        <div class="d-flex justify-content-center pt-4">
                                            <div class="custom-control custom-checkbox">
                                                <input id="new_mail_non_cash_payment" type="checkbox"
                                                       name="new_mail_non_cash_payment" value="1" placeholder=""
                                                       class="custom-control-input  " data-delivery="new_mail"
                                                       data-checkbox="cash">
                                                <label class="custom-control-label" for="new_mail_non_cash_payment">Безналичный
                                                    способ оплаты</label>
                                            </div>
                                            <div class="ml-2">
                                                <style>
                                                    .text-line-through {
                                                        text-decoration: line-through;
                                                    }
                                                </style>
                                                (<span class="text-line-through"
                                                       data-name="new_mail-cash">98.53 UAH</span>
                                                | <span class="text-danger"
                                                        data-name="new_mail-cashless">108.38 UAH</span>)
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-12">

                                        <div class="new_mail-сompany-data my-3">
                                            <h4 class="mb-3">Данные фирмы</h4>
                                            <div class="form-group">
                                                <input id="new_mail_company_name" type="text" name="new_mail_company_name" class="form-control" required>
                                                <label for="new_mail_company_name">Наименование фирмы (на которую необходимо выставить счет)</label>
                                            </div>
                                            <div class="form-group">
                                                <input id="new_mail_company_email" type="email" name="new_mail_company_email" class="form-control" required>
                                                <label for="new_mail_company_email">Электронный адрес фирмы</label>
                                            </div>
                                            <div class="form-group">
                                                <input id="new_mail_company_user_surname" type="text" name="new_mail_company_user_surname" class="form-control" required>
                                                <label for="new_mail_company_user_surname">Фамилия контактного лица</label>
                                            </div>
                                            <div class="form-group">
                                                <input id="new_mail_company_user_name" type="text" name="new_mail_company_user_name" class="form-control" required>
                                                <label for="new_mail_company_user_name">Имя контактного лица</label>
                                            </div>
                                            <div class="form-group">
                                                <input id="new_mail_company_user_patronymic" type="text" name="new_mail_company_user_patronymic" class="form-control" required>
                                                <label for="new_mail_company_user_patronymic">Отчество контактного лица</label>
                                            </div>
                                            <div class="form-group">
                                                <input id="new_mail_company_phone" type="text" name="new_mail_company_phone" class="form-control" required>
                                                <label for="new_mail_company_phone">Телефон контактного лица</label>
                                            </div>
                                            <div class="form-group">
                                                <input id="new_mail_company_address" type="text" name="new_mail_company_address" class="form-control" required>
                                                <label for="new_mail_company_address">Адрес для корреспонденции (для отправки оригиналов документов)</label>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-12">

                                        <div class="form-group">

                                            <input id="new_mail_insurance_sum"
                                                   class="w-100"
                                                   type="number"
                                                   name="new_mail_insurance_sum"
                                                   value="200"
                                                   placeholder=""
                                                   min="200"
                                                   required>
                                            <label class="required" for="new_mail_insurance_sum">Сумма
                                                страховки (мин. 200 грн.)</label>
                                        </div>

                                    </div>

                                </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </main>

    @section('javascript')
    @endsection


@endsection