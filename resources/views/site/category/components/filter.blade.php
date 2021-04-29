<form class="cell-md-3 section-divided__aside section__aside-left" action="">

    <!-- Range-->
    @if ($minPrice != $maxPrice)
        <section class="section-sm">
            <h5>{{ __('Price') }}</h5>
            <!--RD Range-->
            <div class="rd-range-wrap">
                <div class="rd-range-inner">
                    <input class="rd-range-input-value-1" name="minPrice">
                    <input class="rd-range-input-value-2" name="maxPrice">
                    <button class="rd-range-input-btn" type="submit">OK</button>
                </div>
                <div class="rd-range" data-min="{{ $minPrice }}" data-max="{{ $maxPrice }}" data-start="[{{ $minPriceSelect }}, {{ $maxPriceSelect }}]" data-step="1"
                     data-tooltip="true" data-min-diff="10" data-input=".rd-range-input-value-1"
                     data-input-2=".rd-range-input-value-2"></div>
            </div>
        </section>
    @endif

    @foreach ($characteristics as $characteristic)
        @if(count($valuesForView[$characteristic->id]) > 1)
            <section class="section-sm">
                <h5>{{ $characteristic->getData('name') }}</h5>
                <ul class="small list">

                    @foreach ($valuesForView[$characteristic->id] as $value)
                        <li>
                            <div class="form-group form-check custom-checkbox">
                                <input
                                    type="checkbox"
                                    class="custom-control-input checkbox-custom"
                                    name=filter[{{ $characteristic->id }}][]
                                    id="valueID{{ $value->id }}"
                                    value="{{ $value->id }}" {{ in_array($value->id, ($_GET['filter'][$characteristic->id]) ?? []) ? 'checked' : ''}}
                                >
                                <span class="checkbox-custom-dummy"></span>
                                <label class="custom-control-label"
                                       for="valueID{{ $value->id }}">{{ $value->getData('value') }}
                                    {{--<span>(1)</span>--}}</label>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </section>
        @endif
    @endforeach

    <button class="button button-gray-light-outline" href="#">{{ __('Apply') }}</button>

</form>
