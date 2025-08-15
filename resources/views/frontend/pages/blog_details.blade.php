@extends('frontend.partials.master')
@section('title', 'Blog Details')

@section('content')
    <!-- breadcrumb-area -->
    <x-pages.breadcrumb title="{{ $blog->title }}" active="Blogs Details" />
    <!-- breadcrumb-area-end -->


    <!-- blog-details-area -->
    <section class="standard__blog blog__details">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="standard__blog__post">
                        <div class="standard__blog__thumb">
                            <img src="assets/img/blog/blog_thumb01.jpg" alt="">
                        </div>
                        <div class="blog__details__content services__details__content">
                            <ul class="blog__post__meta">
                                <li><i class="fal fa-calendar-alt"></i>{{ $blog->created_at->format('d F Y') }}</li>
                                <li><i class="fal fa-comments-alt"></i> <a href="#comments">Comment
                                        ({{ $blog->comments_count }})</a></li>
                                <li class="post-share"><a href="{{ route('blog.like', $blog->id) }}"
                                        onclick="event.preventDefault(); document.getElementById('like-form-{{ $blog->id }}').submit();">
                                        <i class="fa{{ $userHasLiked ? 's' : 'l' }} fa-heart"></i>
                                        ({{ $blog->likes_count }})
                                    </a></li>
                                <form id="like-form-{{ $blog->id }}" action="{{ route('blog.like', $blog->slug) }}"
                                    method="POST" style="display: none;">
                                    @csrf
                                </form>
                                <li class="post-bookmark"><a href="{{ route('blog.bookmark', $blog->slug) }}"
                                        onclick="event.preventDefault(); document.getElementById('bookmark-form-{{ $blog->id }}').submit();">
                                        <i class="fa{{ $userHasBookmarked ? 's' : 'l' }} fa-bookmark"></i>
                                        Bookmark</a></li>
                                <form id="bookmark-form-{{ $blog->id }}"
                                    action="{{ route('blog.bookmark', $blog->slug) }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                                <li class="post-share"><a href="#" onclick="event.preventDefault(); sharePost()"><i
                                            class="fal fa-share-all"></i></a></li>
                            </ul>
                            <h2 class="title">{{ $blog->title }}</h2>
                            @if($blog->thumbnail)
                                <div class="blog__details__featured-image mb-4">
                                    <img src="{{ asset($blog->thumbnail) }}" alt="{{ $blog->title }}" class="img-fluid">
                                </div>
                            @endif
                            @if($blog->short_description)
                                <p class="lead">{{ $blog->short_description }}</p>
                            @endif
                            @if($blog->image)
                                <div class="blog__details__featured-image mb-4">
                                    <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" class="img-fluid">
                                </div>
                            @endif
                            @if($blog->excerpt)
                                <div class="blog__excerpt">
                                    <p><em>{{ $blog->excerpt }}</em></p>
                                </div>
                            @endif
                            @if($blog->description)
                                <div class="blog__description">
                                    {!! $blog->description !!}
                                </div>
                            @endif
                            @if($blog->content)
                                <div class="blog__content">
                                    {!! $blog->content !!}
                                </div>
                            @endif
                        </div>
                        <div class="blog__details__bottom">
                            <div class="d-flex flex-column align-items-start w-100">
                                @if ($blog->tags->isNotEmpty())
                                    <ul class="blog__details__tag w-100">
                                        <li class="title">Tag:</li>
                                        <li class="tags-list">
                                            @foreach ($blog->tags as $tag)
                                                <a
                                                    href="{{ route('blog.index', ['tag' => $tag->slug]) }}">{{ $tag->name }}</a>
                                            @endforeach
                                        </li>
                                    </ul>
                                @endif
                                @if ($blog->categories->isNotEmpty())
                                    <ul class="blog__details__tag w-100">
                                        <li class="title">Category:</li>
                                        <li class="tags-list">
                                            @foreach ($blog->categories as $category)
                                                <a
                                                    href="{{ route('blog.index', ['category' => $category->slug]) }}">{{ $category->name }}</a>
                                            @endforeach
                                        </li>
                                    </ul>
                                @endif
                            </div>
                            <ul class="blog__details__social">
                                <li class="title">Share :</li>
                                <li class="social-icons">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                                        target="_blank"><i class="fab fa-facebook"></i></a>
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($blog->title) }}"
                                        target="_blank"><i class="fab fa-twitter-square"></i></a>
                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->fullUrl()) }}"
                                        target="_blank"><i class="fab fa-linkedin"></i></a>
                                    <a href="https://pinterest.com/pin/create/button/?url={{ urlencode(request()->fullUrl()) }}&description={{ urlencode($blog->title) }}"
                                        target="_blank"><i class="fab fa-pinterest"></i></a>
                                </li>
                            </ul>
                        </div>
                        <div class="blog__next__prev">
                            <div class="row justify-content-between">
                                <div class="col-xl-5 col-md-6">
                                    <a href="{{ route('blog.show', $previousPost->slug) }}" class="blog__next__prev__item">
                                        <h4 class="title" style="transition: color 0.3s ease;" onmouseover="this.style.color='#007bff'" onmouseout="this.style.color=''">Previous Post</h4>
                                        <div class="blog__next__prev__post">
                                            <div class="blog__next__prev__thumb">
                                                <a href="{{ route('blog.show', $previousPost->slug) }}"><img src="{{ asset($previousPost->image) }}"
                                                        alt="{{ $previousPost->title }}"></a>
                                            </div>
                                            <div class="blog__next__prev__content">
                                                <h5 class="title"><a href="{{ route('blog.show', $previousPost->slug) }}">{{ $previousPost->title }}</a></h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-5 col-md-6">
                                    <a href="{{ route('blog.show', $nextPost->slug) }}" class="blog__next__prev__item next_post text-end">
                                        <h4 class="title" style="transition: color 0.3s ease;" onmouseover="this.style.color='#007bff'" onmouseout="this.style.color=''">Next Post</h4>
                                        <div class="blog__next__prev__post">
                                            <div class="blog__next__prev__thumb">
                                                <a href="{{ route('blog.show', $nextPost->slug) }}"><img src="{{ asset($nextPost->image) }}"
                                                        alt="{{ $nextPost->title }}"></a>
                                            </div>
                                            <div class="blog__next__prev__content">
                                                <h5 class="title"><a href="{{ route('blog.show', $nextPost->slug) }}">{{ $nextPost->title }}</a></h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="comment comment__wrap" id="comments">
                            <div class="comment__title">
                                <h4 class="title">Comment ({{ $blog->comments_count }})</h4>
                            </div>
                            <ul class="comment__list">
                                <li class="comment__item">
                                    <div class="comment__thumb">
                                        <img src="assets/img/blog/comment_thumb01.png" alt="">
                                    </div>
                                    <div class="comment__content">
                                        <div class="comment__avatar__info">
                                            <div class="info">
                                                <h4 class="title">Rohan De Spond</h4>
                                                <span class="date">25 january 2021</span>
                                            </div>
                                            <a href="#" class="reply"><i class="far fa-reply-all"></i></a>
                                        </div>
                                        <p>There are many variations of passages of Lorem Ipsum available, but the majority
                                            have. There are many variations of passages of Lorem Ipsum available, but the
                                            majority have</p>
                                    </div>
                                </li>
                                <li class="comment__item children">
                                    <div class="comment__thumb">
                                        <img src="assets/img/blog/comment_thumb02.png" alt="">
                                    </div>
                                    <div class="comment__content">
                                        <div class="comment__avatar__info">
                                            <div class="info">
                                                <h4 class="title">Johan Ritaxon</h4>
                                                <span class="date">25 january 2021</span>
                                            </div>
                                            <a href="#" class="reply"><i class="far fa-reply-all"></i></a>
                                        </div>
                                        <p>There are many variations of passages of Lorem Ipsum available, but the majority
                                            have. There are many variations of passages</p>
                                    </div>
                                </li>
                                <li class="comment__item">
                                    <div class="comment__thumb">
                                        <img src="assets/img/blog/comment_thumb03.png" alt="">
                                    </div>
                                    <div class="comment__content">
                                        <div class="comment__avatar__info">
                                            <div class="info">
                                                <h4 class="title">Alexardy Ditartina</h4>
                                                <span class="date">25 january 2021</span>
                                            </div>
                                            <a href="#" class="reply"><i class="far fa-reply-all"></i></a>
                                        </div>
                                        <p>There are many variations of passages of Lorem Ipsum available, but the majority
                                            have. There are many variations of passages of Lorem Ipsum available, but the
                                            majority have</p>
                                    </div>
                                </li>
                                <li class="comment__item children">
                                    <div class="comment__thumb">
                                        <img src="assets/img/blog/comment_thumb04.png" alt="">
                                    </div>
                                    <div class="comment__content">
                                        <div class="comment__avatar__info">
                                            <div class="info">
                                                <h4 class="title">Rashedul islam Kabir</h4>
                                                <span class="date">25 january 2021</span>
                                            </div>
                                            <a href="#" class="reply"><i class="far fa-reply-all"></i></a>
                                        </div>
                                        <p>There are many variations of passages of Lorem Ipsum available, but the majority
                                            have. There are many variations of passages</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="comment__form">
                            <div class="comment__title">
                                <h4 class="title">Write your comment</h4>
                            </div>
                            <form action="#">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" placeholder="Enter your name*">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="email" placeholder="Enter your mail*">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" placeholder="Enter your number*">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" placeholder="Website*">
                                    </div>
                                </div>
                                <textarea name="message" id="message" placeholder="Enter your Massage*"></textarea>
                                <div class="form-grp checkbox-grp">
                                    <input type="checkbox" id="checkbox">
                                    <label for="checkbox">Save my name, email, and website in this browser for the next
                                        time I comment.</label>
                                </div>
                                <button type="submit" class="btn">post a comment</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <aside class="blog__sidebar">
                        <div class="widget">
                            <form action="{{ route('blog.index') }}" method="GET" class="search-form">
                                <input type="text" name="search" placeholder="Search"
                                    value="{{ request('search') }}">
                                <button type="submit"><i class="fal fa-search"></i></button>
                            </form>
                        </div>
                        @if ($relatedPosts->isNotEmpty())
                            <div class="widget">
                                <h4 class="widget-title">Related Blogs</h4>
                                <ul class="rc__post">
                                    @foreach ($relatedPosts as $blog)
                                        <li class="rc__post__item">
                                            <div class="rc__post__thumb">
                                                <a href="{{ route('blog.show', $blog->slug) }}">
                                                    <img src="{{ asset($blog->thumbnail) }}" alt="{{ $blog->title }}">
                                                </a>
                                            </div>
                                            <div class="rc__post__content">
                                                <h5 class="title"><a
                                                        href="{{ route('blog.show', $blog->slug) }}">{{ $blog->title }}</a>
                                                </h5>
                                                <span class="post-date"><i class="fal fa-calendar-alt"></i>
                                                    {{ $blog->created_at->format('d F Y') }}</span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if ($categories->isNotEmpty())
                            <div class="widget">
                                <h4 class="widget-title">Categories</h4>
                                <ul class="sidebar__cat">
                                    @foreach ($categories as $category)
                                        <li class="sidebar__cat__item">
                                            <a href="{{ route('blog.index', ['category' => $category->slug]) }}"
                                                class="{{ request('category') == $category->slug ? 'active' : '' }}">
                                                {{ $category->name }} ({{ $category->blogs_count }})
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if ($comments->isNotEmpty())
                            <div class="widget">
                                <h4 class="widget-title">Recent Comment</h4>
                                <ul class="sidebar__comment">
                                    @foreach ($comments as $comment)
                                        <li class="sidebar__comment__item">
                                            <a
                                                href="{{ route('blog.show', $comment->blog->slug) }}">{{ $comment->user->name }}</a>
                                            <p>{{ $comment->content }}</p>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if ($tags->isNotEmpty())
                            <div class="widget">
                                <h4 class="widget-title">Popular Tags</h4>
                                <ul class="sidebar__tags">
                                    @foreach ($tags as $tag)
                                        <li><a href="{{ route('blog.index', ['tag' => $tag->slug]) }}"
                                                class="{{ request('tag') == $tag->slug ? 'active' : '' }}">{{ $tag->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </aside>
                </div>
            </div>
        </div>
    </section>
    <!-- blog-details-area-end -->

    @push('scripts')
        <script>
            function sharePost() {
                if (navigator.share) {
                    navigator.share({
                        title: '{{ $blog->title }}',
                        text: '{{ Str::limit(strip_tags($blog->content), 100) }}',
                        url: window.location.href
                    });
                } else {
                    // Fallback for browsers that don't support Web Share API
                    navigator.clipboard.writeText(window.location.href).then(() => {
                        alert('Link copied to clipboard!');
                    });
                }
            }
        </script>
    @endpush
@endsection
