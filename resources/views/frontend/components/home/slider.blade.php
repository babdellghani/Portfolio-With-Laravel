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
                    <a href="about.html" class="btn banner__btn wow fadeInUp" data-wow-delay=".6s">more about me</a>
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
