@extends('layouts.site')
@section('body_class', 'contacts')
@section('content')
    @include('site.components.breadcrumbs')


    <section class="section-md bg-white">
        <div class="shell">
            <div class="range range-50">

                @php($categories = App\Category::joinLocalization()->with('ancestors')->where('details->published', 1)->where('details->is_menu_item', 1)->get()->toTree())
                <ul>{!! view('site.components.categories', ['categories' => $categories, 'ul_class' => '']) !!}</ul>

            </div>
        </div>
    </section>
@endsection
