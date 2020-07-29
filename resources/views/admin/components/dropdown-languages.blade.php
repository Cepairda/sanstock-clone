<div class="dropdown px-3 d-inline-block">
    <a href="#" class="dropdown-toggle text-dark" data-toggle="dropdown">
        <span class="fas fa-language text-primary"></span>
        {{ mb_ucfirst(LaravelLocalization::getCurrentLocaleNative()) }}
    </a>
    <div class="dropdown-menu dropdown-menu-right">
        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
            @if(LaravelLocalization::getCurrentLocale() !== $localeCode)
                <a class="dropdown-item"
                   href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], false) }}">
                    {{ mb_ucfirst($properties['native']) }}
                </a>
            @endif
        @endforeach
    </div>
</div>
