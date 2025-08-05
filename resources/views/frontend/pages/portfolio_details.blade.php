@extends('frontend.partials.master')
@section('title', 'Portfolio Details')

@section('content')
    <!-- breadcrumb-area -->
    <x-pages.breadcrumb title="{{ $portfolio->title }}" active="Details" />
    <!-- breadcrumb-area-end -->

    <!-- portfolio-details-area -->
    <section class="services__details">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="services__details__thumb">
                        <img src="{{ $portfolio->image && str_starts_with($portfolio->image, 'defaults_images/') ? asset($portfolio->image) : asset('storage/' . $portfolio->image) }}"
                            alt="{{ $portfolio->title }}" width="850" height="430" style="object-fit: cover;">
                    </div>
                    <div class="services__details__content">
                        <h2 class="title">{{ $portfolio->title }}</h2>
                        <p>{!! $portfolio->description !!}</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <aside class="services__sidebar">
                        <div class="widget">
                            <h5 class="title">Get in Touch</h5>
                            <form action="#" class="sidebar__contact">
                                <input type="text" placeholder="Enter name*">
                                <input type="email" placeholder="Enter your mail*">
                                <textarea name="message" id="message" placeholder="Massage*"></textarea>
                                <button type="submit" class="btn">send massage</button>
                            </form>
                        </div>
                        <div class="widget">
                            <h5 class="title">Project Information</h5>
                            <ul class="sidebar__contact__info">
                                <li><span>Date :</span> {{ \Carbon\Carbon::parse($portfolio->date)->format('F, Y') }}</li>
                                <li><span>Location :</span> {{ $portfolio->location }}</li>
                                <li><span>Client :</span> {{ $portfolio->client }}</li>
                                <li class="cagegory"><span>Category :</span>
                                    @foreach ($portfolio->category as $category)
                                        <a href="{{ route('portfolio') }}">{{ $category }},</a>
                                    @endforeach
                                </li>
                                <li><span>Project Link :</span> <a href="{{ $portfolio->link }}">{{ $portfolio->link }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="widget">
                            <h5 class="title">Contact Information</h5>
                            <ul class="sidebar__contact__info">
                                <li><span>Address :</span>
                                    {{ $websiteInfo && $websiteInfo->address ? $websiteInfo->address : 'Level 13, 2 Elizabeth Steereyt set' }}
                                    {{ $websiteInfo && $websiteInfo->city ?  ', ' . $websiteInfo->city : ', Melbourne, Victoria 3000' }}
                                </li>
                                <li><span>Mail :</span>
                                    {{ $websiteInfo && $websiteInfo->email ? $websiteInfo->email : 'noreply@envato.com' }}
                                </li>
                                <li><span>Phone :</span>
                                    {{ $websiteInfo && $websiteInfo->phone ? $websiteInfo->phone : '+7464 0187 3535 645' }}
                                </li>
                            </ul>
                            <ul class="sidebar__contact__social">
                                @if ($websiteInfo && $websiteInfo->facebook_url)
                                    <li><a href="{{ $websiteInfo->facebook_url }}" target="_blank"><i
                                                class="fab fa-facebook-f"></i></a></li>
                                @endif
                                @if ($websiteInfo && $websiteInfo->twitter_url)
                                    <li><a href="{{ $websiteInfo->twitter_url }}" target="_blank"><i
                                                class="fab fa-twitter"></i></a></li>
                                @endif
                                @if ($websiteInfo && $websiteInfo->behance_url)
                                    <li><a href="{{ $websiteInfo->behance_url }}" target="_blank"><i
                                                class="fab fa-behance"></i></a></li>
                                @endif
                                @if ($websiteInfo && $websiteInfo->linkedin_url)
                                    <li><a href="{{ $websiteInfo->linkedin_url }}" target="_blank"><i
                                                class="fab fa-linkedin-in"></i></a></li>
                                @endif
                                @if ($websiteInfo && $websiteInfo->instagram_url)
                                    <li><a href="{{ $websiteInfo->instagram_url }}" target="_blank"><i
                                                class="fab fa-instagram"></i></a></li>
                                @endif
                                @if ($websiteInfo && $websiteInfo->youtube_url)
                                    <li><a href="{{ $websiteInfo->youtube_url }}" target="_blank"><i
                                                class="fab fa-youtube"></i></a></li>
                                @endif
                                @if ($websiteInfo && $websiteInfo->pinterest_url)
                                    <li><a href="{{ $websiteInfo->pinterest_url }}" target="_blank"><i
                                                class="fab fa-pinterest"></i></a></li>
                                @endif
                                @if (
                                    !$websiteInfo ||
                                        (!$websiteInfo->facebook_url &&
                                            !$websiteInfo->twitter_url &&
                                            !$websiteInfo->behance_url &&
                                            !$websiteInfo->linkedin_url &&
                                            !$websiteInfo->instagram_url &&
                                            !$websiteInfo->youtube_url &&
                                            !$websiteInfo->pinterest_url))
                                    <!-- Fallback static links -->
                                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fab fa-behance"></i></a></li>
                                    <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                    <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                    <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                                    <li><a href="#"><i class="fab fa-pinterest"></i></a></li>
                                @endif
                            </ul>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>
    <!-- portfolio-details-area-end -->
@endsection
