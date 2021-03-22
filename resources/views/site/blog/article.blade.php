@extends('layouts.site')
@section('body_class', 'article')
@section('meta_title', $post->meta_title)
@section('meta_description', $post->meta_description)
@section('breadcrumbs')
    <li itemprop="itemListElement"
        itemscope itemtype="https://schema.org/ListItem"
    >
        <a href="{{ route('site.blog') }}" itemprop="item">
            <span itemprop="name">
                {{ __('Blog') }}
            </span>
        </a>
        <meta itemprop="position" content="2" />
    </li>
    <li class="active"
        itemprop="itemListElement"
        itemscope itemtype="https://schema.org/ListItem"
    >
        <span itemprop="name">
            {{ $post->getData('name') }}
        </span>
        <meta itemprop="position" content="3" />
    </li>
@endsection
@section('content')

    @include('site.components.breadcrumbs', ['title' => $post->getData('name')])

    <div class="section-md">
        <div class="shell">
            <div class="range range-60 range-xs-center">
                <div class="cell-md-8 section-divided__main">
                    <section class="section-sm post-single-body">
                        <h3>{{ $post->getData('name') }}</h3>
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
                        {!! $post->text !!}
                    </section>

                    {{--
                    <section class="section-sm">
                        <h5>Последние посты</h5>
                        <div class="range range-60">
                            <div class="cell-sm-6">

                                <article class="post-classic post-minimal"><img src="{{ asset('images/site/Post-1.jpg') }}" alt="" width="418" height="315"/>
                                    <div class="post-classic-title">
                                        <h5><a href="#">INTERESTING DESIGN FOR A DUAL-ACTION DESK DRAWER</a></h5>
                                    </div>
                                    <div class="post-meta">
                                        <div class="group">
                                            <a href="image-post.html">
                                                <time>25.12.2020</time>
                                            </a>
                                            <ul class="list-inline-tag">
                                                <li><a href="#">#tag-1</a></li>
                                                <li><a href="#">#tag-2</a></li>
                                                <li><a href="#">#tag-3</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            <div class="cell-sm-6">

                                <article class="post-classic post-minimal"><img src="{{ asset('images/site/Post-1.jpg') }}" alt="" width="886" height="668"/>
                                    <div class="post-classic-title">
                                        <h5><a href="#">THE INTERSECTION OF LEFTOVERS AND HAND-CRAFTED FURNITURE</a></h5>
                                    </div>
                                    <div class="post-meta">
                                        <div class="group">
                                            <a href="image-post.html">
                                                <time>15.01.2021</time>
                                            </a>
                                            <ul class="list-inline-tag">
                                                <li><a href="#">#tag-1</a></li>
                                                <li><a href="#">#tag-2</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        </div>
                    </section>
                    --}}

                    {{--
                    <section class="section-sm">
                        <article class="blurb">
                            <div class="unit unit-xs-horizontal unit-spacing-md">
                                <div class="unit__left"><img class="img-circle" src="images/timeline-1-109x109.jpg" alt="" width="109" height="109"/>
                                </div>
                                <div class="unit__body">
                                    <p class="blurb__title">About the author</p>
                                    <p class="small">Mary's interest in furniture and everything related to it began in her father's local chairs & tables store in Virginia... Starting off as his helper and accountant, she eventually grew fond of the whole thing and began to consider an option of starting her own furniture store in the big city. With her first store in Arlington in 1999, Mary's chain began to gradually expand, now consisting of more than 5 furniture stores nationwide...</p>
                                </div>
                            </div>
                        </article>
                    </section>
                    --}}
                </div>
                <div class="cell-md-4 section-divided__aside section-divided__aside-left">
                    {{--
                    <!-- Posts-->
                    <section class="section-sm">
                        <h5>Latest Posts</h5>
                        <ul class="list-sm">
                            <li>
                                <!-- Post inline-->
                                <article class="post-inline">
                                    <div class="post-inline__header"><span class="post-inline__time">Jan.20, 2016</span><a class="post-inline__author meta-author" href="standard-post.html">by Brian Williamson</a></div>
                                    <p class="post-inline__link"><a href="standard-post.html">Buy Smart: How to Buy a Durable Recliner Chair</a></p>
                                </article>
                            </li>
                            <li>
                                <!-- Post inline-->
                                <article class="post-inline">
                                    <div class="post-inline__header"><span class="post-inline__time">Jan.20, 2016</span><a class="post-inline__author meta-author" href="standard-post.html">by Brian Williamson</a></div>
                                    <p class="post-inline__link"><a href="standard-post.html">Meet the Brand of the Week: KEM WEBER's Furniture</a></p>
                                </article>
                            </li>
                            <li>
                                <!-- Post inline-->
                                <article class="post-inline">
                                    <div class="post-inline__header"><span class="post-inline__time">Jan.20, 2016</span><a class="post-inline__author meta-author" href="standard-post.html">by Brian Williamson</a></div>
                                    <p class="post-inline__link"><a href="standard-post.html">Not Enough Closet Space? Clothes Racks to the Rescue</a></p>
                                </article>
                            </li>
                        </ul>
                    </section>
                    --}}
                    {{--
                    <!-- Tags-->
                    <section class="section-sm">
                        <h5>Tags</h5>
                        <ul class="list-tags">
                            <li><a href="#">Bedroom</a></li>
                            <li><a href="#">Dining Room</a></li>
                            <li><a href="#">Kids Room</a></li>
                            <li><a href="#">Living Room</a></li>
                            <li><a href="#">Office</a></li>
                        </ul>
                    </section>
                    --}}
                </div>
            </div>
        </div>
    </div>

@endsection
