@extends('layouts.site')
@section('body_class', 'product')

@section('breadcrumbs')
    @foreach($product->category->ancestors as $ancestor)
        <li><a href="{{ route('site.resource', $ancestor->slug) }}">{{ $ancestor->name }}</a></li>
    @endforeach
    <li><a href="{{ route('site.resource', $product->category->slug) }}">{{ $product->category->name }}</a></li>
    <li class="active">{{ $product->name }}</li>
@endsection

@section('content')

    @include('site.components.breadcrumbs', ['title' => $product->getData('name')])

    <form>
        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
    </form>

    <section class="section-sm bg-white">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-lg-5">

                    <!-- Slick Carousel-->
                    <div class="slick-slider carousel-parent" data-arrows="false" data-loop="false" data-dots="false" data-swipe="true" data-items="1" data-child="#child-carousel" data-for="#child-carousel" data-photo-swipe-gallery="gallery">
                        <div class="item">
                            <a class="img-thumbnail-variant-2"
                                {{-- href="{{ temp_xml_img('https://b2b-sandi.com.ua/imagecache/large/' . strval($product->sku)[0] . '/' . strval($product->sku)[1] . '/' .  $product->sku . '.jpg') }}"--}}
                               href="{{ xml_img(['type' => 'product', 'sku' => $product->sku, 'size' => 1000, 'alt' => $product->name]) }}"
                               data-photo-swipe-item=""
                               data-size="2000x2000">
                                <figure>
                                    <img src="{{ temp_xml_img('https://b2b-sandi.com.ua/imagecache/large/' . strval($product->sku)[0] . '/' . strval($product->sku)[1] . '/' .  $product->sku . '.jpg') }}" alt="" width="535" height="535"/>
                                </figure>
                                <div class="caption"><span class="icon icon-lg linear-icon-magnifier"></span></div></a>
                        </div>

                        @foreach(temp_additional($product->sku) as $uri)

                            <div class="item">
                                <a class="img-thumbnail-variant-2"
                                   href="{{ $uri }}"
                                   data-photo-swipe-item=""
                                   data-size="2000x2000">
                                    <figure>
                                        <img src="{{ $uri }}" alt="" width="535" height="535"/>
                                    </figure>
                                    <div class="caption"><span class="icon icon-lg linear-icon-magnifier"></span></div></a>
                            </div>

                        @endforeach

                    </div>
                    <div class="slick-slider" id="child-carousel" data-for=".carousel-parent" data-arrows="false" data-loop="false" data-dots="false" data-swipe="true" data-items="3" data-xs-items="4" data-sm-items="4" data-md-items="4" data-lg-items="5" data-slide-to-scroll="1">

                        <div class="item">
                            <img src="{{ temp_xml_img('https://b2b-sandi.com.ua/imagecache/large/' . strval($product->sku)[0] . '/' . strval($product->sku)[1] . '/' .  $product->sku . '.jpg') }}" alt="" width="89" height="89"/>
                        </div>

                        @foreach(temp_additional($product->sku) as $uri)

                            <div class="item">

                                <img src="{{ $uri }}" alt="" width="89" height="89"/>

                            </div>

                        @endforeach

                    </div>

                </div>

                <div class="col-sm-12 col-lg-7">
                    <div class="product-single">
                        <h4 class="product-single__title">{{ $product->getData('name') ?? 'PRODUCT NAME' }}</h4>
                        <p class="product-single__sku">Код товара:<span>{{ $product->details['sku'] }}</span></p>
                        <p class="product-single__description">{{ $product->description }}</p>

{{--                        <p class="product-text">--}}
{{--                            @foreach ($product->characteristics as $characteristic)--}}
{{--                                @if ( ( strlen($characteristic->value) > 300) && !empty($characteristic) )--}}
{{--                                    {{ trim($characteristic->value) }}--}}
{{--                                @endif--}}
{{--                            @endforeach--}}
{{--                        </p>--}}

                        <p
                            class="product-price {{ !empty($product->price_updated_at) || $product->price_updated_at->addHours(4)->lt(\Carbon\Carbon::now()) ? 'updatePriceJs' : '' }}"
                            data-product-sku="{{ $product->sku }}"
                        >
                            <span>{{ $product->getDetails('price') }}</span>
                        </p>
                        <div class="mt-5" style="display: flex; align-items: center;">
                            <button class="button button-primary button-icon" data-toggle="modal" data-target="#exampleModal">
                                <span>{{ __('Where buy') }}</span></button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">{{ __('Where buy') }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>{{ __('For all questions call') }} call-center:</p>
                                            <a class="d-block text-center" href="callto:0800210377">0-800-210-377</a>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span class="icon icon-md linear-icon-heart ml-4" data-add="favorite" data-sku="{{$product->getDetails('sku')}}"
                                  style="display: block; height: 100%;font-size: 35px; line-height: 1.5; cursor: pointer"></span>
                        </div>
                        <ul class="product-meta mt-5">

                            <li>
                                <dl class="list-terms-minimal">
                                    <dt>*</dt>
                                    <dd>{{ __('warning') }}</dd>
                                </dl>
                            </li>

{{--                            <li>--}}
{{--                                <dl class="list-terms-minimal">--}}
{{--                                    <dt>SKU</dt>--}}
{{--                                    <dd>{{ $product->details['sku'] }}</dd>--}}
{{--                                </dl>--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                <dl class="list-terms-minimal">--}}
{{--                                    <dt>Category</dt>--}}
{{--                                    <dd>--}}
{{--                                        <ul class="product-categories">--}}
{{--                                            <li><a href="single-product.html">Living Room</a></li>--}}
{{--                                            <li><a href="single-product.html">Dining room</a></li>--}}
{{--                                            <li><a href="single-product.html">Bedroom</a></li>--}}
{{--                                            <li><a href="single-product.html">Office</a></li>--}}
{{--                                        </ul>--}}
{{--                                    </dd>--}}
{{--                                </dl>--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                <dl class="list-terms-minimal">--}}
{{--                                    <dt>Tags</dt>--}}
{{--                                    <dd>--}}
{{--                                        <ul class="product-categories">--}}
{{--                                            <li><a href="single-product.html">Modern</a></li>--}}
{{--                                            <li><a href="single-product.html">Table</a></li>--}}
{{--                                        </ul>--}}
{{--                                    </dd>--}}
{{--                                </dl>--}}
{{--                            </li>--}}
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
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">{{ __('Description') }}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">{{ __('Specifications') }}</a>
                    </li>

                </ul>

                <div class="tab-content" id="myTabContent">

                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                        <p>{{ $product->description }}</p>

                        @foreach(temp_additional($product->sku) as $uri)

                            <div class="col-sm-12 text-center">

                                <img class="img-fluid" src="{{ $uri }}" alt=""/>

                            </div>

                        @endforeach

                    </div>

                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                    <h5>{{ __('Characteristics') }}</h5>

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

        </div>

    </section>

    <!-- Divider-->
    <div class="shell">
        <div class="divider"></div>
    </div>

    @if($product->relateProducts->isNotEmpty())
        @include('site.product.carousel', ['title' => 'Также вас могут заинтересовать'])
    @endif

@endsection
