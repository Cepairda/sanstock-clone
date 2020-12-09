@php($categories = $categories ?? \App\Category::joinLocalization()->where('details->published', 1)->where('details->is_menu_item', 1)->get()->toTree())
<ul class="{{ $ul_class }}">
    @foreach($categories as $category)
        @if($category->children->isNotEmpty())
            <li class="rd-navbar--has-dropdown rd-navbar-submenu">
                <a href="{{ route('site.resource', $category->slug) }}">{!! $category->getData('name') !!}</a>
                @include('site.components.categories', ['categories' => $category->children, 'ul_class' => 'rd-navbar-dropdown'])
            </li>
        @else
            <li>
                <a href="{{ route('site.resource', $category->slug) }}">{!! $category->getData('name') !!}</a>
            </li>
        @endif
    @endforeach
</ul>
