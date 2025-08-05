@extends('admin.partials.master')
@section('title', 'Website Information')

@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Website Information</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Website Info</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Website Information Settings</h4>

                        <form method="post" action="{{ route('website-info.update', $websiteInfo->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Basic Information -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="text-primary">Basic Information</h5>
                                    <hr>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="site_name" class="form-label">Site Name</label>
                                    <input name="site_name" class="form-control" type="text"
                                        value="{{ old('site_name', $websiteInfo->site_name) }}" id="site_name">
                                    @error('site_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="site_title" class="form-label">Site Title</label>
                                    <input name="site_title" class="form-control" type="text"
                                        value="{{ old('site_title', $websiteInfo->site_title) }}" id="site_title">
                                    @error('site_title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="site_description" class="form-label">Site Description</label>
                                    <textarea name="site_description" class="form-control" rows="3" id="site_description">{{ old('site_description', $websiteInfo->site_description) }}</textarea>
                                    @error('site_description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Logo & Branding -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="text-primary">Logo & Branding</h5>
                                    <hr>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="logo_black" class="form-label">Black Logo</label>
                                    <input name="logo_black" class="form-control" type="file" id="logo_black">
                                    @error('logo_black')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <small class="text-muted">Leave empty to keep current logo</small>
                                </div>
                                <div class="col-md-4">
                                    <label for="logo_white" class="form-label">White Logo</label>
                                    <input name="logo_white" class="form-control" type="file" id="logo_white">
                                    @error('logo_white')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <small class="text-muted">Leave empty to keep current logo</small>
                                </div>
                                <div class="col-md-4">
                                    <label for="favicon" class="form-label">Favicon</label>
                                    <input name="favicon" class="form-control" type="file" id="favicon">
                                    @error('favicon')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <small class="text-muted">Leave empty to keep current favicon</small>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Current Black Logo</label>
                                    <div>
                                        @if ($websiteInfo->logo_black)
                                            <img src="{{ $websiteInfo->logo_black && str_starts_with($websiteInfo->logo_black, 'defaults_images/') ? asset($websiteInfo->logo_black) : asset('storage/' . $websiteInfo->logo_black) }}"
                                                alt="Black Logo"
                                                style="max-width: 150px; max-height: 80px; object-fit: contain;">
                                        @else
                                            <span class="text-muted">No black logo</span>
                                        @endif
                                    </div>
                                    <div class="mt-2">
                                        <img id="blackLogoPreview" src="#" alt="Black Logo Preview"
                                            style="display: none; max-width: 150px; max-height: 80px; object-fit: contain;">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Current White Logo</label>
                                    <div>
                                        @if ($websiteInfo->logo_white)
                                            <img src="{{ $websiteInfo->logo_white && str_starts_with($websiteInfo->logo_white, 'defaults_images/') ? asset($websiteInfo->logo_white) : asset('storage/' . $websiteInfo->logo_white) }}"
                                                alt="White Logo"
                                                style="max-width: 150px; max-height: 80px; object-fit: contain; background: #333; padding: 10px;">
                                        @else
                                            <span class="text-muted">No white logo</span>
                                        @endif
                                    </div>
                                    <div class="mt-2">
                                        <img id="whiteLogoPreview" src="#" alt="White Logo Preview"
                                            style="display: none; max-width: 150px; max-height: 80px; object-fit: contain; background: #333; padding: 10px;">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Current Favicon</label>
                                    <div>
                                        @if ($websiteInfo->favicon)
                                            <img src="{{ $websiteInfo->favicon && str_starts_with($websiteInfo->favicon, 'defaults_images/') ? asset($websiteInfo->favicon) : asset('storage/' . $websiteInfo->favicon) }}"
                                                alt="Favicon" style="max-width: 32px; max-height: 32px;">
                                        @else
                                            <span class="text-muted">No favicon</span>
                                        @endif
                                    </div>
                                    <div class="mt-2">
                                        <img id="faviconPreview" src="#" alt="Favicon Preview"
                                            style="display: none; max-width: 32px; max-height: 32px;">
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Information -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="text-primary">Contact Information</h5>
                                    <hr>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input name="phone" class="form-control" type="text"
                                        value="{{ old('phone', $websiteInfo->phone) }}" id="phone">
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input name="email" class="form-control" type="email"
                                        value="{{ old('email', $websiteInfo->email) }}" id="email">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea name="address" class="form-control" rows="3" id="address">{{ old('address', $websiteInfo->address) }}</textarea>
                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="country" class="form-label">Country</label>
                                    <input name="country" class="form-control" type="text"
                                        value="{{ old('country', $websiteInfo->country) }}" id="country">
                                    @error('country')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="city" class="form-label">City</label>
                                    <input name="city" class="form-control" type="text"
                                        value="{{ old('city', $websiteInfo->city) }}" id="city">
                                    @error('city')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Social Media -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="text-primary">Social Media Links</h5>
                                    <hr>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="facebook_url" class="form-label">Facebook URL</label>
                                    <input name="facebook_url" class="form-control" type="url"
                                        value="{{ old('facebook_url', $websiteInfo->facebook_url) }}" id="facebook_url">
                                    @error('facebook_url')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="twitter_url" class="form-label">Twitter URL</label>
                                    <input name="twitter_url" class="form-control" type="url"
                                        value="{{ old('twitter_url', $websiteInfo->twitter_url) }}" id="twitter_url">
                                    @error('twitter_url')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="instagram_url" class="form-label">Instagram URL</label>
                                    <input name="instagram_url" class="form-control" type="url"
                                        value="{{ old('instagram_url', $websiteInfo->instagram_url) }}"
                                        id="instagram_url">
                                    @error('instagram_url')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="linkedin_url" class="form-label">LinkedIn URL</label>
                                    <input name="linkedin_url" class="form-control" type="url"
                                        value="{{ old('linkedin_url', $websiteInfo->linkedin_url) }}" id="linkedin_url">
                                    @error('linkedin_url')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="youtube_url" class="form-label">YouTube URL</label>
                                    <input name="youtube_url" class="form-control" type="url"
                                        value="{{ old('youtube_url', $websiteInfo->youtube_url) }}" id="youtube_url">
                                    @error('youtube_url')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="behance_url" class="form-label">Behance URL</label>
                                    <input name="behance_url" class="form-control" type="url"
                                        value="{{ old('behance_url', $websiteInfo->behance_url) }}" id="behance_url">
                                    @error('behance_url')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="pinterest_url" class="form-label">Pinterest URL</label>
                                    <input name="pinterest_url" class="form-control" type="url"
                                        value="{{ old('pinterest_url', $websiteInfo->pinterest_url) }}"
                                        id="pinterest_url">
                                    @error('pinterest_url')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Contact Map -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="text-primary">Contact Map</h5>
                                    <hr>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="contact_map" class="form-label">Contact Map Embed Code</label>
                                    <textarea name="contact_map" class="form-control" rows="5" id="contact_map"
                                        placeholder="Paste your Google Maps embed iframe code here...">{{ old('contact_map', $websiteInfo->contact_map) }}</textarea>
                                    @error('contact_map')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <small class="text-muted">
                                        <strong>Instructions:</strong>
                                        1. Go to <a href="https://maps.google.com" target="_blank">Google Maps</a><br>
                                        2. Search for your location<br>
                                        3. Click "Share" → "Embed a map"<br>
                                        4. Copy the iframe code and paste it here
                                    </small>
                                </div>
                            </div>

                            <!-- Footer Content -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="text-primary">Footer Content</h5>
                                    <hr>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <label for="footer_text" class="form-label">Footer Text</label>
                                    <textarea name="footer_text" class="form-control" rows="3" id="footer_text">{{ old('footer_text', $websiteInfo->footer_text) }}</textarea>
                                    @error('footer_text')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="copyright_text" class="form-label">Copyright Text</label>
                                    <input name="copyright_text" class="form-control" type="text"
                                        value="{{ old('copyright_text', $websiteInfo->copyright_text) }}"
                                        id="copyright_text">
                                    @error('copyright_text')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-12">
                                    <input type="submit" class="btn btn-info waves-effect waves-light"
                                        value="Update Website Information">
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <script type="text/javascript">
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    document.getElementById(previewId).style.display = 'block';
                    document.getElementById(previewId).src = e.target.result;
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        document.getElementById('logo_black').addEventListener('change', function() {
            previewImage(this, 'blackLogoPreview');
        });

        document.getElementById('logo_white').addEventListener('change', function() {
            previewImage(this, 'whiteLogoPreview');
        });

        document.getElementById('favicon').addEventListener('change', function() {
            previewImage(this, 'faviconPreview');
        });
    </script>

@endsection
