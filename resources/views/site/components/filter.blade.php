<form class="cell-md-3 section-divided__aside section__aside-left" action="">
    @foreach ($characteristics as $characteristic)
        <section class="section-sm">
            <h5>{{ $characteristic->getData('name') }}</h5>
            <ul class="small list">
            @foreach ($valuesForView[$characteristic->id] as $value)
                <li>
                    <div class="form-group form-check custom-checkbox">
                        <input
                            type=checkbox
                            class="custom-control-input checkbox-custom"
                            name=filter[{{ $characteristic->id }}][]
                            id="valueID{{ $value->id }}"
                            value="{{ $value->id }}" {{ in_array($value->id, ($_GET['filter'][$characteristic->id]) ?? []) ? 'checked' : ''}}
                        >
                        <span class="checkbox-custom-dummy"></span>
                        <label class="custom-control-label" for="valueID{{ $value->id }}">{{ $value->getData('value') }}
                            <span>(1)</span></label>
                    </div>
                </li>
            @endforeach
            </ul>
        </section>
    @endforeach

    <!-- Range-->
    <section class="section-sm">
        <h5>Filter By Price</h5>
        <!--RD Range-->
        <div class="rd-range-wrap">
            <div class="rd-range-inner"><span>Price: </span><span class="rd-range-input-value-1"></span><span>—</span><span
                    class="rd-range-input-value-2"></span></div>
            <div class="rd-range" data-min="10" data-max="500" data-start="[75, 244]" data-step="1"
                 data-tooltip="true" data-min-diff="10" data-input=".rd-range-input-value-1"
                 data-input-2=".rd-range-input-value-2"></div>
        </div>
{{--        <a class="button button-gray-light-outline" href="#">Filter</a>--}}
        <button class="button button-gray-light-outline" href="#">Filter</button>
    </section>

</form>
