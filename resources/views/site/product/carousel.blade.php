<section class="home-new-products section-lg">
    <div class="container">
        <div class="row">
            <h4 class="col-12 text-center mb-5">{{ $title }}</h4>
            @foreach($product->relateProducts as $product)
                <div class="col-sm-6 col-lg-3">
                    @include('site.components.product')
                </div>
            @endforeach
        </div>
    </div>
</section>
