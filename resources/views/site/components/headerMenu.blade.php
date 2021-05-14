@php($categories = $categories ?? \App\Category::joinLocalization()->get()->toTree())

<li class="nav-menu--item nav-head-menu">

    <p class="head-menu--title">
        Каталог товаров
    </p>

    <div class="head-menu head-menu--container">

        <div class="level-1">

            <div class="level-1__wrap">

                @foreach($categories as $category)

                    @if($category->children->isNotEmpty())

                        <div class="head-menu__category">

                            <div class="head-menu__category--name-wrap category-arrow" data-id="{{ $category->id }}">

                                <a class="head-menu__category--name"
                                   href="{{ route('site.resource', $category->slug) }}">{{ $category->name }}</a>

                            </div>

                            <div class="level-2">

                                <div class="level-2__wrap">
                                    <ul class="test">
                                        @foreach($category->children as $cat)
                                            <li>
                                                <div class="head-menu__subcategory">

                                                    @if($cat->children->isNotEmpty())

                                                    <div class="head-menu__subcategory--name-wrap category-arrow">
                                                        <a class="head-menu__subcategory--name" href="{{ route('site.resource', $cat->slug) }}">{!! $cat->name !!}</a>
                                                    </div>

                                                    <div class="level-3">

                                                        <div class="level-3__wrap">

                                                            <div class="head-menu__subcategory">

                                                                @foreach($cat->children as $c)
                                                                    <div class="head-menu__subcategory--name-wrap">
                                                                        <a class="head-menu__subcategory--name" href="{{ route('site.resource', $c->slug) }}">
                                                                            {{ $c->name }}
                                                                        </a>
                                                                    </div>
                                                                @endforeach

                                                            </div>

                                                        </div>

                                                    </div>

                                                    @else

                                                        <div class="head-menu__subcategory--name-wrap">
                                                            <a class="head-menu__subcategory--name" href="{{ route('site.resource', $cat->slug) }}">{!! $cat->name !!}</a>
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

                        <div class="head-menu__category">

                            <a class="head-menu__category--name"
                               href="#">{{ $category->name }}</a>

                        </div>

                    @endif

                @endforeach

            </div>

        </div>

    </div>

</li>

