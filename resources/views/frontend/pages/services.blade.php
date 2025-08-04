@extends('frontend.partials.master')
@section('title', 'Portfolio')

@section('content')
    <!-- breadcrumb-area -->
    <x-pages.breadcrumb title="Services" active="Services" />
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