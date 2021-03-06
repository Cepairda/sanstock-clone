<div class="btn-close">
    <div class="main-filter__prev">
        <span>Назад</span>
    </div>
    <div class="main-filter__title">{{ __('Filters') }}</div>
</div>
<form id="sidebar-filter" class="left-sidebar__form" action="">
    <!-- Range-->
    @if ($minPrice != $maxPrice)
        <div class="left-sidebar__view range-slider">
            <h3 class="left-sidebar__view--title">{{ __('Price') }}</h3>
            <b class="text-lg">{{ __('From') }}</b>
            <input class="inp-price-min" type="number" name="minPrice" value="{{ $minPriceSelect }}">
            <b class="text-lg">до</b>
            <input class="inp-price-max" type="number" name="maxPrice" value="{{ $maxPriceSelect  }}">
            <b class="text-lg">грн.</b>
            <input id="priceRangeSlider" type="text" data-slider-min="{{ $minPrice }}"
                   data-slider-max="{{ $maxPrice }}" data-slider-value="[{{ $minPriceSelect }},{{ $maxPriceSelect }}]"
                   data-slider-step="10">
            <button class="button mx-auto d-block" type="submit">OK</button>
        </div>
    @endif
    <hr>
    @if(count($sortType) > 1)
    <div class="left-sidebar__view">
        <div class="left-sidebar__view--wrapp">
            <h3 class="left-sidebar__view--title">Сорт</h3>
            @foreach ($sortType as $i)
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="sort[]"
                           id="sortID{{ $i }}" value="{{ $i }}"
                           {{ in_array($i, ($_GET['sort']) ?? []) ? 'checked' : ''}}
                           class="custom-control-input">
                    <label class="custom-control-label"
                           for="sortID{{ $i }}">{{ $i }}</label>
                </div>
            @endforeach
        </div>
    </div>
    <hr>
    @endif
    @foreach ($characteristics as $characteristic)
        @if(count($valuesForView[$characteristic->id]) > 1)
            <div class="left-sidebar__view">
                <div class="left-sidebar__view--wrapp">
                    <h3 class="left-sidebar__view--title">{{ $characteristic->getData('name') }}</h3>
                    <div class="characteristics-values">
                    @foreach ($valuesForView[$characteristic->id] as $value)
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="filters[{{ $characteristic->id }}][]"
                                   id="valueID{{ $value->id }}" value="{{ $value->id }}"
                                   {{ in_array($value->id, ($_GET['filters'][$characteristic->id]) ?? []) ? 'checked' : ''}}
                                   class="custom-control-input">
                            <label class="custom-control-label"
                                   for="valueID{{ $value->id }}">{{ $value->getData('value') }}</label>
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>
            <hr>
        @endif
    @endforeach
    <div class="left-sidebar__view--btn">
        <a href="{{ Request::url() }}" class="button">{{ __('Reset') }}</a>
    </div>
</form>
