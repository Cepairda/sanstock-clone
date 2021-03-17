<!-- Page Footer -->
<section class="pre-footer-corporate">

    <div class="container">
        <div class="row">

            <div class="col-sm-6 col-md-10 col-lg-3">
                <img src="{{ asset('images/site/logo.svg') }}" alt="" width="125">
                <p style="padding-top: 35px;font-size: 14px">{!! __('footer desc') !!}</p>
            </div>

            <div class="col-sm-6 col-md-3 col-lg-3">
                <h5>{{ __('Categories') }}</h5>
                <ul class="list-sm">
                    @php($categories = $categories ?? \App\Category::joinLocalization()->get()->toTree())

                    @foreach($categories as $category)
                        <li>
                            <a href="{{ route('site.resource', $category->slug) }}">{!! $category->getData('name') !!}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="col-sm-6 col-md-5 col-lg-3">
                <h5>{{ __('Information') }}</h5>
                <ul class="list-sm">
                    {{--<li><a href="/for-user">{{ __('For user') }}</a></li>--}}
                    <li><a href="{{ route('site.sitemap') }}">{{ __('Sitemap') }}</a></li>
                    <li><a href="{{ route('site.blog') }}">{{ __('Blog') }}</a></li>
                    <li><a href="{{ route('site.contacts') }}">{{ __('Contacts') }}</a></li>
                </ul>
            </div>

            <div class="col-sm-6 col-md-4 col-lg-3">
                <h5>{{ __('About us') }}</h5>
                <ul class="list-sm">
                    <li><a href="{{ route('site.resource', 'about-us') }}">{{ __('About brand') }}</a></li>
                    <li><a href="{{ route('site.documentations') }}">{{ __('Documentation') }}</a></li>
                    <li><p style="font-size: 20px; color: #000">{{ __('Get in Touch') }}</p></li>
                    <li><a style="font-size: 20px; color: #000" href="tel:0800212008">0800 210 377</a></li>
                </ul>
            </div>

        </div>
    </div>

</section>
<!-- Footer -->
<footer class="footer-corporate" style="border-top: 1px solid #888; background-color: #f8f8f8; color: #000;">
    <div class="container">
        <div class="row">
            <div class="footer-corporate__inner">
                <p class="rights">©&nbsp;{{ date('Y') }} LIDZ. {{ __('copy') }}</p>
            </div>
        </div>
    </div>
</footer>
