@php($categories = $categories ?? \App\Category::joinLocalization()->where('details->published', 1)->where('details->is_menu_item', 1)->get()->toTree())

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
                                   href="#">{{ $category->name }}</a>

                            </div>

                            <div class="level-2">

                                <div class="level-2__wrap">
                                    <ul class="test">
                                        @foreach($category->children as $cat)
                                            <li>
                                                <div class="head-menu__subcategory">

                                                    <div class="head-menu__subcategory--name-wrap category-arrow">

                                                        <a class="head-menu__subcategory--name"
                                                           href="#">{!! $cat->name !!}</a>

                                                    </div>

                                                    <div class="level-3">

                                                        <div class="level-3__wrap">

                                                            <div class="head-menu__subcategory">

                                                                <div class="head-menu__subcategory--name-wrap category-arrow">

                                                                    <a class="head-menu__subcategory--name" href="#">Lorem
                                                                        ipsum.</a>

                                                                </div>

                                                                <div class="head-menu__subcategory--name-wrap category-arrow">

                                                                    <a class="head-menu__subcategory--name" href="#">Lorem
                                                                        ipsum.</a>

                                                                </div>

                                                                <div class="head-menu__subcategory--name-wrap category-arrow">

                                                                    <a class="head-menu__subcategory--name" href="#">Lorem
                                                                        ipsum.</a>

                                                                </div>

                                                            </div>

                                                        </div>

                                                    </div>


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

