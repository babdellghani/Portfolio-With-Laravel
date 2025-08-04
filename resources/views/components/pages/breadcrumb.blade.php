@props(['title', 'active'])

<section class="breadcrumb__wrap">
    <div class="container custom-container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8 col-md-10">
                <div class="breadcrumb__wrap__content">
                    <h2 class="title">{{ $title }}</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $active }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="breadcrumb__wrap__icon">
        <ul>
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
</section>
