<!-- description-blocks -->
<div class="description-blocks">
    <div class="container">
        <div class="row">
            @for($_sort = 0; $_sort < 4; $_sort++)
                <div class="col-12">
                    <div class="description-block">
                        <div class="description-block__image">
                            <img src="{{ asset('images/site/icons/sort/' . $_sort . '.svg') }}" alt="ceramics-title" style="height: 250px;">
                        </div>

                        <div class="description-block__desc">
                            <h3><span class="label" data-sort="{{ $_sort }}" style="font-size: inherit; padding-top: 8px; padding-bottom: 8px;">Сорт-{{ $_sort }}</span></h3>
                            <p>{{ __('descriptions.desc_sort-' . $_sort) }}</p>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</div>
