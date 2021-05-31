<section class="pt-3">

    <div class="container">
        <div class="row">

            <div class="col-12">

                @php
                    $slides = [

                        ['link' => 'images/site/home-slider/slide-1.png', 'title' => 'Lorem.', 'sub_title' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est, pariatur.'],
                        ['link' => 'images/site/home-slider/slide-2.png', 'title' => 'Lorem ipsum dolor sit.', 'sub_title' => 'Lorem ipsum dolor sit amet.'],
                        ['link' => 'images/site/home-slider/slide-3.png', 'title' => 'Lorem ipsum dolor sit.', 'sub_title' => 'Lorem ipsum dolor sit amet.'],
                        ['link' => 'images/site/home-slider/slide-4.png', 'title' => 'Lorem ipsum dolor sit.', 'sub_title' => 'Lorem ipsum dolor sit amet.'],
                    ];
                    $slide_active = 0;
                @endphp

                <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        @foreach($slides as $key => $slide)
                            <li data-target="#carouselExampleCaptions" data-slide-to="{{ $key }}" class="{{ $key == $slide_active ? 'active' : '' }}"></li>
                        @endforeach
                    </ol>
                    <div class="carousel-inner">
                        @foreach($slides as $key => $slide)
                            <div class="carousel-item{{ $key == $slide_active ? ' active' : '' }}" data-interval="false" data-touch="true">
                                <img src="{{ asset($slide['link']) }}" class="d-block w-100"
                                     alt="...">
                                <div class="carousel-caption d-none">
                                    <h1 class="main-title__title-lg">{{ __($slide['title']) }}</h1>
                                    <p class="main-title__description-lg">{{ __($slide['sub_title']) }}</p>
                                    <div class="btn-link-block btn-n">
                                        <a href="{{ asset('/') }}"
                                           class="btn-link-block-g">{{ __('Where buy') }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </a>
                </div>

            </div>
        </div>

    </div>
</section>