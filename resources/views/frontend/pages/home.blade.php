@extends('frontend.partials.master')
@section('title', 'Home')

@section('content')

    <!-- slider-area -->
    <section class="banner">
        <div class="container custom-container">
            <div class="row align-items-center justify-content-center justify-content-lg-between">
                <div class="col-lg-6 order-0 order-lg-2">
                    <div class="banner__img text-center text-xxl-end">
                        <img src="{{ $homeSlide->home_slide && str_starts_with($homeSlide->home_slide, 'defaults_images/') ? asset($homeSlide->home_slide) : asset('storage/' . $homeSlide->home_slide) }}"
                            alt="Slide Image" class="img-fluid">
                    </div>
                </div>
                <div class="col-xl-5 col-lg-6">
                    <div class="banner__content">
                        <h2 class="title wow fadeInUp" data-wow-delay=".2s">{!! $homeSlide->title !!}</h2>
                        <p class="wow fadeInUp" data-wow-delay=".4s">{!! $homeSlide->short_title !!}</p>
                        <a href="{{ route('about') }}" class="btn banner__btn wow fadeInUp" data-wow-delay=".6s">
                            <span>more about me</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="scroll__down">
            <a href="#aboutSection" class="scroll__link">Scroll down</a>
        </div>
        <div class="banner__video">
            <a href="{{ $homeSlide->video_url }}" class="popup-video"><i class="fas fa-play"></i></a>

    </section>

    <!-- slider-area-end -->

    <!-- about-area -->
    <section id="aboutSection" class="about">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <ul class="about__icons__wrap">
                        @forelse ($technologies as $technology)
                            <li>
                                <img class="light"
                                    src="{{ $technology->light_icon && str_starts_with($technology->light_icon, 'defaults_images/') ? asset($technology->light_icon) : asset('storage/' . $technology->light_icon) }}"
                                    alt="{{ $technology->name }}">
                                <img class="dark"
                                    src="{{ $technology->dark_icon && str_starts_with($technology->dark_icon, 'defaults_images/') ? asset($technology->dark_icon) : asset('storage/' . $technology->dark_icon) }}"
                                    alt="{{ $technology->name }}">
                            </li>
                        @empty
                            <li>
                                <img class="light" src="{{ asset('frontend/assets/img/icons/xd_light.png') }}"
                                    alt="XD">
                                <img class="dark" src="{{ asset('frontend/assets/img/icons/xd.png') }}" alt="XD">
                            </li>
                            <li>
                                <img class="light" src="{{ asset('frontend/assets/img/icons/skeatch_light.png') }}"
                                    alt="Sketch">
                                <img class="dark" src="{{ asset('frontend/assets/img/icons/skeatch.png') }}"
                                    alt="Sketch">
                            </li>
                            <li>
                                <img class="light" src="{{ asset('frontend/assets/img/icons/illustrator_light.png') }}"
                                    alt="Illustrator">
                                <img class="dark" src="{{ asset('frontend/assets/img/icons/illustrator.png') }}"
                                    alt="Illustrator">
                            </li>
                            <li>
                                <img class="light" src="{{ asset('frontend/assets/img/icons/hotjar_light.png') }}"
                                    alt="Hotjar">
                                <img class="dark" src="{{ asset('frontend/assets/img/icons/hotjar.png') }}"
                                    alt="Hotjar">
                            </li>
                            <li>
                                <img class="light" src="{{ asset('frontend/assets/img/icons/invision_light.png') }}"
                                    alt="Invision">
                                <img class="dark" src="{{ asset('frontend/assets/img/icons/invision.png') }}"
                                    alt="Invision">
                            </li>
                            <li>
                                <img class="light" src="{{ asset('frontend/assets/img/icons/photoshop_light.png') }}"
                                    alt="Photoshop">
                                <img class="dark" src="{{ asset('frontend/assets/img/icons/photoshop.png') }}"
                                    alt="Photoshop">
                            </li>
                            <li>
                                <img class="light" src="{{ asset('frontend/assets/img/icons/figma_light.png') }}"
                                    alt="Figma">
                                <img class="dark" src="{{ asset('frontend/assets/img/icons/figma.png') }}"
                                    alt="Figma">
                            </li>
                        @endforelse
                    </ul>
                </div>
                <div class="col-lg-6">
                    <div class="about__content">
                        <div class="section__title">
                            <span class="sub-title">01 - About me</span>
                            <h2 class="title">{{ $about->title }}</h2>
                        </div>
                        <div class="about__exp">
                            <div class="about__exp__icon">
                                <img src="{{ asset('defaults_images/about_icon.png') }}" alt="">
                            </div>
                            <div class="about__exp__content">
                                <p>{!! $about->short_title !!}</p>
                            </div>
                        </div>
                        <p class="desc">{!! $about->short_description !!}</p>
                        <a href="{{ $about->cv_file && str_starts_with($about->cv_file, 'defaults_images/') ? asset($about->cv_file) : asset('storage/' . $about->cv_file) }}"
                            class="btn" download="CV">Download my resume</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- about-area-end -->

    <!-- services-area -->
    <section class="services">
        <div class="container">
            <div class="services__title__wrap">
                <div class="row align-items-center justify-content-between">
                    <div class="col-xl-5 col-lg-6 col-md-8">
                        <div class="section__title">
                            <span class="sub-title">02 - my Services</span>
                            <h2 class="title">Creates amazing digital experiences</h2>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-6 col-md-4">
                        <div class="services__arrow"></div>
                    </div>
                </div>
            </div>
            <div class="row gx-0 services__active">
                @forelse ($services as $service)
                    <div class="col-xl-3">
                        <div class="services__item">
                            <div class="services__thumb">
                                <a href="{{ route('services.details', $service->slug) }}"><img
                                        src="{{ $service->image && str_starts_with($service->image, 'defaults_images/') ? asset($service->image) : asset('storage/' . $service->image) }}"
                                        alt="{{ $service->title }}" width="323" height="240"
                                        style="object-fit: cover;"></a>
                            </div>
                            <div class="services__content">
                                <div class="services__icon">
                                    <img class="light"
                                        src="{{ $service->icon && str_starts_with($service->icon, 'defaults_images/') ? asset($service->icon) : asset('storage/' . $service->icon) }}"
                                        alt="{{ $service->title }}">
                                    <img class="dark"
                                        src="{{ $service->icon && str_starts_with($service->icon, 'defaults_images/') ? asset($service->icon) : asset('storage/' . $service->icon) }}"
                                        alt="{{ $service->title }}">
                                </div>
                                <h3 class="title"><a
                                        href="{{ route('services.details', $service->slug) }}">{{ $service->title }}</a>
                                </h3>
                                <p>{!! $service->short_description !!}</p>
                                <a href="{{ route('services.details', $service->slug) }}" class="btn border-btn">
                                    <span>Read more</span></a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-xl-3">
                        <div class="services__item">
                            <div class="services__content">
                                <h3 class="title">No services found</h3>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    <!-- services-area-end -->

    <!-- work-process-area -->
    <section class="work__process">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-8">
                    <div class="section__title text-center">
                        <span class="sub-title">03 - Working Process</span>
                        <h2 class="title">A clear product design process is the basis of success</h2>
                    </div>
                </div>
            </div>
            <div class="row work__process__wrap">
                <div class="col">
                    <div class="work__process__item">
                        <span class="work__process_step">Step - 01</span>
                        <div class="work__process__icon">
                            <img class="light" src="{{ asset('frontend/assets/img/icons/wp_light_icon01.png') }}"
                                alt="">
                            <img class="dark" src="{{ asset('frontend/assets/img/icons/wp_icon01.png') }}"
                                alt="">
                        </div>
                        <div class="work__process__content">
                            <h4 class="title">Discover</h4>
                            <p>Initial ideas or inspiration & Establishment of user needs.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="work__process__item">
                        <span class="work__process_step">Step - 02</span>
                        <div class="work__process__icon">
                            <img class="light" src="{{ asset('frontend/assets/img/icons/wp_light_icon02.png') }}"
                                alt="">
                            <img class="dark" src="{{ asset('frontend/assets/img/icons/wp_icon02.png') }}"
                                alt="">
                        </div>
                        <div class="work__process__content">
                            <h4 class="title">Define</h4>
                            <p>Interpretation & Alignment of findings to project objectives.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="work__process__item">
                        <span class="work__process_step">Step - 03</span>
                        <div class="work__process__icon">
                            <img class="light" src="{{ asset('frontend/assets/img/icons/wp_light_icon03.png') }}"
                                alt="">
                            <img class="dark" src="{{ asset('frontend/assets/img/icons/wp_icon03.png') }}"
                                alt="">
                        </div>
                        <div class="work__process__content">
                            <h4 class="title">Develop</h4>
                            <p>Design-Led concept and Proposals hearted & assessed</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="work__process__item">
                        <span class="work__process_step">Step - 04</span>
                        <div class="work__process__icon">
                            <img class="light" src="{{ asset('frontend/assets/img/icons/wp_light_icon04.png') }}"
                                alt="">
                            <img class="dark" src="{{ asset('frontend/assets/img/icons/wp_icon04.png') }}"
                                alt="">
                        </div>
                        <div class="work__process__content">
                            <h4 class="title">Deliver</h4>
                            <p>Process outcomes finalised & Implemented</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- work-process-area-end -->

    <!-- portfolio-area -->
    <section class="portfolio">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-8">
                    <div class="section__title text-center">
                        <span class="sub-title">04 - Portfolio</span>
                        <h2 class="title">All creative work</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-content" id="portfolioTabContent">
            <div class="tab-pane show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                <div class="container">
                    <div class="row gx-0 justify-content-center">
                        <div class="col">
                            <div class="portfolio__active">
                                @forelse ($portfolio as $item)
                                    <div class="portfolio__item">
                                        <div class="portfolio__thumb">
                                            <img src="{{ $item->image && str_starts_with($item->image, 'defaults_images/') ? asset($item->image) : asset('storage/' . $item->image) }}"
                                                alt="{{ $item->title }}" width="1020" height="519"
                                                style="object-fit: cover;">
                                        </div>
                                        <div class="portfolio__overlay__content">
                                            <span>{{ $item->category[0] }}</span>
                                            <h4 class="title"><a
                                                    href="{{ route('portfolio.details', $item->slug) }}">{{ $item->title }}</a>
                                            </h4>
                                            <a href="{{ route('portfolio.details', $item->slug) }}" class="link">Case
                                                Study</a>
                                        </div>
                                    </div>
                                @empty
                                    <div class="portfolio__item">
                                        <div class="portfolio__thumb">
                                            <img src="{{ asset('frontend/assets/img/portfolio/portfolio_img01.jpg') }}"
                                                alt="">
                                        </div>
                                        <div class="portfolio__overlay__content">
                                            <span>No portfolio items found</span>
                                            <h4 class="title">No portfolio items available</h4>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- portfolio-area-end -->

    <!-- partner-area -->
    <section class="partner">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <ul class="partner__logo__wrap">
                        @forelse ($partners as $partner)
                            <li>
                                @if ($partner->website_url)
                                    <a href="{{ $partner->website_url }}" target="_blank">
                                @endif
                                <img class="light"
                                    src="{{ $partner->light_logo && str_starts_with($partner->light_logo, 'defaults_images/') ? asset($partner->light_logo) : asset('storage/' . $partner->light_logo) }}"
                                    alt="{{ $partner->name }}">
                                <img class="dark"
                                    src="{{ $partner->dark_logo && str_starts_with($partner->dark_logo, 'defaults_images/') ? asset($partner->dark_logo) : asset('storage/' . $partner->dark_logo) }}"
                                    alt="{{ $partner->name }}">
                                @if ($partner->website_url)
                                    </a>
                                @endif
                            </li>
                        @empty
                            <li>
                                <img class="light" src="{{ asset('frontend/assets/img/icons/partner_light01.png') }}"
                                    alt="">
                                <img class="dark" src="{{ asset('frontend/assets/img/icons/partner_01.png') }}"
                                    alt="">
                            </li>
                            <li>
                                <img class="light" src="{{ asset('frontend/assets/img/icons/partner_light02.png') }}"
                                    alt="">
                                <img class="dark" src="{{ asset('frontend/assets/img/icons/partner_02.png') }}"
                                    alt="">
                            </li>
                            <li>
                                <img class="light" src="{{ asset('frontend/assets/img/icons/partner_light03.png') }}"
                                    alt="">
                                <img class="dark" src="{{ asset('frontend/assets/img/icons/partner_03.png') }}"
                                    alt="">
                            </li>
                            <li>
                                <img class="light" src="{{ asset('frontend/assets/img/icons/partner_light04.png') }}"
                                    alt="">
                                <img class="dark" src="{{ asset('frontend/assets/img/icons/partner_04.png') }}"
                                    alt="">
                            </li>
                            <li>
                                <img class="light" src="{{ asset('frontend/assets/img/icons/partner_light05.png') }}"
                                    alt="">
                                <img class="dark" src="{{ asset('frontend/assets/img/icons/partner_05.png') }}"
                                    alt="">
                            </li>
                            <li>
                                <img class="light" src="{{ asset('frontend/assets/img/icons/partner_light06.png') }}"
                                    alt="">
                                <img class="dark" src="{{ asset('frontend/assets/img/icons/partner_06.png') }}"
                                    alt="">
                            </li>
                        @endforelse
                    </ul>
                </div>
                <div class="col-lg-6">
                    <div class="partner__content">
                        <div class="section__title">
                            <span class="sub-title">05 - partners</span>
                            <h2 class="title">I proud to have collaborated with some awesome companies</h2>
                        </div>
                        <p>I'm a bit of a digital product junky. Over the years, I've used hundreds of web and mobile apps
                            in different industries and verticals. Eventually, I decided that it would be a fun challenge to
                            try designing and building my own.</p>
                        <a href="{{ route('contact-us') }}" class="btn">Start a conversation</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- partner-area-end -->

    <!-- testimonial-area -->
    <section class="testimonial">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-6 order-0 order-lg-2">
                    <ul class="testimonial__avatar__img">
                        @forelse ($testimonials as $testimonial)
                            @if ($testimonial->image == null || $testimonial->image == '')
                                <li><img src="{{ asset('frontend/assets/img/images/testi_img01.png') }}"
                                        alt="Testimonial Image"></li>
                            @else
                                <li><img src="{{ $testimonial->image && str_starts_with($testimonial->image, 'defaults_images/') ? asset($testimonial->image) : asset('storage/' . $testimonial->image) }}"
                                        alt="{{ $testimonial->name }}" style="object-fit: cover;" width="100"
                                        height="100"></li>
                            @endif
                        @empty
                            <li><img src="{{ asset('frontend/assets/img/images/testi_img01.png') }}"
                                    alt="Testimonial Image">
                            </li>
                        @endforelse

                    </ul>
                </div>
                <div class="col-xl-5 col-lg-6">
                    <div class="testimonial__wrap">
                        <div class="section__title">
                            <span class="sub-title">06 - Client Feedback</span>
                            <h2 class="title">Happy clients feedback</h2>
                        </div>
                        <div class="testimonial__active">
                            @forelse ($testimonials as $testimonial)
                                <div class="testimonial__item">
                                    <div class="testimonial__icon">
                                        <i class="fas fa-quote-left"></i>
                                    </div>
                                    <div class="testimonial__content">
                                        <p>{{ $testimonial->message }}</p>
                                        <div class="testimonial__avatar">
                                            <span>{{ $testimonial->name }}</span>
                                            @if ($testimonial->title)
                                                <small class="text-muted d-block">{{ $testimonial->title }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="testimonial__item">
                                    <div class="testimonial__icon">
                                        <i class="fas fa-quote-left"></i>
                                    </div>
                                    <div class="testimonial__content">
                                        <p>We are motivated by the satisfaction of our clients. Put your trust in us &share
                                            in
                                            our H.Spond Asset Management is made up of a team of expert, committed and
                                            experienced people with a passion for financial markets. Our goal is to achieve
                                            continuous.</p>
                                        <div class="testimonial__avatar">
                                            <span>Default Client</span>
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                        <div class="testimonial__arrow"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- testimonial-area-end -->

    <!-- blog-area -->
    @if ($blogs && count($blogs) > 0)
        <section class="blog" style="padding-bottom: 10px !important;">
            <div class="container">
                <div class="row gx-0 justify-content-center">
                    @foreach ($blogs as $blog)
                        <div class="col-lg-4 col-md-6 col-sm-9">
                            <div class="blog__post__item">
                                <div class="blog__post__thumb">
                                    <a href="{{ route('blog.show', $blog->slug) }}"><img src="{{ asset($blog->image) }}"
                                            alt="{{ $blog->title }}"></a>
                                    <div class="blog__post__tags">
                                        @if ($blog->categories && count($blog->categories) > 0)
                                            <a
                                                href="{{ route('blog.index', ['category' => $blog->categories[0]->slug]) }}">{{ $blog->categories[0]->name }}</a>
                                        @else
                                            <a href="{{ route('blog.index') }}">Uncategorized</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="blog__post__content">
                                    <span class="date">{{ $blog->created_at->format('d F Y') }}</span>
                                    <h3 class="title"><a
                                            href="{{ route('blog.show', $blog->slug) }}">{{ $blog->title }}</a></h3>
                                    <a href="{{ route('blog.show', $blog->slug) }}" class="read__more">Read mORe</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="blog__button text-center">
                    <a href="{{ route('blog.index') }}" class="btn">more blog</a>
                </div>
            </div>
        </section>
    @endif
    <!-- blog-area-end -->


@endsection
