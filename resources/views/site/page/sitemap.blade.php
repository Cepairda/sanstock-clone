@extends('layouts.site')
@section('body_class', 'contacts')
@section('meta_title',  __('Sitemap'))
@section('meta_description',  __('Sitemap'))
@section('breadcrumbs')
    <li class="active"
        itemprop="itemListElement"
        itemscope itemtype="https://schema.org/ListItem"
    >
        <span itemprop="name">
            {{ __('Sitemap') }}
        </span>
        <meta itemprop="position" content="2" />
    </li>
@endsection
@section('content')

    @include('site.components.breadcrumbs', ['title' => __('Sitemap')])


    <section class="section-md bg-white">
        <div class="shell">
            <div class="range range-50">
                <div class="cell-12 text-center">
                    <h3>{{ __('Sitemap') }}</h3>
                </div>
                @php($categories = App\Category::joinLocalization()->with('ancestors')->where('details->published', 1)->where('details->is_menu_item', 1)->get()->toTree())
                <div class="m-auto section-sm">
                    <ul class="sitemap">
                        <li><a href="{{ route('site.contacts') }}">{{ __('Contacts') }}</a></li>
                        <li><a href="{{ route('site.blog') }}">{{ __('Blog') }}</a></li>
                        <li><a href="{{ route('site.documentations') }}">{{ __('Documentation') }}</a></li>
                        <li><a href="{{ route('site.resource', ['slug' => 'about-us']) }}">{{ __('About brand') }}</a></li>
                    </ul>
                    {!! view('site.components.categories', ['categories' => $categories, 'ul_class' => 'sitemap']) !!}
                </div>

            </div>
        </div>
    </section>
@endsection
