@foreach($products as $product)
    <div class="cell-sm-6 cell-lg-4">
        @include('site.components.product')
    </div>
@endforeach
