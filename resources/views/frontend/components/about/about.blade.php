<section class="about about__style__two">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="about__image">
                        <img src="{{ $about->about_image && str_starts_with($about->about_image, 'defaults_images/') ? asset($about->about_image) : asset('storage/' . $about->about_image) }}" alt="About Image" class="img-fluid">
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
                        <a href="{{ $about->cv_file && str_starts_with($about->cv_file, 'defaults_images/') ? asset($about->cv_file) : asset('storage/' . $about->cv_file) }}" class="btn" download="CV">Download my resume</a>
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
                                    aria-selected="false">awards</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="education-tab" data-bs-toggle="tab" data-bs-target="#education"
                                    type="button" role="tab" aria-controls="education"
                                    aria-selected="false">education</button>
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
                                                    <div class="progress-bar" role="progressbar" style="width: {{ $skill->value }}%;"
                                                        aria-valuenow="{{ $skill->value }}" aria-valuemin="0" aria-valuemax="100"><span
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
                                                    <img src="{{ $item->image && str_starts_with($item->image, 'defaults_images/') ? asset($item->image) : asset('storage/' . $item->image) }}" alt="">
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
                                                <span class="date">{{ $item->start_date }} – {{ $item->end_date }}</span>
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