@extends('layouts.site')
@section('body_class', 'documents')

@if (isset($_GET['page']))
    @section('rel_alternate_pagination')
        <link rel="canonical"
              href="{{ strtok(LaravelLocalization::getLocalizedURL(), '?') }}"
        >
    @endsection
@endif

@section('content')

    @include('site.components.breadcrumbs')
    <section class="section-md bg-white">
    <div class="shell">
        <div class="posts-lists-masonry-3-cols">
            @foreach($posts as $post)
            <!-- Post classic-->
            <article class="post-classic post-minimal">
                <a href="{{ route('site.blog-post', ['slug' => $post->slug]) }}">
                    <img src="{{ asset('images/site/Blog/' . $post->slug . '.jpg') }}" alt="" width="418" height="315"/>
                </a>
                <div class="post-classic-title">
                    <h5><a href="{{ route('site.blog-post', ['slug' => $post->slug]) }}">{{ $post->name }}</a></h5>
                </div>
                <div class="post-meta">
                    <div class="group">
                        <a href="image-post.html"><time datetime="2017">{{ $post->created_at->format('d.m.Y') }}</time></a>
                        {{--<a class="meta-author" href="image-post.html">by Brian Williamson</a></div>--}}
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
    <section class="section-sm text-center">
        {!! $posts->links() !!}
    </section>

@endsection
