<footer class="footer-grad">
    <div class="container footer">
        <div class="row">
            <div class="col-lg-3 footer__element">
                <span class="footer__element__title">{{ __('Categories') }}</span>
                <ul>
                    @php($categories = $categories ?? \App\Category::joinLocalization()->whereIsRoot()->get())

                    @foreach($categories as $category)
                        <li>
                            <a class="footer__element--item" href="{{ route('site.resource', $category->slug) }}">{{ $category->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-lg-3 footer__element">
                <span class="footer__element__title">{{ __('Information') }}</span>
                <ul>
                    <li><a class="footer__element--item" href="{{ asset('/about-us') }}">{{ __('About us') }}</a></li>
                    <li><a class="footer__element--item" href="{{ asset('/contacts') }}">{{ __('Contacts') }}</a></li>
                    <li><a class="footer__element--item" href="{{ asset('/delivery') }}">{{ __('Delivery') }}</a></li>
                    <li><a class="footer__element--item disabled" href="#" style="color: #656565">{{ __('FAQ') }}</a></li>
                </ul>
            </div>
            <div class="col-lg-3 footer__element">
                {{--<span class="footer__element__title">@lang('site.footer.mt3')</span>--}}
                {{--<ul>--}}
                    {{--<li><a class="footer__element--item" href="{{ asset('about') }}">@lang('site.footer.ml7')</a></li>--}}
                    {{--<li><a class="footer__element--item" href="{{ asset('documents') }}">@lang('site.footer.ml8')</a></li>--}}
                    {{--<li><a class="footer__element--item" href="{{ asset('videos') }}">@lang('site.footer.ml10')</a></li>--}}
                    {{--<li><a class="footer__element--item" href="{{ asset('/site/doc/catalog-2019.pdf') }}" target="_blank">@lang('site.footer.mt1')</a></li>--}}
                {{--</ul>--}}
            </div>
            <div class="col-lg-3 footer__element">
                <div>
                    <span class="footer__element__title">{{ __('Feedback') }}</span>
                    <ul>
                        <li class="footer__element--item-tel">Call-центр:</li>
                        <li><a class="footer__element-phone" href="tel:0800212124">0-800-21-21-24</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="copyright--lg  col-sm-12">
                    <i class="icon-copyright"></i>
                    <span>©&nbsp;{{ date('Y') }} SandiStock. {{ __('copy') }}</span>
                </div>
            </div>
        </div>
    </div>
</footer>
