@extends('layouts.site')
@section('body_class', 'article')
@section('content')

    @include('site.components.breadcrumbs')
    <section class="section-xxl text-center" style="background-image: url({{ asset('images/site/Post-1.jpg') }}); background-repeat: no-repeat; background-position: center; background-size: cover;">
        <div class="shell nonstandart-post-header">
            <h2 style="color: #fff; text-transform: uppercase;">{{ $post->name }}</h2>
            <div class="post-meta">
                <div class="group">
                    <div> <time datetime="2017" style="color: #fff">Jan.20, 2016</time></div>
                    <div class="meta-author" style="color: #fff">by Brian Williamson</div>
                </div>
            </div>
        </div>
    </section>
    <div class="section-md">
        <div class="shell">
            <div class="range range-60 range-xs-center">
                <div class="cell-md-8 section-divided__main">
                    <section class="section-sm post-single-body">
                        {!! $post->text !!}
                    </section>
                    <!--section class="section-sm">
                        <h5>Latest Posts</h5>
                        <div class="range range-60">
                            <div class="cell-sm-6">

                                <article class="post-classic post-minimal"><img src="{{ asset('images/site/Post-1.jpg') }}" alt="" width="418" height="315"/>
                                    <div class="post-classic-title">
                                        <h5><a href="#">INTERESTING DESIGN FOR A DUAL-ACTION DESK DRAWER</a></h5>
                                    </div>
                                    <div class="post-meta">
                                        <div class="group"><a href="image-post.html">
                                                <time datetime="2017">Jan.20, 2016</time></a><a class="meta-author" href="image-post.html">by Brian Williamson</a></div>
                                    </div>
                                </article>
                            </div>
                            <div class="cell-sm-6">

                                <article class="post-classic post-minimal"><img src="{{ asset('images/site/Post-1.jpg') }}" alt="" width="886" height="668"/>
                                    <div class="post-classic-title">
                                        <h5><a href="#">THE INTERSECTION OF LEFTOVERS AND HAND-CRAFTED FURNITURE</a></h5>
                                    </div>
                                    <div class="post-meta">
                                        <div class="group"><a href="image-post.html">
                                                <time datetime="2017">Jan.20, 2016</time></a><a class="meta-author" href="image-post.html">by Brian Williamson</a></div>
                                    </div>
                                </article>
                            </div>
                        </div>
                    </section-->
                    <!--section class="section-sm">
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
                    </section-->
                </div>
            </div>
        </div>
    </div>

@endsection
