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
                    <img src="{{ $technology->light_icon && str_starts_with($technology->light_icon, 'defaults_images/') ? asset($technology->light_icon) : asset('storage/' . $technology->light_icon) }}"
                        alt="{{ $technology->name }}">
                </li>
            @empty
                <li>
                    <img src="{{ asset('frontend/assets/img/icons/xd_light.png') }}" alt="XD">
                </li>
                <li>
                    <img src="{{ asset('frontend/assets/img/icons/skeatch_light.png') }}" alt="Sketch">
                </li>
                <li>
                    <img src="{{ asset('frontend/assets/img/icons/illustrator_light.png') }}" alt="Illustrator">
                </li>
                <li>
                    <img src="{{ asset('frontend/assets/img/icons/hotjar_light.png') }}" alt="Hotjar">
                </li>
                <li>
                    <img src="{{ asset('frontend/assets/img/icons/invision_light.png') }}" alt="Invision">
                </li>
                <li>
                    <img src="{{ asset('frontend/assets/img/icons/photoshop_light.png') }}" alt="Photoshop">
                </li>
                <li>
                    <img src="{{ asset('frontend/assets/img/icons/figma_light.png') }}" alt="Figma">
                </li>
            @endforelse
        </ul>
    </div>
</section>
