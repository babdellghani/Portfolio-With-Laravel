@extends('frontend.partials.master')
@section('title', 'Contact')

@section('content')
    <!-- breadcrumb-area -->
    <x-pages.breadcrumb title="Contact Us" active="Contact" />
    <!-- breadcrumb-area-end -->

    <!-- contact-map -->
    <div id="contact-map">
        @if ($websiteInfo && $websiteInfo->contact_map)
            {!! $websiteInfo->contact_map !!}
        @else
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d96811.54759587669!2d-74.01263924803828!3d40.6880494567041!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25bae694479a3%3A0xb9949385da52e69e!2sBarclays%20Center!5e0!3m2!1sen!2sbd!4v1636195194646!5m2!1sen!2sbd"
                allowfullscreen loading="lazy"></iframe>
        @endif
    </div>
    <!-- contact-map-end -->

    <!-- contact-area -->
    <div class="contact-area">
        <div class="container">
            <form action="{{ route('contact.store') }}" method="POST" class="contact__form" id="contactForm">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="name" placeholder="Enter your name*" value="{{ old('name') }}"
                            required>
                        @error('name')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <input type="email" name="email" placeholder="Enter your mail*" value="{{ old('email') }}"
                            required>
                        @error('email')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <input type="text" name="phone" placeholder="Your Phone" value="{{ old('phone') }}">
                        @error('phone')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <textarea name="message" id="message" placeholder="Enter your message*" required>{{ old('message') }}</textarea>
                @error('message')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
                <button type="submit" class="btn" id="submitBtn">
                    <span class="btn-text">send message</span>
                    <span class="btn-loading" style="display: none;">
                        <i class="fa fa-spinner fa-spin"></i> Sending...
                    </span>
                </button>
            </form>
        </div>
    </div>
    <!-- contact-area-end -->

    <!-- contact-info-area -->
    <section class="contact-info-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6">
                    <div class="contact__info">
                        <div class="contact__info__icon">
                            <img src="assets/img/icons/contact_icon01.png" alt="">
                        </div>
                        <div class="contact__info__content">
                            <h4 class="title">address line</h4>
                            <span>
                                {{ $websiteInfo && $websiteInfo->address ? $websiteInfo->address : 'Level 13, 2 Elizabeth Steereyt set' }}
                                {{ $websiteInfo && $websiteInfo->city ? ', ' . $websiteInfo->city : ', Melbourne, Victoria 3000' }}
                                {{ $websiteInfo && $websiteInfo->country ? ', ' . strtoupper($websiteInfo->country) : ', AUSTRALIA' }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="contact__info">
                        <div class="contact__info__icon">
                            <img src="assets/img/icons/contact_icon02.png" alt="">
                        </div>
                        <div class="contact__info__content">
                            <h4 class="title">Phone Number</h4>
                            <span>{{ $websiteInfo && $websiteInfo->phone ? $websiteInfo->phone : '+81383 766 284' }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="contact__info">
                        <div class="contact__info__icon">
                            <img src="assets/img/icons/contact_icon03.png" alt="">
                        </div>
                        <div class="contact__info__content">
                            <h4 class="title">Mail Address</h4>
                            <span>{{ $websiteInfo && $websiteInfo->email ? $websiteInfo->email : 'noreply@envato.com' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- contact-info-area-end -->


@endsection
