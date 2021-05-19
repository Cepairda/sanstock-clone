<ul>
    @if($products->isNotEmpty())
        @foreach($products as $product)

            <li>
                <a class="search-product-link"
                   href="{{ route('site.resource', $product->productGroup->slug) }}"
                   alt="{{ $product->productGroup->name }}">
                    <div class="data-img-path"
                         data-src="/storage/product/{{ $product->sdCode }}/{{ $product->sdCode }}.jpg">
                        <img width="50"
                             class="lazy"
                             data-download="true"
                             src="{{ asset('images/white_fone_150x150.jpg') }}" alt="">
                    </div>
                    <div class="">
                        <p style="margin-bottom: 6px; font-size: 12px">Код:<span class="m-t ml-1" style="color: #888">{{ $product->sdCode }}</span></p>
                        <p class="m-t">{{ $product->productGroup->name }}</p>
                    </div>
                </a>

            </li>
        @endforeach
    @else
        <li>
            <div class="search_error"></div>
        </li>
    @endif
</ul>
