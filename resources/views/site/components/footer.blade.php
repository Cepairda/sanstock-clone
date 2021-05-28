<footer class="footer-grad">
    <div class="container footer">
        <div class="row">
            <div class="col-lg-3 footer__element">
                <span class="footer__element__title">@lang('site.content.categories')</span>
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
                <span class="footer__element__title">@lang('site.footer.mt2')</span>
                <ul>
                    <li><a class="footer__element--item" href="{{ asset('for-user') }}">@lang('site.content.for-user')</a></li>
                    <li><a class="footer__element--item" href="{{ asset('sale-points') }}">@lang('site.footer.ml5')</a></li>
                    <li><a class="footer__element--item" href="{{ asset('sitemap') }}">@lang('site.footer.ml11')</a></li>
                    <li><a class="footer__element--item" href="{{ asset('blog') }}">@lang('site.content.blog')</a></li>
                    <li><a class="footer__element--item" href="{{ asset('contacts') }}">@lang('site.footer.ml6')</a></li>
                </ul>
            </div>
            <div class="col-lg-3 footer__element">
                <span class="footer__element__title">@lang('site.footer.mt3')</span>
                <ul>
                    <li><a class="footer__element--item" href="{{ asset('about') }}">@lang('site.footer.ml7')</a></li>
                    <li><a class="footer__element--item" href="{{ asset('documents') }}">@lang('site.footer.ml8')</a></li>
                    <li><a class="footer__element--item" href="{{ asset('videos') }}">@lang('site.footer.ml10')</a></li>
                    <li><a class="footer__element--item" href="{{ asset('/site/doc/catalog-2019.pdf') }}" target="_blank">@lang('site.footer.mt1')</a></li>
                </ul>
            </div>
            <div class="col-lg-3 footer__element">
                <div>
                    <span class="footer__element__title">@lang('site.footer.mt4')</span>
                    <ul>
                        <li class="footer__element--item-tel">Call-центр:</li>
                        <li><a class="footer__element-phone" href="tel:0800212124">0-800-21-21-24</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer_mb-vr">
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <span class="footer__element__title">@lang('site.content.hotline')</span>
                    <ul>
                        <li><a class="footer__phone" href="tel:0800212124">0-800-21-21-24</a></li>
                    </ul>
                </div>
                <div class="col-6 footer_mb-vr__connect">
                    <span class="footer__element__title">@lang('site.content.callback')</span>
                    <ul>
                        <li>
                            <a href="#"><i class="icon-instagram"></i></a>
                        </li>
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
<a href="#" class="link-to-top" hidden>
    <i class="to-top"></i>
</a>
