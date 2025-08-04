@extends('admin.partials.master')

@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Edit Partner</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('partner') }}">Partners</a></li>
                            <li class="breadcrumb-item active">Edit</li>
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

                        <h4 class="card-title">Edit Partner: {{ $partner->name }}</h4>

                        <form method="post" action="{{ route('partner.update', $partner->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Partner Name</label>
                                    <input name="name" class="form-control" type="text"
                                        value="{{ old('name', $partner->name) }}" id="name">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="website_url" class="form-label">Website URL (Optional)</label>
                                    <input name="website_url" class="form-control" type="url"
                                        value="{{ old('website_url', $partner->website_url) }}" id="website_url">
                                    @error('website_url')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="light_logo" class="form-label">Light Logo</label>
                                    <input name="light_logo" class="form-control" type="file" id="light_logo">
                                    @error('light_logo')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <small class="text-muted">Leave empty to keep current logo</small>
                                </div>
                                <div class="col-md-6">
                                    <label for="dark_logo" class="form-label">Dark Logo</label>
                                    <input name="dark_logo" class="form-control" type="file" id="dark_logo">
                                    @error('dark_logo')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <small class="text-muted">Leave empty to keep current logo</small>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="order" class="form-label">Order</label>
                                    <input name="order" class="form-control" type="number"
                                        value="{{ old('order', $partner->order) }}" id="order">
                                    @error('order')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="status" class="form-label">Status</label>
                                    <div class="form-check form-switch">
                                        <div class="square-switch">
                                            <input type="checkbox" id="square-switch3" value="1" switch="bool" name="status"
                                                @checked(old('status', $partner->status)) />
                                            <label for="square-switch3" data-on-label="Yes" data-off-label="No"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Current Light Logo</label>
                                    <div>
                                        @if ($partner->light_logo)
                                            <img src="{{ $partner->light_logo && str_starts_with($partner->light_logo, 'defaults_images/') ? asset($partner->light_logo) : asset('storage/' . $partner->light_logo) }}"
                                                alt="Current Light Logo"
                                                style="max-width: 100px; max-height: 100px; object-fit: contain;">
                                        @else
                                            <span class="text-muted">No light logo</span>
                                        @endif
                                    </div>
                                    <label class="form-label mt-2">New Light Logo Preview</label>
                                    <div>
                                        <img id="lightLogoPreview" src="#" alt="Light Logo Preview"
                                            style="display: none; max-width: 100px; max-height: 100px; object-fit: contain;">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Current Dark Logo</label>
                                    <div>
                                        @if ($partner->dark_logo)
                                            <img src="{{ $partner->dark_logo && str_starts_with($partner->dark_logo, 'defaults_images/') ? asset($partner->dark_logo) : asset('storage/' . $partner->dark_logo) }}"
                                                alt="Current Dark Logo"
                                                style="max-width: 100px; max-height: 100px; object-fit: contain;">
                                        @else
                                            <span class="text-muted">No dark logo</span>
                                        @endif
                                    </div>
                                    <label class="form-label mt-2">New Dark Logo Preview</label>
                                    <div>
                                        <img id="darkLogoPreview" src="#" alt="Dark Logo Preview"
                                            style="display: none; max-width: 100px; max-height: 100px; object-fit: contain;">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-12">
                                    <input type="submit" class="btn btn-info waves-effect waves-light me-2"
                                        value="Update Partner">
                                    <a href="{{ route('partner') }}" class="btn btn-secondary waves-effect">Cancel</a>
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

        document.getElementById('light_logo').addEventListener('change', function() {
            previewImage(this, 'lightLogoPreview');
        });

        document.getElementById('dark_logo').addEventListener('change', function() {
            previewImage(this, 'darkLogoPreview');
        });
    </script>
@endsection
