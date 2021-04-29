<section class="home-new-products section-lg">
    <div class="container">
        <div class="row">
            <h4 class="col-12 text-center mb-5">{{ $title }}</h4>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="owl-carousel carousel-product" data-items="1" data-sm-items="2" data-md-items="3" data-lg-items="4" data-stage-padding="0" data-loop="false" data-margin="50" data-mouse-drag="false" data-nav="true">
            @foreach($product->relateProducts as $product)
                <div class="">
                    @include('site.components.product')
                </div>
            @endforeach
            </div>
        </div>
    </div>
</section>
