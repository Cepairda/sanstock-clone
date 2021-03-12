@extends('layouts.site')
@section('body_class', 'pages')
@section('meta_title', $page->meta_title)
@section('meta_description', $page->meta_description)
@section('breadcrumbs')
    <li class="active"
        itemprop="itemListElement"
        itemscope itemtype="https://schema.org/ListItem"
    >
        <span itemprop="name">
            {{  __('About us') }}
        </span>
        <meta itemprop="position" content="2" />
    </li>
@endsection
@section('content')


    @include('site.components.breadcrumbs', ['title' => __('About us')])

    <div class="section-md">

        <div class="shell">

            <div class="range range-60 range-xs-center">

                <div class="cell-md-8 section-divided__main">

                    <section class="section-sm post-single-body">

                        {{--<p class="first-letter">After a hard day’s work, there’s nothing better than sitting and getting all comfortable and cozy in a soft, comfy chair. But finding a recliner that will perfectly fit your body and your budget at the same time (prices range from $250 to $5,000) isn’t as relaxing and easy. If we’re also adding quality, a decent lounger should last at least 10 years with regular use. Here’s how to pick one that won’t break down prematurely!</p>--}}
                        <div style="margin-bottom: 16px; font-size: 45px; font-weight: 400; color: #000">{{ $page->name }}</div>
                        <div>{!! $page->description !!}</div>

                    </section>

                </div>

            </div>

        </div>

    </div>

@endsection
