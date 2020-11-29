@extends('layouts.site')
@section('body_class', 'product')
@section('content')

    @include('site.components.breadcrumbs')
  
    {{-- dd($product) --}}

    <section class="section-sm bg-white">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-5">
                    <!-- Slick Carousel-->
                    <div class="slick-slider carousel-parent" data-arrows="false" data-loop="false" data-dots="false" data-swipe="true" data-items="1" data-child="#child-carousel" data-for="#child-carousel" data-photo-swipe-gallery="gallery">
                        <div class="item">
                            <a class="img-thumbnail-variant-2"
                               href="{{ asset('images/site/21689.jpg') }}"
                               data-photo-swipe-item=""
                               data-size="2000x2000">
                                <figure>
                                    <img src="{{ asset('images/site/21689.jpg') }}" alt="" width="535" height="535"/>
                                </figure>
                                <div class="caption"><span class="icon icon-lg linear-icon-magnifier"></span></div></a>
                        </div>
                        <div class="item">
                            <a class="img-thumbnail-variant-2"
                               href="{{ asset('images/site/21689.jpg') }}"
                               data-photo-swipe-item=""
                               data-size="2000x2000">
                                <figure>
                                    <img src="{{ asset('images/site/21689_1.jpg') }}" alt="" width="535" height="535"/>
                                </figure>
                                <div class="caption"><span class="icon icon-lg linear-icon-magnifier"></span></div></a>
                        </div>
                    </div>
                    <div class="slick-slider" id="child-carousel" data-for=".carousel-parent" data-arrows="false" data-loop="false" data-dots="false" data-swipe="true" data-items="3" data-xs-items="4" data-sm-items="4" data-md-items="4" data-lg-items="5" data-slide-to-scroll="1">
                        <div class="item"><img src="{{ asset('images/site/21689.jpg') }}" alt="" width="89" height="89"/>
                        </div>
                        <div class="item"><img src="{{ asset('images/site/21689_1.jpg') }}" alt="" width="89" height="89"/>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-7">
                    <div class="product-single">
                        <h4>{{ $product->getData('name') ?? 'Lorem ipsum dolor sit amet.' }}</h4>
                        <p class="product-code"><span>Код товара:</span>9615</p>   
                        <p class="product-text">Смесителя Lidz изготовлены из нержавеющей стали. Благодаря никелированной брашированной поверхности имеют оригинальный внешний вид. Выполнены в современном сдержанном стиле. Такие смесителф не только удобны и практичны, но и идеально дополнит интерьер.</p>
                        <p class="product-price"><span>{{ $product->getDetails('price') }}</span></p>
                        <div class="mt-5" style="display: flex; align-items: center;">
                            <button class="button button-primary button-icon" type="submit"><span>{{ __('Where buy') }}</span></button>
                            <span class="icon icon-md linear-icon-heart ml-4" data-toggle="tooltip" data-original-title="Add to Wishlist" style="display: block; height: 100%;font-size: 35px; line-height: 1.5; cursor: pointer"></span>
                        </div>
                        <ul class="product-meta mt-5">
                            <li>
                                <dl class="list-terms-minimal">
                                    <dt>SKU</dt>
                                    <dd>256</dd>
                                </dl>
                            </li>
                            <li>
                                <dl class="list-terms-minimal">
                                    <dt>Category</dt>
                                    <dd>
                                        <ul class="product-categories">
                                            <li><a href="single-product.html">Living Room</a></li>
                                            <li><a href="single-product.html">Dining room</a></li>
                                            <li><a href="single-product.html">Bedroom</a></li>
                                            <li><a href="single-product.html">Office</a></li>
                                        </ul>
                                    </dd>
                                </dl>
                            </li>
                            <li>
                                <dl class="list-terms-minimal">
                                    <dt>Tags</dt>
                                    <dd>
                                        <ul class="product-categories">
                                            <li><a href="single-product.html">Modern</a></li>
                                            <li><a href="single-product.html">Table</a></li>
                                        </ul>
                                    </dd>
                                </dl>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="section-sm bg-white">
        <div class="container">
          <div class="row">
            <div class="col-12">
                <!-- Bootstrap tabs-->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Описание</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Характеристики</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">Lorem ipsum dolor sit amet.</div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <h5>Additional Information</h5>
                        <table class="table-product-info">
                            <tbody>
                            @foreach ($product->characteristics as $characteristic)
                                    <tr>
                                        <td>{{ $characteristic->name }}</td>
                                        <td>{{ $characteristic->value }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <!-- Divider-->
    <div class="shell">
        <div class="divider"></div>
    </div>

    {{-- @include('site.product.carousel', ['title' => 'Также вас могут заинтересовать']) --}}

@endsection
