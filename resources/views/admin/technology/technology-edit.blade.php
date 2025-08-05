@extends('admin.partials.master')
@section('title', 'Edit Technology')

@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Edit Technology</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('technology') }}">Technologies</a></li>
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

                        <h4 class="card-title">Edit Technology: {{ $technology->name }}</h4>

                        <form method="post" action="{{ route('technology.update', $technology->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Technology Name</label>
                                    <input name="name" class="form-control" type="text"
                                        value="{{ old('name', $technology->name) }}" id="name">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="type" class="form-label">Type</label>
                                    <select name="type" class="form-control" id="type">
                                        <option value="">Select Type</option>
                                        <option value="language"
                                            {{ old('type', $technology->type) == 'language' ? 'selected' : '' }}>Programming
                                            Language</option>
                                        <option value="framework"
                                            {{ old('type', $technology->type) == 'framework' ? 'selected' : '' }}>Framework
                                        </option>
                                        <option value="tool"
                                            {{ old('type', $technology->type) == 'tool' ? 'selected' : '' }}>Tool</option>
                                    </select>
                                    @error('type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="light_icon" class="form-label">Light Icon</label>
                                    <input name="light_icon" class="form-control" type="file" id="light_icon">
                                    @error('light_icon')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <small class="text-muted">Leave empty to keep current icon</small>
                                </div>
                                <div class="col-md-6">
                                    <label for="dark_icon" class="form-label">Dark Icon</label>
                                    <input name="dark_icon" class="form-control" type="file" id="dark_icon">
                                    @error('dark_icon')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <small class="text-muted">Leave empty to keep current icon</small>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="order" class="form-label">Order</label>
                                    <input name="order" class="form-control" type="number"
                                        value="{{ old('order', $technology->order) }}" id="order">
                                    @error('order')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="status" class="form-label">Status</label>
                                    <div class="form-check form-switch">
                                        <div class="square-switch">
                                            <input type="checkbox" id="square-switch3" value="1" switch="bool" name="status"
                                                @checked(old('status', $technology->status)) />
                                            <label for="square-switch3" data-on-label="Yes" data-off-label="No"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Current Light Icon</label>
                                    <div>
                                        @if ($technology->light_icon)
                                            <img src="{{ $technology->light_icon && str_starts_with($technology->light_icon, 'defaults_images/') ? asset($technology->light_icon) : asset('storage/' . $technology->light_icon) }}"
                                                alt="Current Light Icon"
                                                style="max-width: 50px; max-height: 50px; object-fit: contain;">
                                        @else
                                            <span class="text-muted">No light icon</span>
                                        @endif
                                    </div>
                                    <label class="form-label mt-2">New Light Icon Preview</label>
                                    <div>
                                        <img id="lightIconPreview" src="#" alt="Light Icon Preview"
                                            style="display: none; max-width: 50px; max-height: 50px; object-fit: contain;">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Current Dark Icon</label>
                                    <div>
                                        @if ($technology->dark_icon)
                                            <img src="{{ $technology->dark_icon && str_starts_with($technology->dark_icon, 'defaults_images/') ? asset($technology->dark_icon) : asset('storage/' . $technology->dark_icon) }}"
                                                alt="Current Dark Icon"
                                                style="max-width: 50px; max-height: 50px; object-fit: contain;">
                                        @else
                                            <span class="text-muted">No dark icon</span>
                                        @endif
                                    </div>
                                    <label class="form-label mt-2">New Dark Icon Preview</label>
                                    <div>
                                        <img id="darkIconPreview" src="#" alt="Dark Icon Preview"
                                            style="display: none; max-width: 50px; max-height: 50px; object-fit: contain;">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-12">
                                    <input type="submit" class="btn btn-info waves-effect waves-light me-2"
                                        value="Update Technology">
                                    <a href="{{ route('technology') }}" class="btn btn-secondary waves-effect">Cancel</a>
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

        document.getElementById('light_icon').addEventListener('change', function() {
            previewImage(this, 'lightIconPreview');
        });

        document.getElementById('dark_icon').addEventListener('change', function() {
            previewImage(this, 'darkIconPreview');
        });
    </script>
@endsection
