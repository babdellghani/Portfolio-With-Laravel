@extends('frontend.partials.master')
@section('title', 'About')

@section('content')

    <!-- breadcrumb-area -->
    <x-pages.breadcrumb title="About Me" active="About Me" />
    <!-- breadcrumb-area-end -->

    <!-- about-area -->
    <section class="about about__style__two">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="about__image">
                        <img src="{{ $about->about_image && str_starts_with($about->about_image, 'defaults_images/') ? asset($about->about_image) : asset('storage/' . $about->about_image) }}"
                            alt="About Image" class="img-fluid">
                    </div>
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
                                <p><span>{!! $about->short_title !!}</p>
                            </div>
                        </div>
                        <p class="desc">{{ $about->short_description }}</p>
                        <a href="{{ $about->cv_file && str_starts_with($about->cv_file, 'defaults_images/') ? asset($about->cv_file) : asset('storage/' . $about->cv_file) }}"
                            class="btn" download="CV">Download my resume</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="about__info__wrap">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="about-tab" data-bs-toggle="tab" data-bs-target="#about"
                                    type="button" role="tab" aria-controls="about" aria-selected="true">About</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="skills-tab" data-bs-toggle="tab" data-bs-target="#skills"
                                    type="button" role="tab" aria-controls="skills"
                                    aria-selected="false">Skills</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="awards-tab" data-bs-toggle="tab" data-bs-target="#awards"
                                    type="button" role="tab" aria-controls="awards"
                                    aria-selected="false">Awards</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="education-tab" data-bs-toggle="tab" data-bs-target="#education"
                                    type="button" role="tab" aria-controls="education"
                                    aria-selected="false">Education</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="about" role="tabpanel"
                                aria-labelledby="about-tab">
                                {!! $about->long_description !!}
                            </div>
                            <div class="tab-pane fade" id="skills" role="tabpanel" aria-labelledby="skills-tab">
                                <div class="about__skill__wrap">
                                    <div class="row">
                                        @foreach ($skills as $skill)
                                            <div class="col-md-6">
                                                <div class="about__skill__item">
                                                    <h5 class="title">{{ $skill->name }}</h5>
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar"
                                                            style="width: {{ $skill->value }}%;"
                                                            aria-valuenow="{{ $skill->value }}" aria-valuemin="0"
                                                            aria-valuemax="100"><span
                                                                class="percentage">{{ $skill->value }}%</span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="awards" role="tabpanel" aria-labelledby="awards-tab">
                                <div class="about__award__wrap">
                                    <div class="row justify-content-center">
                                        @foreach ($award as $item)
                                            <div class="col-md-6 col-sm-9">
                                                <div class="about__award__item">
                                                    <div class="award__logo">
                                                        <img src="{{ $item->image && str_starts_with($item->image, 'defaults_images/') ? asset($item->image) : asset('storage/' . $item->image) }}"
                                                            alt="">
                                                    </div>
                                                    <div class="award__content">
                                                        <h5 class="title">{{ $item->title }} {{ $item->year }}</h5>
                                                        <p>{{ $item->description }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="education" role="tabpanel" aria-labelledby="education-tab">
                                <div class="about__education__wrap">
                                    <div class="row">
                                        @foreach ($education as $item)
                                            <div class="col-md-6">
                                                <div class="about__education__item">
                                                    <h3 class="title">{{ $item->name }}</h3>
                                                    <span class="date">{{ $item->start_date }} –
                                                        {{ $item->end_date }}</span>
                                                    <p>{{ $item->description }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- about-area-end -->

    <!-- services-area -->
    <section class="services__style__two">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="section__title text-center">
                        <span class="sub-title">02 - my Services</span>
                        <h2 class="title">Provide awesome service</h2>
                    </div>
                </div>
            </div>
            <div class="services__style__two__wrap">
                <div class="row gx-0">
                    @forelse ($service as $item)
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="services__style__two__item">
                                <div class="services__style__two__icon">
                                    <img src="{{ $item->icon && str_starts_with($item->icon, 'defaults_images/') ? asset($item->icon) : asset('storage/' . $item->icon) }}"
                                        alt="{{ $item->title }}">
                                </div>
                                <div class="services__style__two__content">
                                    <h3 class="title"><a
                                            href="{{ route('services.details', $item->slug) }}">{{ $item->title }}</a>
                                    </h3>
                                    <p>{!! $item->short_description !!}</p>
                                    <a href="{{ route('services.details', $item->slug) }}" class="services__btn"><i
                                            class="far fa-long-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p>No services found.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
    <!-- services-area-end -->

    <!-- testimonial-area -->
    <section class="testimonial testimonial__style__two">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-9 col-lg-11">
                    <div class="testimonial__wrap">
                        <div class="section__title text-center">
                            <span class="sub-title">06 - Client Feedback</span>
                            <h2 class="title">Some happy clients feedback</h2>
                        </div>
                        <div class="testimonial__two__active">
                            @forelse ($testimonials as $item)
                                <div class="testimonial__item">
                                    <div class="testimonial__icon">
                                        <i class="fas fa-quote-left"></i>
                                    </div>
                                    <div class="testimonial__content">
                                        <p>{{ $item->message }}</p>
                                        <div class="testimonial__avatar"
                                            style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                                            <span>{{ $item->name }}</span>
                                            <div class="testi__avatar__img"
                                                style="display: flex; align-items: center; justify-content: center; width: 70px; height: 70px; border-radius: 50%; overflow: hidden;">
                                                @if ($item->image == null || $item->image == '')
                                                    <img src="{{ asset('frontend/assets/img/images/testi_img01.png') }}"
                                                        alt="Testimonial Image">
                                                @else
                                                    <img src="{{ $item->image && str_starts_with($item->image, 'defaults_images/') ? asset($item->image) : asset('storage/' . $item->image) }}"
                                                        alt="{{ $item->name }}" width="70" height="70"
                                                        style="object-fit: cover;">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <p>No testimonials found.</p>
                                </div>
                            @endforelse
                        </div>
                        <div class="testimonial__arrow"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="testimonial__two__icons">
            <ul>
                <li><img src="assets/img/icons/testi_shape01.png" alt=""></li>
                <li><img src="assets/img/icons/testi_shape02.png" alt=""></li>
                <li><img src="assets/img/icons/testi_shape03.png" alt=""></li>
                <li><img src="assets/img/icons/testi_shape04.png" alt=""></li>
                <li><img src="assets/img/icons/testi_shape05.png" alt=""></li>
                <li><img src="assets/img/icons/testi_shape06.png" alt=""></li>
            </ul>
        </div>
    </section>
    <!-- testimonial-area-end -->

    <!-- blog-area -->
    @if ($blogs && count($blogs) > 0)
        <section class="blog blog__style__two" style="padding-bottom: 10px !important;">
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
