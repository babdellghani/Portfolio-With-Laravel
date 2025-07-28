@extends('frontend.partials.master')
@section('title', 'Portfolio')

@section('content')
    <!-- breadcrumb-area -->
    <section class="breadcrumb__wrap">
        <div class="container custom-container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-8 col-md-10">
                    <div class="breadcrumb__wrap__content">
                        <h2 class="title">Services</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Services</li>
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
            <div class="portfolio__inner__active">
                @forelse ($services as $service)
                    <div class="portfolio__inner__item grid-item">
                        <div class="row gx-0 align-items-center">
                            <div class="col-lg-6 col-md-10">
                                <div class="portfolio__inner__thumb">
                                    <a href="{{ route('services.details', $service->slug) }}">
                                        <img src="{{ $service->image && str_starts_with($service->image, 'defaults_images/') ? asset($service->image) : asset('storage/' . $service->image) }}"
                                            alt="{{ $service->title }}" width="648" height="616">
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-10">
                                <div class="portfolio__inner__content">
                                    <h2 class="title"><a
                                            href="{{ route('services.details', $service->slug) }}">{{ $service->title }}</a>
                                    </h2>
                                    <p>{!! $service->short_description !!}</p>
                                    <a href="{{ route('services.details', $service->slug) }}" class="link">View Case Study</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                        <div class="portfolio__inner__item"></div>
                        <div class="row gx-0 align-items-center">
                            <div class="col-lg-6 col-md-10">
                                <div class="portfolio__inner__thumb">
                                    <img src="assets/img/portfolio/portfolio_thumb01.jpg" alt="No services available">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-10">
                                <div class="portfolio__inner__content">
                                    <h2 class="title">No Services Available</h2>
                                    <p>Currently, there are no services to display. Please check back later.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforelse
        </div>
        @if($services->hasPages())
            {{ $services->links('custom-pagination') }}
        @endif
        </div>
    </section>
    <!-- portfolio-area-end -->
@endsection