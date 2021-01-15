@foreach($comments as $comment)
    <div class="display-comment" @if($comment->parent_id != null) style="margin-left:40px;" @endif>
        <strong>{{ $comment->name }}</strong>
        <p>{{ $comment->body }}</p>
        <a href="" id="reply"></a>
        <form method="post" action="{{ route('site.comments.store') }}">
            @csrf
            <div class="form-group">
                <input type="text" name="details[name]" class="form-control" placeholder="{{ __('Name') }}" />
                <input type="text" name="details[email]" class="form-control" placeholder="Email" />
                <input type="text" name="details[phone]" class="form-control" placeholder="{{ __('Phone') }}" />
                <input type="text" name="details[body]" class="form-control" placeholder="{{ __('Comment') }}" />
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
