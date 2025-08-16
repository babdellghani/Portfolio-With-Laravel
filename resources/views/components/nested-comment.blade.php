@props(['comment', 'blog', 'level' => 0])

<div class="comment__item {{ $level > 0 ? 'children' : '' }}"
    style="flex-direction: column; {{ $level > 0 ? 'margin-left: 110px;' : '' }}">
    <li class="comment__item {{ $level > 0 ? 'children' : '' }} align-items-center">
        <div class="comment__thumb">
            @if ($comment->user->avatar)
                <img src="{{ asset($comment->user->avatar) }}" alt="{{ $comment->user->name }}"
                    style="width: 80px; height: 80px; object-fit: cover;">
            @else
                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center"
                    style="width: 80px; height: 80px;">
                    <span class="text-white fw-bold">
                        {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                    </span>
                </div>
            @endif
        </div>
        <div class="comment__content w-100">
            <div class="comment__avatar__info">
                <div class="info">
                    <h4 class="title">{{ $comment->user->name }}</h4>
                    <span class="date">{{ $comment->created_at->format('d F Y') }}</span>
                    @if ($level > 0)
                        <span class="reply-to text-muted small">
                            @if ($comment->parent)
                                replying to {{ $comment->parent->user->name }}
                            @endif
                        </span>
                    @endif
                </div>

                <a href="#comment-form{{ $comment->id }}" class="reply">
                    <i class="far fa-reply-all"></i>
                </a>

            </div>
            <p>{{ $comment->content }}</p>
        </div>
        <div>
            <div class="post-share">
                <a href="{{ route('comment.like', $comment->id) }}"
                    onclick="event.preventDefault(); document.getElementById('like-form-{{ $comment->id }}').submit();"
                    style="align-items: center; display: flex; flex-direction: column; color: black;"
                    onmouseover="this.style.color='#0054FF';" onmouseout="this.style.color='black';">
                    <i class="fa{{ $comment->isLikedBy(Auth::user()) ? 's' : 'l' }} fa-heart"></i>
                    {{ $comment->likes_count }}
                </a>
            </div>
            <form id="like-form-{{ $comment->id }}" action="{{ route('comment.like', $comment->id) }}" method="POST"
                style="display: none;">
                @csrf
            </form>
        </div>
    </li>
    <!-- Reply Form -->
    <div class="comment__form" id="comment-form{{ $comment->id }}"
        style="display: none; width: -webkit-fill-available; padding-top: 20px !important; margin-top: 0px !important; {{ $level > 0 ? 'margin-left: 110px !important;' : '' }}">
        <div class="comment__title">
            <h4 class="title">Write your reply to {{ $comment->user->name }}</h4>
        </div>
        @auth
            <form action="{{ route('comments.store', $blog->slug) }}" method="POST">
                @csrf
                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                <textarea name="content" placeholder="Enter your reply to {{ $comment->user->name }}*" required></textarea>
                <button type="submit" class="btn">post reply</button>
            </form>
        @endauth
        @guest
            <div class="text-center">
                <p>You must be logged in to post a reply.</p>
                <div class="mt-3">
                    <a href="{{ route('login') }}" class="btn btn-primary me-2">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-primary">Register</a>
                </div>
            </div>
        @endguest
    </div>
</div>


<!-- Nested Replies -->
@if ($comment->replies && $comment->replies->isNotEmpty())
    @foreach ($comment->replies as $reply)
        <x-nested-comment :comment="$reply" :blog="$blog" :level="$level + 1" />
    @endforeach
@endif
