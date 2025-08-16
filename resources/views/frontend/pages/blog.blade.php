@extends('frontend.partials.master')
@section('title', 'Blog')

@push('style')
    <style>
        .sidebar__cat__item a.active {
            color: #007bff;
            font-weight: bold;
        }

        .sidebar__tags li a.active {
            color: #007bff;
            font-weight: bold;
        }
    </style>
@endpush

@section('content')
    <!-- breadcrumb-area -->
    <x-pages.breadcrumb title="Recent Article" active="Blogs" />
    <!-- breadcrumb-area-end -->


    <!-- blog-area -->
    <section class="standard__blog">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    @forelse ($blogs as $blog)
                        <div class="standard__blog__post">
                            <div class="standard__blog__thumb">
                                <a href="{{ route('blog.show', $blog->slug) }}"><img src="{{ asset($blog->thumbnail) }}"
                                        alt="{{ $blog->title }}"></a>
                                <a href="{{ route('blog.show', $blog->slug) }}" class="blog__link"><i
                                        class="far fa-long-arrow-right"></i></a>
                            </div>
                            <div class="standard__blog__content">
                                <div class="blog__post__avatar">
                                    <div class="thumb"><img src="{{ asset($blog->user->avatar) }}"
                                            alt="{{ $blog->user->name }}"></div>
                                    <span class="post__by">By : <a href="#">{{ $blog->user->name }}</a></span>
                                </div>
                                <h2 class="title"><a href="{{ route('blog.show', $blog->slug) }}">{{ $blog->title }}</a>
                                </h2>
                                <p>{{ $blog->excerpt }}</p>
                                <ul class="blog__post__meta">
                                    <li><i class="fal fa-calendar-alt"></i> {{ $blog->created_at->format('d F Y') }}</li>
                                    <li><i class="fal fa-comments-alt"></i> <a
                                            href="{{ route('blog.show', $blog->slug) }}">{{ $blog->comments_count }}
                                            Comment</a></li>
                                    <li><i class="fal fa-eye"></i>{{ $blog->views }}</li>
                                    <li class="post-share"><a href="{{ route('blog.like', $blog->id) }}"
                                            onclick="event.preventDefault(); document.getElementById('like-form-{{ $blog->id }}').submit();">
                                            <i
                                                class="fa{{ $blog->likes->contains('user_id', auth()->id()) ? 's' : 'l' }} fa-heart"></i>
                                            {{ $blog->likes_count }}
                                        </a></li>
                                    <form id="like-form-{{ $blog->id }}"
                                        action="{{ route('blog.like', $blog->slug) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                    <li class="post-bookmark"><a href="{{ route('blog.bookmark', $blog->slug) }}"
                                            onclick="event.preventDefault(); document.getElementById('bookmark-form-{{ $blog->id }}').submit();">
                                            <i
                                                class="fa{{ $blog->bookmarks->contains('user_id', auth()->id()) ? 's' : 'l' }} fa-bookmark"></i>
                                        </a></li>
                                    <form id="bookmark-form-{{ $blog->id }}"
                                        action="{{ route('blog.bookmark', $blog->slug) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </ul>
                            </div>
                        </div>
                    @empty
                        <p>No blogs found.</p>
                    @endforelse
                    @if ($blogs->hasPages())
                        {{ $blogs->links('custom-pagination') }}
                    @endif
                </div>
                <div class="col-lg-4">
                    <aside class="blog__sidebar">
                        <div class="widget">
                            <form action="{{ route('blog.index') }}" method="GET" class="search-form">
                                <input type="text" name="search" placeholder="Search" value="{{ request('search') }}">
                                <button type="submit"><i class="fal fa-search"></i></button>
                            </form>
                        </div>
                        @if ($recentBlogs->isNotEmpty())
                            <div class="widget">
                                <h4 class="widget-title">Recent Blog</h4>
                                <ul class="rc__post">
                                    @foreach ($recentBlogs as $blog)
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
    <!-- blog-area-end -->

@endsection
