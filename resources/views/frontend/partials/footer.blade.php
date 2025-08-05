<footer class="footer">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-4">
                <div class="footer__widget">
                    <div class="fw-title">
                        <h5 class="sub-title">Contact us</h5>
                        <h4 class="title">
                            {{ $websiteInfo && $websiteInfo->phone ? $websiteInfo->phone : '+81383 766 284' }}</h4>
                    </div>
                    <div class="footer__widget__text">
                        <p>{{ $websiteInfo && $websiteInfo->site_description ? $websiteInfo->site_description : 'Professional web developer with expertise in Laravel, React, and modern web technologies. Creating digital solutions that make a difference.' }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="footer__widget">
                    <div class="fw-title">
                        <h5 class="sub-title">my address</h5>
                        <h4 class="title">
                            {{ $websiteInfo && $websiteInfo->country ? strtoupper($websiteInfo->country) : 'AUSTRALIA' }}
                        </h4>
                    </div>
                    <div class="footer__widget__address">
                        <p>{{ $websiteInfo && $websiteInfo->address ? $websiteInfo->address : 'Level 13, 2 Elizabeth Steereyt set' }}
                            {{ $websiteInfo && $websiteInfo->city ? ', ' . $websiteInfo->city : ', Melbourne, Victoria 3000' }}
                        </p>
                        <a href="mailto:{{ $websiteInfo && $websiteInfo->email ? $websiteInfo->email : 'noreply@envato.com' }}"
                            class="mail">{{ $websiteInfo && $websiteInfo->email ? $websiteInfo->email : 'noreply@envato.com' }}</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="footer__widget">
                    <div class="fw-title">
                        <h5 class="sub-title">Follow me</h5>
                        <h4 class="title">socially connect</h4>
                    </div>
                    <div class="footer__widget__social">
                        <p>{{ $websiteInfo && $websiteInfo->footer_text ? $websiteInfo->footer_text : 'Lorem ipsum dolor sit amet enim.' }}
                            <br>
                            {{ $websiteInfo && $websiteInfo->site_title ? $websiteInfo->site_title : 'Etiam ullamcorper.' }}
                        </p>
                        <ul class="footer__social__list">
                            @if ($websiteInfo && $websiteInfo->facebook_url)
                                <li><a href="{{ $websiteInfo->facebook_url }}" target="_blank"><i
                                            class="fab fa-facebook-f"></i></a></li>
                            @endif
                            @if ($websiteInfo && $websiteInfo->twitter_url)
                                <li><a href="{{ $websiteInfo->twitter_url }}" target="_blank"><i
                                            class="fab fa-twitter"></i></a></li>
                            @endif
                            @if ($websiteInfo && $websiteInfo->behance_url)
                                <li><a href="{{ $websiteInfo->behance_url }}" target="_blank"><i
                                            class="fab fa-behance"></i></a></li>
                            @endif
                            @if ($websiteInfo && $websiteInfo->linkedin_url)
                                <li><a href="{{ $websiteInfo->linkedin_url }}" target="_blank"><i
                                            class="fab fa-linkedin-in"></i></a></li>
                            @endif
                            @if ($websiteInfo && $websiteInfo->instagram_url)
                                <li><a href="{{ $websiteInfo->instagram_url }}" target="_blank"><i
                                            class="fab fa-instagram"></i></a></li>
                            @endif
                            @if ($websiteInfo && $websiteInfo->youtube_url)
                                <li><a href="{{ $websiteInfo->youtube_url }}" target="_blank"><i
                                            class="fab fa-youtube"></i></a></li>
                            @endif
                            @if ($websiteInfo && $websiteInfo->pinterest_url)
                                <li><a href="{{ $websiteInfo->pinterest_url }}" target="_blank"><i
                                            class="fab fa-pinterest"></i></a></li>
                            @endif
                            @if (
                                !$websiteInfo ||
                                    (!$websiteInfo->facebook_url &&
                                        !$websiteInfo->twitter_url &&
                                        !$websiteInfo->behance_url &&
                                        !$websiteInfo->linkedin_url &&
                                        !$websiteInfo->instagram_url &&
                                        !$websiteInfo->youtube_url &&
                                        !$websiteInfo->pinterest_url))
                                <!-- Fallback static links -->
                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fab fa-behance"></i></a></li>
                                <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                                <li><a href="#"><i class="fab fa-pinterest"></i></a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright__wrap">
            <div class="row">
                <div class="col-12">
                    <div class="copyright__text text-center">
                        <p>{{ $websiteInfo && $websiteInfo->copyright_text ? $websiteInfo->copyright_text : 'Copyright @ Ab. Dev 2025 All right Reserved' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
