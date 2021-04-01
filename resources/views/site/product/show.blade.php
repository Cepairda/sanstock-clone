@extends('layouts.site')
@section('body_class', 'product')
@section('meta_title', $product->meta_title)
@section('meta_description', $product->meta_description)

@section('breadcrumbs')
    @php($i = 2)
    @if (isset($product->category))
        @foreach($product->category->ancestors as $ancestor)
            <li itemprop="itemListElement"
                itemscope itemtype="https://schema.org/ListItem"
            >
                <a href="{{ route('site.resource', $ancestor->slug) }}" itemprop="item">
                    <span itemprop="name">
                        {{ $ancestor->name }}
                    </span>
                </a>
                <meta itemprop="position" content="{{ $i }}" />
            </li>
            @php($i++)
        @endforeach
        <li itemprop="itemListElement"
            itemscope itemtype="https://schema.org/ListItem"
        >
            <a href="{{ route('site.resource', $product->category->slug) }}" itemprop="item">
                <span itemprop="name">
                     {{ $product->category->name }}
                </span>
            </a>
            <meta itemprop="position" content="{{ $i++ }}" />
        </li>
    @endif
    <li class="active"
        itemprop="itemListElement"
        itemscope itemtype="https://schema.org/ListItem"
    >
        <span itemprop="name">
            {{ $product->name }}
        </span>
        <meta itemprop="position" content="{{ $i }}" />
    </li>
@endsection

