@extends('layouts.site')
@section('body_class', 'category')

@if (isset($_GET['page']))
    @section('rel_alternate_pagination')
        <link rel="canonical"
              href="{{ strtok(LaravelLocalization::getLocalizedURL(), '?') }}"
        >
    @endsection
@endif

@section('breadcrumbs')
    <li class="breadcrumb-item active"
        itemprop="itemListElement"
        itemscope itemtype="https://schema.org/ListItem"
    >
        <span itemprop="name">
                {{ __('Search') }}
        </span>
        <meta itemprop="position" content="2" />
    </li>
@endsection

@section('content')
    <form>
        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}"/>
    </form>

    <div class="main-container bgc-gray">

        @include('site.components.breadcrumbs', ['title' => 'tytyt', 'h1' => true])

        <div class="container">
            <div class="row main__filter">
                <main class="col-sm-12 col-lg-12 col-xl-12 order-2">
                    @if($productsSort->isNotEmpty())
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
                                <div class="col-12 col-lg-6 col-xl-3">
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
                    @else
                        <div class="main__title">
                            <p>{{ __('Search not result', ['search_value' => $searchQuery]) }}</p>
                        </div>
                    @endif
                </main>

            </div>
        </div>

    </div>



@endsection
