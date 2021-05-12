<div id="search-results" class="active">
    @if($products->isNotEmpty())
        <ul class="search_list">
            @foreach($products as $product)
                <li style="display: flex; width: 100%;">
                    <a class="d-flex" href="{{ route('site.resource', $product->slug) }}" alt="{{ $product->name }}" style=" flex-grow: 1">
                        {!! img(['type' => 'product', 'sku' => $product->sku, 'size' => 150, 'alt' => $product->name]) !!}
                        <div class="d-flex flex-column ml-3" style="justify-content: center">
                            <p class="heading-4" style="font-size: 16px">{{ $product->name }}</p>
                        </div>
                    </a>
                    <span class="icon icon-md linear-icon-heart" data-add="favorite" data-sku="{{$product->getDetails('sku')}}"></span>
                </li>
            @endforeach
        </ul>
    @else
        <ul class="search_list">
            <li>
                <div class="search_error">
                    {{ __('No results found for') }} "<span class="search"></span>"
                </div>
            </li>
        </ul>
    @endif
</div>
