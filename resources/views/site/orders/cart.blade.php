@extends('layouts.site')
@section('body_class', 'Cart')
@section('meta_title', __('Cart title'))
@section('meta_description',  __('Cart description'))

@section('breadcrumbs')
    @php($i = 2)
    <li class="breadcrumb-item active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
        <span itemprop="name">
           Корзина
        </span>
        <meta itemprop="position" content="{{ $i }}"/>
    </li>
@endsection

@section('content')

    <main class="main-container">

        @include('site.components.breadcrumbs', ['title' => 'Cart', 'h1' => true])

        <div class="container">

            <div class="row">


                <div class="col-12 d-flex justify-content-end">
                    <div class="btn-link-block">
                        <span class="btn-link-block-g" data-toggle="modal" data-target="#exampleModal">Оформить</span>
                    </div>
                </div>

                <div class="col-12">

                    <div class="table-responsive cart__table">
                        <table class="table  table-hover">
                            <caption>Корзина товаров</caption>
                            <thead>
                            <tr>
                                <td>Код товара</td>
                                <td>Фото</td>
                                <td>Наименовае</td>
                                <td>Количество</td>
                                <td>Цена</td>
                                <td>Сумма</td>
                            </tr>
                            </thead>
                            @foreach($orderProducts as $sku => $product):
                            <tbody>
                            <tr>
                                <td>{{ $product["sku"] }}</td>
                                <td><img width="150" src="https://b2b-sandi.com.ua/img/no_img.jpg" alt=""></td>
                                <td>{{ $product["name"] }}</td>
                                {{-- {!! img(['type' => 'product', 'sku' => $product["sku"], 'size' => 70, 'alt' => $product["name"], 'class' => ['lazyload', 'no-src'], 'data-src' => true]) !!} --}}

                                <td>
                                    <input type="text" value="{{ $product["quantity"] }}" readonly>
                                </td>

                                <td data-max="{{ $product['max_quantity'] }}">
                                    {{ $product["price"] }} грн.
                                </td>

                                <td>
                                    {{ $product["quantity"] * $product["price"] }} грн.
                                </td>

                            </tr>
                            </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-end">

                    <div class="btn-link-block">
                        <span class="btn-link-block-g" data-toggle="modal" data-target="#exampleModal">Оформить</span>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Новое сообщение</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

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

                                <div class="col-12">Новая почта</div>

                                <div class="col-12">
                                    <div class="form-group">

                                        <label class="font-weight-bold  required" for="new_mail_insurance_sum">Сумма страховки (мин. 200 грн.)</label>
                                        <div class="position-relative ">

                                            <input id="new_mail_insurance_sum" type="number" name="new_mail_insurance_sum" value="200" placeholder="" class="form-control  " required="" min="200">

                                        </div>


                                    </div>
                                </div>

                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-primary">Отправить сообщение</button>
                </div>
            </div>
        </div>
    </div>


    {{-- dd($areas) --}}


@endsection
