@extends('layouts.site')
@section('body_class', 'documents')
@section('breadcrumbs')
    <li class="active"
        itemprop="itemListElement"
        itemscope itemtype="https://schema.org/ListItem"
    >
        <span itemprop="name">
            {{  __('Blog') }}
        </span>
        <meta itemprop="position" content="2" />
    </li>
@endsection

@if (isset($_GET['page']))
@section('rel_alternate_pagination')
    <link rel="canonical" href="{{ strtok(LaravelLocalization::getLocalizedURL(), '?') }}">
@endsection
@endif

@section('content')

    @include('site.components.breadcrumbs', ['title' => __('Blog')])


    <section class="bg-white section-md">
        <div class="shell">
            <div class="range range-70">
                <div class="cell-md-7 cell-lg-8 section-divided__main">

                @foreach($posts as $post)
                    <!-- Post classic-->
                        <div class="section-sm">
                            <article class="post-classic">
                                <div class="post-classic-title">
                                    <h4>
                                        <a href="{{ route('site.blog-post', ['slug' => $post->slug]) }}">{{ $post->name }}</a>
                                    </h4>
                                </div>
                                <img class="lazyload" data-src="{{ asset($post->img) }}" src="{{ asset('images/site/default_white.jpg') }}"
                                     alt="{{ $post->name }}" width="886" height="668"/>

                                <div class="post-classic-footer">
                                    <div class="post-meta">
                                        <div class="group">
                                            <time>{{ $post->created_at->format('d.m.Y') }}</time>
                                            @if ($post->tags)
                                                <ul class="list-inline-tag">
                                                    @foreach($post->tags as $tag)
                                                        <li><a href="{{ route('site.blog-tag', $tag->id) }}">#{{ $tag->name }}</a></li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                    </div>
                                    <a class="button button-link mr-4" href="{{ route('site.blog-post', ['slug' => $post->slug]) }}">{{ __('Read more') }}</a>
                                </div>
                            </article>
                        </div>
                    @endforeach
                    <section class="section-sm text-center">
                        {!! $posts->links() !!}
                    </section>
                </div>
                <div class="cell-md-5 cell-lg-4 section-divided__aside section-divided__aside-left">
                    <!-- About-->
                    <section class="section-sm">
                        <div class="thumbnail-classic-minimal">
                            <img class="img-circle" src="{{ asset('images/logo.png') }}" alt="{{ __('Blog about title') }}" width="210" height="210"/>
                            <div class="caption">
                                <p>{{ __('Blog about paragraph-1') }}.</p>
                                <p>{{ __('Blog about paragraph-2') }}.</p>
                                <p>{{ __('Blog about paragraph-3') }}.</p>
                            </div>
                        </div>
                    </section>

                    {{--
                    <!-- Posts-->
                    <section class="section-sm">
                        <h5>Последние посты</h5>
                        <ul class="list-sm">
                            <li>
                                <!-- Post inline-->
                                <article class="post-inline">
                                    <p class="post-inline__link"><a href="standard-post.html">How Laidback an Office
                                            Chair Should Be?</a></p>
                                    <div class="post-inline__header">
                                        <span class="post-inline__time">Jan.20, 2016</span>
                                        <ul class="list-inline-tag mt-0">
                                            <li><a href="#">#Tag-1</a></li>
                                            <li><a href="#">#Tag-2</a></li>
                                            <li><a href="#">#Tag-3</a></li>
                                        </ul>
                                    </div>
                                </article>
                            </li>
                            <li>
                                <!-- Post inline-->
                                <article class="post-inline">
                                    <p class="post-inline__link"><a href="standard-post.html">Buy Smart: How to Buy a
                                            Durable Recliner Chair</a></p>
                                    <div class="post-inline__header">
                                        <span class="post-inline__time">Jan.20, 2016</span>
                                        <ul class="list-inline-tag mt-0">
                                            <li><a href="#">#Tag-1</a></li>
                                            <li><a href="#">#Tag-2</a></li>
                                            <li><a href="#">#Tag-3</a></li>
                                        </ul>
                                    </div>
                                </article>
                            </li>
                            <li>
                                <!-- Post inline-->
                                <article class="post-inline">
                                    <p class="post-inline__link"><a href="standard-post.html">Meet the Brand of the
                                            Week: KEM WEBER’s Furniture</a></p>
                                    <div class="post-inline__header">
                                        <span class="post-inline__time">Jan.20, 2016</span>
                                        <ul class="list-inline-tag mt-0">
                                            <li><a href="#">#Tag-1</a></li>
                                            <li><a href="#">#Tag-2</a></li>
                                            <li><a href="#">#Tag-3</a></li>
                                        </ul>
                                    </div>
                                </article>
                            </li>
                        </ul>
                    </section>
                    --}}

                    @if($tags->isNotEmpty())
                        <!-- Tags-->
                        <section class="section-sm">
                            <h5>Теги</h5>
                            <ul class="list-tags">
                                @foreach($tags as $tag)
                                    <li><a href="{{ route('site.blog-tag', $tag->id) }}">{{ $tag->name }}</a></li>
                                @endforeach
                            </ul>
                        </section>
                    @endif

                    {{--
                    <!-- Follow us-->
                    <section class="section-sm border-transparent">
                        <h5>Подпишись на Нас</h5>
                        <ul class="list-inline-sm">
                            <li><a class="icon icon-gray-4" href="#" alt="facebook">
                                    <svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11,10h2.6l0.4-3H11V5.3c0-0.9,0.2-1.5,1.5-1.5H14V1.1c-0.3,0-1-0.1-2.1-0.1C9.6,1,8,2.4,8,5v2H5.5v3H8v8h3V10z"></path>
                                    </svg>
                                </a></li>
                            <li><a class="icon icon-gray-4" href="#" alt="instagram">
                                    <svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13.55,1H6.46C3.45,1,1,3.44,1,6.44v7.12c0,3,2.45,5.44,5.46,5.44h7.08c3.02,0,5.46-2.44,5.46-5.44V6.44 C19.01,3.44,16.56,1,13.55,1z M17.5,14c0,1.93-1.57,3.5-3.5,3.5H6c-1.93,0-3.5-1.57-3.5-3.5V6c0-1.93,1.57-3.5,3.5-3.5h8 c1.93,0,3.5,1.57,3.5,3.5V14z"></path>
                                        <circle cx="14.87" cy="5.26" r="1.09"></circle>
                                        <path d="M10.03,5.45c-2.55,0-4.63,2.06-4.63,4.6c0,2.55,2.07,4.61,4.63,4.61c2.56,0,4.63-2.061,4.63-4.61 C14.65,7.51,12.58,5.45,10.03,5.45L10.03,5.45L10.03,5.45z M10.08,13c-1.66,0-3-1.34-3-2.99c0-1.65,1.34-2.99,3-2.99s3,1.34,3,2.99 C13.08,11.66,11.74,13,10.08,13L10.08,13L10.08,13z"></path>
                                    </svg>
                                </a></li>
                        </ul>
                    </section>
                    --}}
                </div>
            </div>
        </div>
    </section>


    {{-- Old --}}
    {{--
    <section class="section-md bg-white">
        <div class="shell">
            <div class="posts-lists-masonry-3-cols">
            @foreach($posts as $post)
                <!-- Post classic-->
                    <article class="post-classic post-minimal">
                        <a href="{{ route('site.blog-post', ['slug' => $post->slug]) }}">
                            <img src="{{ asset('images/site/Blog/' . $post->slug . '.jpg') }}" alt="" width="418"
                                 height="315"/>
                        </a>
                        <div class="post-classic-title">
                            <h5><a href="{{ route('site.blog-post', ['slug' => $post->slug]) }}">{{ $post->name }}</a>
                            </h5>
                        </div>
                        <div class="post-meta">
                            <div class="group">
                                <a href="image-post.html">
                                    <time datetime="2017">{{ $post->created_at->format('d.m.Y') }}</time>
                                </a>
                                <a class="meta-author" href="image-post.html">by Brian Williamson</a></div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
    --}}

@endsection
