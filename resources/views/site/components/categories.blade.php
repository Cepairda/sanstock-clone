@foreach($categories as $category)
    <li>
        <a href="{{ route('site.slug', $category->slug) }}">{!! $category->getData('name') !!}</a>
        @if($category->children->isNotEmpty())
            <ul>
                {!! view('site.components.categories', ['categories' => $category->children]) !!}
            </ul>
        @endif
    </li>
@endforeach
