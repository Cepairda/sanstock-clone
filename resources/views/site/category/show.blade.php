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

    @php($descendants = $category->descendants)

    <div class="main-category bgc-gray">

        @include('site.components.breadcrumbs', ['title' => $category->getData('name'), 'h1' => true])

        <div class="container">

            @if($descendants->isNotEmpty())

                <div class="row main-category__wrapper">

                    @foreach($descendants as $descendant)


                        @if($descendant->children->isNotEmpty())

                            <div class="col-sm-12 level-2">

                                <h2>{{ $descendant->name }}</h2>

                                <div class="row">

                                    @foreach($descendant->children as $children)

                                        @if( $children->is_menu_item && $children->published )

                                            <div class="col-6 col-md-4 col-lg-2 category__wrapper--item">

                                                <div class="wrapper">

                                                    <div class="main-category__img jsLink"
                                                         data-href="{{ asset($children->alias->url )}}">

                                                        {!! img(['type' => 'category', 'original' => 'site/img/img_menu/' . $children->id . '.jpg', 'name' => $children->id, 'size' => 175, 'alt' => strip_tags($children->name)]) !!}

                                                    </div>

                                                    <a href="{{ asset($children->alias->url) }}"><span>{!! $children->name !!}</span></a>

                                                </div>

                                            </div>

                                        @endif

                                    @endforeach

                                </div>

                            </div>

                        @else

                            @if( $descendant->is_menu_item && $descendant->published )

                                <div class="col-6 col-md-4 col-lg-2 category__wrapper--item">

                                    <div class="main-category__img jsLink"
                                         data-href="{{ asset($descendant->alias->url )}}">

                                        {!! img(['type' => 'category', 'original' => 'site/img/img_menu/' . $descendant->id . '.jpg', 'name' => $descendant->id, 'size' => 175, 'alt' => strip_tags($descendant->name)]) !!}

                                    </div>

                                    <a href="{{ asset($descendant->alias->url) }}"><span>{!! $descendant->name !!}</span></a>

                                </div>

                            @endif

                        @endif

                        <hr>

                    @endforeach

                </div>

            @endif

            @isset($category->parent_id)
                <div class="row main__filter">
                    @if($productsSort->isNotEmpty())
                        <main class="col-sm-12 col-lg-8 col-xl-9 order-2">
                            <div class="main__title">{!! $category->h1 !!}</div>
                            {!! isset($json_ld) ? $json_ld : '' !!}
                            <div class="main__sort">
                                <p>@lang('site.content.sort'):</p>
                                <div class="sort-wrapper">

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
                                </div>

                                @if (isset($filters))
                                    <div class="btn-filter open-filter">
                                        @lang('site.category.components.filter')
                                    </div>
                                @endif

                            </div>
                            <div class="row filter-wrapper">
                                @foreach($productsSort as $productSort)
                                    <div class="col-12 col-lg-6 col-xl-4">
                                        @include('site.product.components.card', [
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


                    @include('site.category.components.filters', ['alias' => $category->alias])

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

        </div>

    </div>

@endsection
