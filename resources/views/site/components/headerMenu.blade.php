@php($categories = $categories ?? \App\Category::joinLocalization()->get()->toTree())

<div class="nav-menu--item nav-head-menu">

    <p class="head-menu--title">
        {{ __('Catalog products') }}
    </p>

    <div class="head-menu head-menu--container">

        <div class="level-1 box">

            <div class="level-1__wrap box-view box-white">

                <ul class="visible-container box-list">

                    @foreach($categories as $category)

                        <li>

                            @if($category->children->isNotEmpty())

                                <div class="head-menu__category">

                                    <div class="head-menu__category--name-wrap tt category-arrow"
                                         data-id="{{ $category->id }}">

                                        <a class="head-menu__category--name"
                                           href="{{ route('site.resource', $category->slug) }}">{{ $category->name }}</a>

                                    </div>

                                    <div class="level-2 box">

                                        <div class="level-2__wrap box-view box-grey">

                                            <ul class="visible-container box-list">

                                                @foreach($category->children as $cat)

                                                    <li>

                                                        <div class="head-menu__subcategory">

                                                            @if($cat->children->isNotEmpty())

                                                                <div class="head-menu__subcategory--name-wrap tt category-arrow">
                                                                    <a class="head-menu__subcategory--name"
                                                                       href="{{ route('site.resource', $cat->slug) }}">{!! $cat->name !!}</a>
                                                                </div>

                                                                <div class="level-3 box">

                                                                    <div class="level-3__wrap box-view box-white">

                                                                        <ul class="visible-container box-list">

                                                                            @foreach($cat->children as $c)
                                                                                <li>
                                                                                    <div class="head-menu__subcategory">
                                                                                        <div class="head-menu__subcategory--name-wrap tt">
                                                                                            <a class="head-menu__subcategory--name"
                                                                                               href="{{ route('site.resource', $c->slug) }}">
                                                                                                {{ $c->name }}
                                                                                            </a>
                                                                                        </div>
                                                                                    </div>
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>


                                                                    </div>

                                                                </div>

                                                            @else

                                                                <div class="head-menu__subcategory--name-wrap tt">
                                                                    <a class="head-menu__subcategory--name"
                                                                       href="{{ route('site.resource', $cat->slug) }}">{!! $cat->name !!}</a>
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

                                <div class="head-menu__category tt">

                                    <a class="head-menu__category--name"
                                       href="#">{{ $category->name }}</a>

                                </div>

                            @endif

                        </li>

                    @endforeach
                </ul>

            </div>

        </div>

    </div>

</div>

