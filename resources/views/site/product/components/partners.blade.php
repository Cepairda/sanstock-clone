<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

                                <img class="img-responsive" alt="partners" src="{{ asset($partnerUrl->partner->img) }}">

                            </div>

                            </div>
                        @endforeach
                    @endif

                    <div class="col-6 col-sm-4 col-md-3 partnet-list-item lead">

                        <div onclick="window.open('{{ route('site.contacts') }}')">

                            <img class="img-responsive" alt="partners" src="{{ asset('images/site/partners/empty.jpg') }}">

                            <div class="message">{{ __('Become a partner') }}</div>

                        </div>

                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <div class="btn-link-block">
                    <a class="btn-link-block-g" data-dismiss="modal">Закрыть</a>
                </div>
            </div>
        </div>
    </div>
</div>
