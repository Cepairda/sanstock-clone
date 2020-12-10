@extends('layouts.site')
@section('body_class', 'contacts')
@section('breadcrumbs')
    <li class="active">{{ __('Sitemap') }}</li>
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
                <div class="m-auto section-sm">{!! view('site.components.categories', ['categories' => $categories, 'ul_class' => 'sitemap']) !!}</div>

            </div>
        </div>
    </section>
@endsection
