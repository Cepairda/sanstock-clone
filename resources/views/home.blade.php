@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @foreach ($products as $product)
                        {!! img(['type' => 'product', 'class' => ['ab', 'cd', 'fg'], 'sku' => $product->sku, 'size' => 458, 'alt' => $product->sku]) !!}
                    @endforeach
                    <form method="post" action="{{ route('admin.import-image.store') }}">
                        {{ csrf_field() }}
                        {{ method_field('POST') }}
                        <input type="hidden" name="ids[]" value="155" />
                        <input type="hidden" name="ids[]" value="160" />
                        <!--input type="hidden" name="ids[]" value="" /-->
                        <input type="submit" value="Импорт">
                    </form>
                        <form method="post" action="{{ route('admin.products.import-price') }}">
                            {{ csrf_field() }}
                            {{ method_field('POST') }}
                            <input type="hidden" name="sku" value="12667" />
                            <input type="submit" value="Импорт Price">
                        </form>
                        <a href="{{ route('admin.products.export') }}">Экспорт товаров</a>
                        <form method="post" enctype="multipart/form-data" action="{{ route('admin.products.import') }}">
                            {{ csrf_field() }}
                            {{ method_field('POST') }}
                            <input type="file" name="products">
                            <hr>
                            <button class="btn btn-dark legitRipple" type="submit">Загрузить продукты</button>
                            <hr>
                        </form>
                        <a href="{{ route('admin.categories.export') }}">Экспорт категорий</a>
                        <form method="post" enctype="multipart/form-data" action="{{ route('admin.categories.import') }}">
                            {{ csrf_field() }}
                            {{ method_field('POST') }}
                            <input type="file" name="categories">
                            <hr>
                            <button class="btn btn-dark legitRipple" type="submit">Загрузить категории</button>
                            <hr>
                        </form>
                </div>
                <div class="card-body">
                    @php($categories = App\Category::joinLocalization()->with('ancestors')->get()->toTree())
                    <ul>{!! view('site.components.categories', ['categories' => $categories]) !!}</ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
