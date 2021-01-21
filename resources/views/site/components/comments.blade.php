@foreach($comments as $comment)
    <div class="display-comment" @if($comment->parent_id != null) style="margin-left:40px;" @endif>
        @if($comment->parent_id == null)
            @include('site.components.stars-list', ['star' => $comment->star])
        @endif
        <strong>{{ $comment->name }}</strong>
        <p>{{ $comment->body }}</p>
        <!--a href="" id="reply"></a-->
        <p class="reply-comment-show"><a href="#">{{ __('Reply to comment') }}</a></p>
        <form class="reply-comment" style="display: none;" method="post" enctype="multipart/form-data" action="{{ route('site.comments.store') }}">
            @csrf
            <div class="form-group mb-2">
                <input type="text" name="details[name]" class="form-control" required="required" placeholder="{{ __('Name') }}" />
            </div>
            <div class="form-group mb-2">
                <input type="email" name="details[email]" class="form-control" required="required" placeholder="Email" />
            </div>
            <div class="form-group mb-2">
                <input type="tel" name="details[phone]" class="form-control" required="required" placeholder="{{ __('Phone') }}" />
            </div>
            <div class="form-group mb-2">
                <textarea class="form-control" name="details[body]" placeholder="{{ __('Comment') }}"></textarea>
            </div>
            <div class="form-group mb-2">
                <input type="file" name="attachment[]" class="filer_input" data-jfiler-limit="3" data-jfiler-fileMaxSize="2" multiple="multiple" data-jfiler-options='{"language": "{{ LaravelLocalization::getCurrentLocale() }}"}'>
                <input type="hidden" name="details[resource_id]" value="{{ $resourceId }}" />
                <input type="hidden" name="parent_id" value="{{ $comment->id }}" />
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-warning" value="{{ __('Reply') }}" />
            </div>
        </form>
        @include('site.components.comments', ['comments' => $comment->replies])
    </div>
@endforeach
