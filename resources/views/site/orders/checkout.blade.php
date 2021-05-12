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
            <div class="row">

                <div class="col-12">

                    <form>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-6">

                                    <div class="form-group">
                                        <label class="font-weight-bold  required" for="new_mail_surname">Фамилия</label>
                                        <div class="position-relative ">
                                            <input id="new_mail_surname"
                                                   class="w-100"
                                                   type="text"
                                                   name="new_mail_surname"
                                                   value=""
                                                   placeholder="Фамилия" required="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold  required"
                                               for="new_mail_patronymic">Отчество</label>
                                        <div class="position-relative ">
                                            <input id="new_mail_patronymic"
                                                   class="w-100"
                                                   type="text"
                                                   name="new_mail_patronymic"
                                                   value=""
                                                   placeholder="Отчество"
                                                   required>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-6">

                                    <div class="form-group">
                                        <label class="font-weight-bold  required" for="new_mail_name">Имя</label>
                                        <div class="position-relative ">
                                            <input id="new_mail_name"
                                                   class="w-100"
                                                   type="text"
                                                   name="new_mail_name"
                                                   value=""
                                                   placeholder="Имя"
                                                   required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold  required" for="new_mail_phone">Номер телефона
                                            (+38 (0xx) xxx-xx-xx)</label>
                                        <div class="position-relative ">
                                            <input id="new_mail_phone"
                                                   class="w-100"
                                                   type="tel"
                                                   name="new_mail_phone"
                                                   value="+38 ("
                                                   placeholder="+38 (000) 000-00-00"
                                                   required
                                                   pattern="^\+38[\s]\(0\d{2}\)[\s]\d{3}[-]\d{2}[-]\d{2}$"
                                                   size="19" maxlength="19">
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-12">
                                    <h4 class="pt-4 mb-3">Новая почта</h4>
                                </div>

                                <div class="col-12">

                                    <div class="form-group">

                                        <label class="font-weight-bold" for="new_mail_region">Область</label>

                                        <div class="form-group__select">
                                            <select id="new_mail_region" name="new_mail_region"
                                                    class="custom-select select2-hidden-accessible" required=""
                                                    data-placeholder="Нужно выбрать область"
                                                    data-select2-id="new_mail_region" tabindex="-1" aria-hidden="true">
                                                <option selected="" value="" data-select2-id="2"></option>
                                                <option data-alt="АРК" value="71508128-9b87-11de-822f-000c2965ae0e">
                                                    АРК
                                                </option>
                                                <option data-alt="Винницкая"
                                                        value="71508129-9b87-11de-822f-000c2965ae0e">Вінницька
                                                </option>
                                                <option data-alt="Волынская"
                                                        value="7150812a-9b87-11de-822f-000c2965ae0e">Волинська
                                                </option>
                                                <option data-alt="Днепропетровская"
                                                        value="7150812b-9b87-11de-822f-000c2965ae0e">Дніпропетровська
                                                </option>
                                                <option data-alt="Донецкая"
                                                        value="7150812c-9b87-11de-822f-000c2965ae0e">Донецька
                                                </option>
                                                <option data-alt="Житомирская"
                                                        value="7150812d-9b87-11de-822f-000c2965ae0e">Житомирська
                                                </option>
                                                <option data-alt="Закарпатская"
                                                        value="7150812e-9b87-11de-822f-000c2965ae0e">Закарпатська
                                                </option>
                                                <option data-alt="Запорожская"
                                                        value="7150812f-9b87-11de-822f-000c2965ae0e">Запорізька
                                                </option>
                                                <option data-alt="Ивано-Франковская"
                                                        value="71508130-9b87-11de-822f-000c2965ae0e">Івано-Франківська
                                                </option>
                                                <option data-alt="Киевская"
                                                        value="71508131-9b87-11de-822f-000c2965ae0e">Київська
                                                </option>
                                                <option data-alt="Кировоградская"
                                                        value="71508132-9b87-11de-822f-000c2965ae0e">Кіровоградська
                                                </option>
                                                <option data-alt="Луганская"
                                                        value="71508133-9b87-11de-822f-000c2965ae0e">Луганська
                                                </option>
                                                <option data-alt="Львовская"
                                                        value="71508134-9b87-11de-822f-000c2965ae0e">Львівська
                                                </option>
                                                <option data-alt="Николаевская"
                                                        value="71508135-9b87-11de-822f-000c2965ae0e">Миколаївська
                                                </option>
                                                <option data-alt="Одесская"
                                                        value="71508136-9b87-11de-822f-000c2965ae0e">Одеська
                                                </option>
                                                <option data-alt="Полтавская"
                                                        value="71508137-9b87-11de-822f-000c2965ae0e">Полтавська
                                                </option>
                                                <option data-alt="Ровенская"
                                                        value="71508138-9b87-11de-822f-000c2965ae0e">Рівненська
                                                </option>
                                                <option data-alt="Сумская" value="71508139-9b87-11de-822f-000c2965ae0e">
                                                    Сумська
                                                </option>
                                                <option data-alt="Тернопольская"
                                                        value="7150813a-9b87-11de-822f-000c2965ae0e">Тернопільська
                                                </option>
                                                <option data-alt="Харьковская"
                                                        value="7150813b-9b87-11de-822f-000c2965ae0e">Харківська
                                                </option>
                                                <option data-alt="Херсонская"
                                                        value="7150813c-9b87-11de-822f-000c2965ae0e">Херсонська
                                                </option>
                                                <option data-alt="Хмельницкая"
                                                        value="7150813d-9b87-11de-822f-000c2965ae0e">Хмельницька
                                                </option>
                                                <option data-alt="Черкасская"
                                                        value="7150813e-9b87-11de-822f-000c2965ae0e">Черкаська
                                                </option>
                                                <option data-alt="Черновицкая"
                                                        value="7150813f-9b87-11de-822f-000c2965ae0e">Чернівецька
                                                </option>
                                                <option data-alt="Черниговская"
                                                        value="71508140-9b87-11de-822f-000c2965ae0e">Чернігівська
                                                </option>
                                            </select><span class="select2 select2-container select2-container--default"
                                                           dir="ltr" data-select2-id="1" style="width: 100%;"><span
                                                        class="selection"><span
                                                            class="select2-selection select2-selection--single"
                                                            role="combobox" aria-haspopup="true" aria-expanded="false"
                                                            tabindex="0" aria-disabled="false"
                                                            aria-labelledby="select2-new_mail_region-container"><span
                                                                class="select2-selection__rendered"
                                                                id="select2-new_mail_region-container" role="textbox"
                                                                aria-readonly="true"><span
                                                                    class="select2-selection__placeholder">Нужно выбрать область</span></span><span
                                                                class="select2-selection__arrow" role="presentation"><b
                                                                    role="presentation"></b></span></span></span><span
                                                        class="dropdown-wrapper" aria-hidden="true"></span></span>
                                        </div>


                                    </div>

                                    <div class="form-group" data-select2-id="13">

                                        <label class="font-weight-bold" for="new_mail_city">Населенный пункт</label>

                                        <div class="form-group__select" data-select2-id="12">
                                            <select id="new_mail_city" name="new_mail_city"
                                                    class="custom-select select2-hidden-accessible" required=""
                                                    data-placeholder="Нужно выбрать населенный пункт" tabindex="-1"
                                                    aria-hidden="true" data-select2-id="new_mail_city">
                                                <option selected="" value="" data-select2-id="10">Нужно выбрать
                                                    населенный пункт
                                                </option>
                                            </select>
                                            <span class="select2 select2-container select2-container--default select2-container--below"
                                                  dir="ltr" data-select2-id="9" style="width: 100%;">
                                                    <span class="selection">
                                                        <span class="select2-selection select2-selection--single"
                                                              role="combobox" aria-haspopup="true" aria-expanded="false"
                                                              tabindex="0" aria-disabled="false"
                                                              aria-labelledby="select2-new_mail_city-container">
                                                            <span class="select2-selection__rendered"
                                                                  id="select2-new_mail_city-container" role="textbox"
                                                                  aria-readonly="true">
                                                                <span class="select2-selection__placeholder">Нужно выбрать населенный пункт</span>
                                                            </span>
                                                            <span class="select2-selection__arrow" role="presentation">
                                                                <b role="presentation"></b>
                                                            </span>
                                                        </span>
                                                    </span>
                                                    <span class="dropdown-wrapper" aria-hidden="true"></span>
                                                </span>
                                        </div>


                                    </div>


                                    <div class="form-group " data-select2-id="16">
                                        <label class="font-weight-bold" for="new_mail_warehouse">Номер отделения</label>
                                        <div class="form-group__select" data-select2-id="15">
                                            <select id="new_mail_warehouse" name="new_mail_warehouse"
                                                    class="custom-select select2-hidden-accessible" required=""
                                                    data-placeholder="Нужно выбрать отделение"
                                                    data-select2-id="new_mail_warehouse" tabindex="-1"
                                                    aria-hidden="true">
                                                <option selected="" value="" data-select2-id="4">Нужно выбрать
                                                    отделение
                                                </option>
                                            </select><span
                                                    class="select2 select2-container select2-container--default select2-container--above"
                                                    dir="ltr" data-select2-id="3" style="width: 100%;"><span
                                                        class="selection"><span
                                                            class="select2-selection select2-selection--single"
                                                            role="combobox" aria-haspopup="true" aria-expanded="false"
                                                            tabindex="0" aria-disabled="false"
                                                            aria-labelledby="select2-new_mail_warehouse-container"><span
                                                                class="select2-selection__rendered"
                                                                id="select2-new_mail_warehouse-container" role="textbox"
                                                                aria-readonly="true"><span
                                                                    class="select2-selection__placeholder">Нужно выбрать отделение</span></span><span
                                                                class="select2-selection__arrow" role="presentation"><b
                                                                    role="presentation"></b></span></span></span><span
                                                        class="dropdown-wrapper" aria-hidden="true"></span></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold  required" for="new_mail_insurance_sum">Сумма
                                            страховки (мин. 200 грн.)</label>
                                        <div class="position-relative ">
                                            <input id="new_mail_insurance_sum"
                                                   class="w-100"
                                                   type="number"
                                                   name="new_mail_insurance_sum"
                                                   value="200"
                                                   placeholder=""
                                                   required min="200">
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </main>

@endsection