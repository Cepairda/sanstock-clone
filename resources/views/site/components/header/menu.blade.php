@php($categories = $categories ?? \App\Category::joinLocalization()->get()->toTree())

<div class="nav-head-menu">

    <p class="head-menu--title">
        {{ __('Catalog products') }}
    </p>

    <div class="head-menu head-menu--container">

        <div class="box">

            <div class="box-view box-white">

                <ul class="box-list">

                    @foreach($categories as $category)

                        <li>

                            @if($category->children->isNotEmpty())

                                <div class="box-list__inner">

                                    <div class="box-list__link box-list-white box-list-arrow">

                                        <a href="{{ route('site.resource', $category->slug) }}">{{ $category->name }}</a>

                                    </div>

                                    <div class="box">

                                        <div class="box-view box-grey">

                                            <ul class="box-list">

                                                @foreach($category->children as $cat)

                                                    <li>

                                                        <div class="box-list__inner">

                                                            @if($cat->children->isNotEmpty())

                                                                <div class="box-list__link box-list-grey box-list-arrow">
                                                                    <a href="{{ route('site.resource', $cat->slug) }}">{!! $cat->name !!}</a>
                                                                </div>

                                                                <div class="box">

                                                                    <div class="box-view box-white">

                                                                        <ul class="box-list">

                                                                            @foreach($cat->children as $c)

                                                                                <li>
                                                                                    <div class="box-list__inner">
                                                                                        <div class="box-list__link box-list-white">
                                                                                            <a href="{{ route('site.resource', $c->slug) }}"> {{ $c->name }}</a>
                                                                                        </div>
                                                                                    </div>
                                                                                </li>

                                                                            @endforeach
                                                                        </ul>

                                                                    </div>

                                                                </div>

                                                            @else

                                                                <div class="box-list__inner">
                                                                    <div class="box-list__link box-list-grey">
                                                                        <a href="{{ route('site.resource', $cat->slug) }}">{!! $cat->name !!}</a>
                                                                    </div>
                                                                </div>

                                                            @endif

                                                        </div>

                                                    </li>

                                                @endforeach

                                            </ul>

                                        </div>

                                    </div>

                                </div>

                            @else
                                <div class="box-list__inner">
                                    <div class="box-list__link box-list-white">
                                        <a href="{{ route('site.resource', $category->slug) }}">{{ $category->name }}</a>
                                    </div>
                                </div>
                            @endif

                        </li>

                    @endforeach
                </ul>

            </div>

        </div>

    </div>

</div>

