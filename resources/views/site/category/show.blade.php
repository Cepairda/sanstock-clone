@extends('layouts.site')
@section('body_class', 'category')
@section('meta_title', $category->meta_title)
@section('meta_description', $category->meta_description)

@if (isset($_GET['page']))
@section('rel_alternate_pagination')
    <link rel="canonical"
          href="{{ strtok(LaravelLocalization::getLocalizedURL(), '?') }}"
    >
@endsection
@endif

@section('breadcrumbs')
    @php($i = 2)
    @foreach($category->ancestors as $ancestor)
        <li itemprop="itemListElement" class="breadcrumb-item" itemscope itemtype="https://schema.org/ListItem">
            <a href="{{ route('site.resource', $ancestor->slug) }}" itemprop="item">
                <span itemprop="name">
                    {{ $ancestor->name }}
                </span>
            </a>
            <meta itemprop="position" content="{{ $i }}"/>
        </li>
        @php($i++)
    @endforeach
    <li class="breadcrumb-item active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
        <span itemprop="name">
            {{ $category->name }}
        </span>
        <meta itemprop="position" content="{{ $i }}"/>
    </li>
@endsection

@section('content')

    <form>
        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}"/>
    </form>

    @php($descendants = $category->children)

    <div class="main-container bgc-gray">

        @include('site.components.breadcrumbs', ['title' => $category->getData('name'), 'h1' => true])

        <div class="container container-gap-sm">
            @if($descendants->isNotEmpty())
                <div class="row">
                    @foreach($descendants as $descendant)
                        @if($descendant->children->isEmpty())
                            <div class="col-3">
                                <div class="py-3 mb-3 bg-white">
                                    <a href="{{ route('site.resource', $descendant->slug) }}"
                                       title="{{ $descendant->name }}">
                                        <img src="{{ asset('images/no_img.jpg') }}"
                                             data-src="{{ asset('storage/category/' . $descendant->ref . '.jpg')  }}"
                                             class="img-data-path w-100 lazy"
                                             alt="{{ $descendant->name }}">
                                        <div class="pt-3 text-center">
                                            {{ $descendant->name }}
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                    @foreach($descendants as $descendant)
                        @if($descendant->children->isNotEmpty())
                            <p class="category-title">{{ $descendant->name }}</p>
                            <div class="row">
                            @foreach($descendant->children()->joinLocalization()->get() as $subChildren)
                                <div class="col-3">
                                    <div class="py-3 mb-3 bg-white">
                                        <a href="{{ route('site.resource', $subChildren->slug) }}"
                                           title="{{ $subChildren->name }}">
                                            <img src="{{ asset('images/no_img.jpg') }}"
                                                 data-src="{{ asset('storage/category/' . $subChildren->ref . '.jpg')  }}"
                                                 class="img-data-path w-100 lazy"
                                                 alt="{{ $subChildren->name }}">
                                            <div class="pt-3 text-center">
                                                {{ $subChildren->name }}
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                            </div>
                        @endif
                    @endforeach
            @else
                @isset($category->parent_id)
                    <div class="row main__filter">
                        @if($productsSort->isNotEmpty())
                            <main class="col-sm-12 col-lg-8 col-xl-9 order-2">
                                <div class="main__title">{!! $category->getData('name') !!}</div>
                                {!! isset($json_ld) ? $json_ld : '' !!}
                                <div class="main__sort">
                                    {{--<p>{{ __('Sort') }}:</p>--}}
                                    {{--<div class="sort-wrapper">--}}
                                        {{--<span class="sort-view">@lang('site.links_to_sort.' . (isset($parameters['sort']) ? $parameters['sort'][0] : 'name'))</span>--}}
                                        {{--<ul>--}}
                                        {{--<li class="sort-view-link jsLink"--}}
                                        {{--data-href="{{ asset($links_to_sort['price']) }}">@lang('site.links_to_sort.price')</li>--}}
                                        {{--<li class="sort-view-link jsLink"--}}
                                        {{--data-href="{{ asset($links_to_sort['-price']) }}">@lang('site.links_to_sort.-price')</li>--}}
                                        {{--<li class="sort-view-link jsLink"--}}
                                        {{--data-href="{{ asset($links_to_sort['name']) }}">@lang('site.links_to_sort.name')</li>--}}
                                        {{--<li class="sort-view-link jsLink"--}}
                                        {{--data-href="{{ asset($links_to_sort['-name']) }}">@lang('site.links_to_sort.-name')</li>--}}
                                        {{--</ul>--}}
                                    {{--</div>--}}
                                </div>
                                <div class="row filter-wrapper">
                                    @foreach($productsSort as $productSort)
                                        <div class="col-12 col-lg-6 col-xl-4">
                                            @include('site.product_group.components.card', [
                                                'product' => $productSort,
                                                'productGroup' => $productSort->productGroup
                                            ])
                                        </div>
                                    @endforeach
                                </div>
                                @isset($show_more)
                                    <button type="button" class="btn-more-link" data-page="{{ $show_more['page'] }}"
                                            data-url="{{ asset('show-more') }}"
                                            data-parameters="{{ $show_more['parameters'] }}" id="showMore"
                                            data-token="{{ csrf_token() }}" data-alias="{{ $show_more['alias'] }}">
                                        @lang('site.content.showmore')
                                    </button>
                                @endisset
                                <div class="col-sm-12 nav-pages">
                                    <nav aria-label="Page navigation">
                                        {{--{!! $productsSort->links('site.components.pagination') !!}--}}
                                    </nav>
                                </div>
                            </main>
                        @endif

                        <aside class="col-sm-3 col-lg-4 col-xl-3 main-filter order-1">
                        @if ($productsTotal > 1)
                            @include('site.category.components.filters', ['alias' => $category->alias])
                        @endif
                        <!-- filter banner -->
                            <div class="filter-banner" hidden>
                                <img class="mw-100 lazy-img-thumb" src="{{ asset('site/libs/icon/logo.svg') }}"
                                     data-src="{{ asset('site/img/category-bs/' . $category->id . '.jpg') }}" alt="">
                                <div class="btn-outer">
                                    <div class="btn-link-block">
                                        <a href="" class="btn-link-block-g"></a>
                                    </div>
                                </div>
                            </div>

                        </aside>

                        @if(isset($category->text) && $current_page == 1)
                            <div class="col-sm-12 order-3 block-text">{!! $category->text !!}</div>
                        @endif

                    </div>
                @endisset

            @endif

        </div>

    </div>

@endsection
