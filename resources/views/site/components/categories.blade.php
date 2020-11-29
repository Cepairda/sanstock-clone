@php($categories = $categories ?? \App\Category::joinLocalization()->get()->toTree())
<ul class="{{ $ul_class }}">
    @foreach($categories as $category)
        <li>
            <a href="{{ route('site.slug', $category->slug) }}">{!! $category->getData('name') !!}</a>
            @if($category->children->isNotEmpty())
                @include('site.components.categories', ['categories' => $category->children, 'ul_class' => 'rd-navbar-dropdown'])
            @endif
        </li>
    @endforeach
</ul>