@section('jsonld')
    {!! $product->getJsonLd() !!}
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
                    <div class="slick-slider carousel-parent"
                         data-child="#child-carousel"
                         data-for="#child-carousel"
                         data-toggle="modal"
                         data-target="#modal-product">
                            <a class="img-thumbnail-variant-2" data-target="#carouselExample" data-slide-to="{{ $j = 0 }}" href="#">
                                  {!! img(['type' => 'product', 'sku' => $product->sku, 'size' => 600, 'alt' => $product->name, 'class' => ['lazyload', 'no-src'], 'data-src' => true]) !!}
                            <div class="caption"><span class="icon icon-lg linear-icon-magnifier"></span></div>
                            </a>
                        @foreach($additional as $key => $uri)

                                <a class="img-thumbnail-variant-2" href="" data-target="#carouselExample" data-slide-to="{{ ++$j }}">

                                        <!--img data-src="" class="lazyload no-src" alt="" width="535" height="535"/-->
                                    {!! img([
                                                'type' => 'product',
                                                'sku' => $product->sku,
                                                'size' => 600,
                                                'alt' => $product->name,
                                                'class' => ['lazyload', 'no-src'],
                                                'data-src' => true,
                                                'additional' => true,
                                                'key' => $key
                                            ])
                                    !!}

                                    <div class="caption"><span class="icon icon-lg linear-icon-magnifier"></span></div>
                                </a>

                        @endforeach

                    </div>
                    <div class="slick-slider"
                         id="child-carousel"
                         data-for=".carousel-parent" {{-- Селектор на большую картинку --}}
                         data-arrows="true"          {{-- Стрелки --}}
                         data-loop="false"           {{-- Бесконечный цикл скольжения --}}
                         data-dots="false"           {{-- Точечные индикаторы --}}
                         data-swipe="true"           {{-- Cмахивания / перетаскивания --}}
                         data-center-mode="false"    {{-- Центрирование активного слайда--}}
                         data-items="2"              {{-- Кол-во кратинок в слайдере --}}
                         data-xs-items="2"
                         data-sm-items="3"
                         data-md-items="3"
                         data-lg-items="4"
                         data-slide-to-scroll="1">
                        <div class="item">
                            {!! img(['type' => 'product', 'sku' => $product->sku, 'size' => 150, 'alt' => $product->name, 'class' => ['lazyload', 'no-src'], 'data-src' => true]) !!}
                        </div>

                        @foreach($additional as $key => $uri)

                            <div class="item">

                                <!--img data-src="" class="lazyload no-src" alt="" width="535" height="535"/-->
                                {!! img([
                                            'type' => 'product',
                                            'sku' => $product->sku,
                                            'size' => 150,
                                            'alt' => $product->name,
                                            'class' => ['lazyload', 'no-src'],
                                            'data-src' => true,
                                            'additional' => true,
                                            'key' => $key
                                        ])
                                !!}

                            </div>

                        @endforeach

                    </div>

                </div>

                <div class="col-sm-12 col-lg-7">
                    <div class="product-single">
                        <h4 class="product-single__title">{{ $product->getData('name') ?? 'PRODUCT NAME' }}</h4>
                        <p class="product-single__sku">Код товара:<span>{{ $product->details['sku'] }}</span></p>
                        <p class="product-single__description">{{ $product->description }}</p>
                        <p class="product-price {{ (empty($product->price_updated_at) || $product->price_updated_at->addHours(4)->lt(\Carbon\Carbon::now())) ? 'updatePriceJs' : '' }}"
                           data-product-sku="{{ $product->sku }}">

                            <span>{{ number_format(ceil($product->getDetails('price')),0,'',' ') }}</span>

                            @if ($product->oldPrice)
                                <span class="ml-3">{{ number_format(ceil($product->oldPrice),0,'',' ') }}</span>
                            @endif

                        </p>
                        <div class="mt-5" style="display: flex; align-items: center;">
                            <button class="button button-primary button-icon" data-toggle="modal" data-target="#partnersModal">
                                <span>{{ __('Where buy') }}</span></button>

                            @include('site.product.components.partners')
                            <!-- Modal -->
{{--                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">--}}
{{--                                <div class="modal-dialog" role="document">--}}
{{--                                    <div class="modal-content">--}}
{{--                                        <div class="modal-header">--}}
{{--                                            <h5 class="modal-title" id="exampleModalLabel">{{ __('Where buy') }}</h5>--}}
{{--                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                                                <span aria-hidden="true">&times;</span>--}}
{{--                                            </button>--}}
{{--                                        </div>--}}
{{--                                        <div class="modal-body text-center">--}}
{{--                                            <p>{{ __('For all questions call') }}</p>--}}
{{--                                            <p >Call-Center: <a href="callto:0800210377">0-800-210-377</a></p>--}}
{{--                                        </div>--}}
{{--                                        <div class="modal-footer">--}}
{{--                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
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

                        @foreach($additional as $key => $uri)

                            <div class="col-sm-12 text-center">

                                <!--img data-src="" class="lazyload no-src" alt="" width="535" height="535"/-->
                                {!! img([
                                            'type' => 'product',
                                            'sku' => $product->sku,
                                            'size' => 600,
                                            'alt' => $product->name,
                                            'class' => ['lazyload', 'no-src', 'img-fluid'],
                                            'data-src' => true,
                                            'additional' => true,
                                            'key' => $key
                                        ])
                                !!}

                            </div>

                        @endforeach

                    </div>

                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                    <h5>{{ __('Characteristics') }}</h5>

                    <table class="table-product-info">
                            <tbody>
                                @foreach ($product->characteristics as $characteristic)
                                    @if ($characteristic->characteristic->published)
                                        <tr>
                                            <td>{{ $characteristic->name }}</td>
                                            <td>{{ $characteristic->value }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                        </table>

                    </div>

                </div>

                </div>

            </div>

        </div>

    </section>

    <section class="section-sm bg-white">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @php($enableComment = (config('settings.comments.' . $product->type . '.enable') && $product->getDetails('enable_comments')))
                    @php($enableReview = (config('settings.reviews.' . $product->type . '.enable') && $product->getDetails('enable_reviews')))

                    @if ($enableComment || $enableReview)
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            @if ($enableComment)
                                <li class="nav-item">
                                    <a class="nav-link active" id="comment-tab" data-toggle="tab" href="#comment" role="tab" aria-controls="comment" aria-selected="true">{{ __('Comments') }}</a>
                                </li>
                            @endif
                            @if ($enableReview)
                                <li class="nav-item">
                                    <a class="nav-link {{ !$enableComment ? 'active' : '' }}" id="review-tab" data-toggle="tab" href="#review" role="tab" aria-controls="review" aria-selected="false">{{ __('Reviews') }}</a>
                                </li>
                            @endif
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            @if ($enableComment)
                            <div class="tab-pane fade show active" id="comment" role="tabpanel" aria-labelledby="comment-tab">

                                <h4>{{ __('Comments') }}</h4>

                                @include('site.components.comments', ['comments' => $product->comments, 'resourceId' => $product->id, 'type' => 1])

                                <hr />
                                <h4>{{ __('Add comment') }}</h4>
                                <form method="post" enctype="multipart/form-data" action="{{ route('site.comments.store') }}">
                                    @csrf

                                    @if ((config('settings.comments.' . $product->type . '.stars')) && $product->getDetails('enable_stars_comments'))
                                        <div class="form-group mb-2">
                                            <div class="rating">
                                                <input type="radio" name="details[star]" id="product-comment-5" value="5"/>
                                                <label class="rating-label star" for="product-comment-5"></label>
                                                <input type="radio" name="details[star]" id="product-comment-4" value="4"/>
                                                <label class="rating-label star" for="product-comment-4"></label>
                                                <input type="radio" name="details[star]" id="product-comment-3" value="3"/>
                                                <label class="rating-label star" for="product-comment-3"></label>
                                                <input type="radio" name="details[star]" id="product-comment-2" value="2"/>
                                                <label class="rating-label star" for="product-comment-2"></label>
                                                <input type="radio" name="details[star]" id="product-comment-1" value="1"/>
                                                <label class="rating-label star" for="product-comment-1"></label>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="form-group mb-2">
                                        <input type="text" name="details[name]" class="form-control" required="required" placeholder="{{ __('Name') }}" />
                                    </div>
                                    <div class="form-group mb-2">
                                        <input type="email" name="details[email]" class="form-control email-comment" required="required" placeholder="Email" />
                                    </div>
                                    <div class="form-group mb-2">
                                        <input type="tel" name="details[phone]" class="form-control phone-comment" required="required" placeholder="{{ __('Phone') }}" />
                                    </div>
                                    <div class="form-group mb-2">

                                    </div>
                                    @if (config('settings.comments.files.enable'))
                                        <div class="form-group mb-2">
                                            <input type="file" name="attachment[]" class="filer_input" data-jfiler-limit="{{ config('settings.comments.files.count') ?? 5 }}" data-jfiler-fileMaxSize="{{ config('settings.comments.files.size') ?? 1 }}" multiple="multiple" data-jfiler-options='{"language": "{{ LaravelLocalization::getCurrentLocale() }}"}'>
                                        </div>
                                    @endif
                                    <input type="hidden" name="details[resource_id]" value="{{ $product->id }}" />
                                    <input type="hidden" name="details[type]" value="1" />
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-success" value="{{ __('Add comment') }}" />
                                    </div>
                                </form>

                            </div>
                            @endif
                            @if ($enableReview)
                            <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">

                                <h4>{{ __('Reviews') }}</h4>

                                @include('site.components.comments', ['comments' => $product->reviews, 'resourceId' => $product->id, 'type' => 2])

                                <hr />
                                <h4>{{ __('Add review') }}</h4>
                                <form method="post" enctype="multipart/form-data" action="{{ route('site.comments.store') }}">
                                    @csrf

                                    @if ((config('settings.reviews.' . $product->type . '.stars')) && $product->getDetails('enable_stars_reviews'))
                                        <div class="form-group mb-2">
                                            <div class="rating">
                                                <input type="radio" name="details[star]" id="product-review-5" value="5"/>
                                                <label class="rating-label star" for="product-review-5"></label>
                                                <input type="radio" name="details[star]" id="product-review-4" value="4"/>
                                                <label class="rating-label star" for="product-review-4"></label>
                                                <input type="radio" name="details[star]" id="product-review-3" value="3"/>
                                                <label class="rating-label star" for="product-review-3"></label>
                                                <input type="radio" name="details[star]" id="product-review-2" value="2"/>
                                                <label class="rating-label star" for="product-review-2"></label>
                                                <input type="radio" name="details[star]" id="product-review-1" value="1"/>
                                                <label class="rating-label star" for="product-review-1"></label>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="form-group mb-2">
                                        <input type="text" name="details[name]" class="form-control" required="required" placeholder="{{ __('Name') }}" />
                                    </div>
                                    <div class="form-group mb-2">
                                        <input type="email" name="details[email]" class="form-control email-comment" required="required" placeholder="Email" />
                                    </div>
                                    <div class="form-group mb-2">
                                        <input type="tel" name="details[phone]" class="form-control phone-comment" required="required" placeholder="{{ __('Phone') }}" />
                                    </div>
                                    <div class="form-group mb-2">

                                    </div>
                                    @if (config('settings.comments.files.enable'))
                                        <div class="form-group mb-2">
                                            <input type="file" name="attachment[]" class="filer_input" data-jfiler-limit="{{ config('settings.comments.files.count') ?? 5 }}" data-jfiler-fileMaxSize="{{ config('settings.comments.files.size') ?? 1 }}" multiple="multiple" data-jfiler-options='{"language": "{{ LaravelLocalization::getCurrentLocale() }}"}'>
                                        </div>
                                    @endif
                                    <input type="hidden" name="details[resource_id]" value="{{ $product->id }}" />
                                    <input type="hidden" name="details[type]" value="2" />
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-success" value="{{ __('Add review') }}" />
                                    </div>
                                </form>

                            </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- Карусель --}}
    <div class="modal modal-product fade show" id="modal-product" tabindex="-1" role="dialog" aria-hidden="true">

        <div class="modal-dialog modal-product__container" role="document">
            <div class="modal-content h-100">

                <div class="modal-header">
                    <div class="modal-product__title" id="carouselModalLabel">{{ $product->getData('name') }}</div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body d-flex flex-column">

                    {{-- Carousel markup: https://getbootstrap.com/docs/4.4/components/carousel/ --}}
                    <div id="carouselExample" class="carousel slide" data-ride="carousel" data-pause="hover">

                        <ol class="carousel-indicators">

                            <li class="active" data-target="#carouselExample" data-slide-to="0"></li>

                            @for ($c = 1; $c <= $j; $c++)
                                <li data-target="#carouselExample" data-slide-to="{{ $c }}"></li>
                            @endfor

                        </ol>

                        <div class="carousel-inner">

                            <div class="carousel-item active">
                              {!! img(['type' => 'product', 'sku' => $product->sku, 'size' => 600, 'alt' => $product->name, 'class' => ['lazyload', 'no-src', 'image', 'imageZoom'], 'data-src' => true]) !!}
                            </div>

                            @foreach($additional as $key => $uri)

                                <div id="" class="carousel-item height">
                                    <!--img data-src="" class="lazyload no-src" alt="" width="535" height="535"/-->
                                    {!! img([
                                                'type' => 'product',
                                                'sku' => $product->sku,
                                                'size' => 600,
                                                'alt' => $product->name,
                                                'class' => ['lazyload', 'no-src', 'image', 'imageZoom'],
                                                'data-src' => true,
                                                'additional' => true,
                                                'key' => $key
                                            ])
                                    !!}
                                </div>

                            @endforeach
                        </div>

                        <a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>

                        <a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>

                    </div>
                    <div class="modal-product__price">

                        <div class="product-price text-center updatePriceJs"
                            data-product-sku="{{ $product->sku }}">

                            <span>{{ number_format(ceil($product->getDetails('price')),0,'',' ') }}</span>

                            @if ($product->oldPrice)
                                <span class="ml-3">{{ number_format(ceil($product->oldPrice),0,'',' ') }}</span>
                            @endif

                        </div>
                        <button class="button button-primary button-icon" id="closeCarousel" {{--data-toggle="modal" data-target="#exampleModal"--}}>
                            <span>{{ __('Where buy') }}</span>
                        </button>

                        <div style="display: flex; align-items: center;">
                            <span class="icon icon-md linear-icon-heart ml-4"
                                  data-add="favorite"
                                  data-sku="{{$product->getDetails('sku')}}"
                                  style="display: block; height: 100%;font-size: 35px; line-height: 1.5; cursor: pointer"></span>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
    {{-- Карусель --}}


    <!-- Divider-->
    <div class="shell">
        <div class="divider"></div>
    </div>
    @if($product->relateProducts->isNotEmpty())
        @include('site.product.carousel', ['title' => __('You may also be interested in')])
    @endif

@endsection
