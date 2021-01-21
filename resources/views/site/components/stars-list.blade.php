<ul class="rating">
    @for ($i = 5; $i > 0; $i--)
        <li class="star {{ $i == $star ? 'selected' : '' }}"></li>
    @endfor
</ul>
