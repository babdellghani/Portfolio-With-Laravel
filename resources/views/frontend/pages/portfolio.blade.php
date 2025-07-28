@extends('frontend.partials.master')
@section('title', 'Portfolio')

@section('content')
    <!-- breadcrumb-area -->
    <section class="breadcrumb__wrap">
        <div class="container custom-container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-8 col-md-10">
                    <div class="breadcrumb__wrap__content">
                        <h2 class="title">Portfolio</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Portfolio</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="breadcrumb__wrap__icon">
            <ul>
                <li><img src="assets/img/icons/breadcrumb_icon01.png" alt=""></li>
                <li><img src="assets/img/icons/breadcrumb_icon02.png" alt=""></li>
                <li><img src="assets/img/icons/breadcrumb_icon03.png" alt=""></li>
                <li><img src="assets/img/icons/breadcrumb_icon04.png" alt=""></li>
                <li><img src="assets/img/icons/breadcrumb_icon05.png" alt=""></li>
                <li><img src="assets/img/icons/breadcrumb_icon06.png" alt=""></li>
            </ul>
        </div>
    </section>
    <!-- breadcrumb-area-end -->

    <!-- portfolio-area -->
    <section class="portfolio__inner">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="portfolio__inner__nav">
                        <button class="active" data-filter="*">all</button>
                        @foreach (\App\Models\Portfolio::getAllCategories() as $category)
                            <button data-filter=".{{ str_replace(' ', '_', $category) }}">{{ $category }}</button>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="portfolio__inner__active">
                @forelse ($portfolios as $portfolio)
                    <div
                        class="portfolio__inner__item grid-item {{ implode(' ', str_replace(' ', '_', $portfolio->category)) }}">
                        <div class="row gx-0 align-items-center">
                            <div class="col-lg-6 col-md-10">
                                <div class="portfolio__inner__thumb">
                                    <a href="{{ route('portfolio.details', $portfolio->slug) }}">
                                        <img src="{{ $portfolio->image && str_starts_with($portfolio->image, 'defaults_images/') ? asset($portfolio->image) : asset('storage/' . $portfolio->image) }}"
                                            alt="{{ $portfolio->title }}" width="648" height="616" style="object-fit: cover;">
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-10">
                                <div class="portfolio__inner__content">
                                    <h2 class="title"><a
                                            href="{{ route('portfolio.details', $portfolio->slug) }}">{{ $portfolio->title }}</a>
                                    </h2>
                                    <p>{!! $portfolio->short_description !!}</p>
                                    <a href="{{ route('portfolio.details', $portfolio->slug) }}" class="link">View Case
                                        Study</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="portfolio__inner__item">
                        <p>No portfolios available at the moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    <!-- portfolio-area-end -->
@endsection