@extends('layouts.site')
@section('body_class', 'favorites')

@section('breadcrumbs')
    <li class="active">Избранное</li>
@endsection

@section('content')

    @include('site.components.breadcrumbs', ['title' => 'Избранное'])

    <section class="section-sm">

        <div class="container">
            <div class="row">
                @foreach($products as $product)
                    <div class="col-3 mt-5">
                        @include('site.components.product')
                    </div>
                @endforeach
            </div>
        </div>

    </section>

@endsection