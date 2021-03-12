<!-- Modal -->
<div class="modal fade" id="partnersModal" tabindex="-1" role="dialog" aria-labelledby="partnersModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">{{ __('Certified points of sale') }}</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    @if ($product->partnersUrl->isNotEmpty())
                        @foreach($product->partnersUrl as $partnerUrl)
                            <div class="col-6 col-sm-4 col-md-3 partnet-list-item">

                                <div onclick="window.open('//{{ $partnerUrl->url }}')">

                                @if (isset($partnerUrl->partner->img))
                                    <img class="img-responsive" alt="partners" src="{{ asset($partnerUrl->partner->img) }}">
                                @else
                                    <img class="img-responsive" alt="partners" src="{{ asset('images/site/200-default.jpg') }}">
                                @endif

                                </div>
                            </div>
                        @endforeach
                    @endif

                    @for($i = 4; $i > count($product->partnersUrl) % 4; $i--)
                        <div class="col-6 col-sm-4 col-md-3 partnet-list-item lead">

                            <div onclick="window.open('{{ route('site.contacts') }}')">

                                <img class="img-responsive" alt="partners" src="{{ asset('images/site/partners/empty.jpg') }}">

                                <div class="message">{{ __('Become a partner') }}</div>

                            </div>

                        </div>
                    @endfor
                </div>
            </div>
            <div class="modal-footer">
                <a class="button button-default button-sm button-icon font-weight-normal" data-dismiss="modal" style="font-size: 16px">{{ __('Close') }}</a>
            </div>
        </div>
    </div>
</div>
