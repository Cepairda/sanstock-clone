@extends('layouts.site')
@section('body_class', 'documents')
@section('content')

    @include('site.components.breadcrumbs')
    
    <section class="section-md">
        <div class="container">
            <div class="row">
                <h2 class="col-12 text-center" style="padding-bottom: 70px">Документация</h2>
                <div class="col-4 text-center">
                    <a href="#">
                        <img src="" alt="">
                        <span>Общий каталог продукции</span>
                    </a>
                </div>
                <div class="col-4 text-center">
                    <a href="#">
                        <img src="" alt="">
                        <span>Гарантийный талон</span>
                    </a></div>
                <div class="col-4 text-center">
                    <a href="#">
                        <img src="" alt="">
                        <span>Сертефикаты</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
    
@endsection