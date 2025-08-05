@extends('admin.partials.master')
@section('title', 'Partner Management')

@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Partner Management</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Partners</li>
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

                        <h4 class="card-title">Add New Partner</h4>

                        <form method="post" action="{{ route('partner.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Partner Name</label>
                                    <input name="name" class="form-control" type="text" value="{{ old('name') }}"
                                        id="name">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="website_url" class="form-label">Website URL (Optional)</label>
                                    <input name="website_url" class="form-control" type="url"
                                        value="{{ old('website_url') }}" id="website_url">
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
                                </div>
                                <div class="col-md-6">
                                    <label for="dark_logo" class="form-label">Dark Logo</label>
                                    <input name="dark_logo" class="form-control" type="file" id="dark_logo">
                                    @error('dark_logo')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="order" class="form-label">Order</label>
                                    <input name="order" class="form-control" type="number" value="{{ old('order', 0) }}"
                                        id="order">
                                    @error('order')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="status" class="form-label">Status</label>
                                    <div class="form-check form-switch">
                                        <div class="square-switch">
                                            <input type="checkbox" id="square-switch3" value="1" switch="bool"
                                                name="status" @checked(old('status', true)) />
                                            <label for="square-switch3" data-on-label="Yes" data-off-label="No"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Light Logo Preview</label>
                                    <div>
                                        <img id="lightLogoPreview" src="#" alt="Light Logo Preview"
                                            style="display: none; max-width: 100px; max-height: 100px; object-fit: contain;">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Dark Logo Preview</label>
                                    <div>
                                        <img id="darkLogoPreview" src="#" alt="Dark Logo Preview"
                                            style="display: none; max-width: 100px; max-height: 100px; object-fit: contain;">
                                    </div>
                                </div>
                            </div>

                            <input type="submit" class="btn btn-info waves-effect waves-light" value="Add Partner">
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <!-- Partners List -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">All Partners</h4>

                        <table id="datatable" class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Light Logo</th>
                                    <th>Dark Logo</th>
                                    <th>Order</th>
                                    <th>Status</th>
                                    <th>Website</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($partners as $partner)
                                    <tr>
                                        <td>{{ $partner->name }}</td>
                                        <td>
                                            @if ($partner->light_logo)
                                                <img src="{{ $partner->light_logo && str_starts_with($partner->light_logo, 'defaults_images/') ? asset($partner->light_logo) : asset('storage/' . $partner->light_logo) }}"
                                                    style="width: 50px; height: 50px; object-fit: contain;">
                                            @else
                                                <span class="badge badge-danger">No Image</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($partner->dark_logo)
                                                <img src="{{ $partner->dark_logo && str_starts_with($partner->dark_logo, 'defaults_images/') ? asset($partner->dark_logo) : asset('storage/' . $partner->dark_logo) }}"
                                                    style="width: 50px; height: 50px; object-fit: contain;">
                                            @else
                                                <span class="badge badge-danger">No Image</span>
                                            @endif
                                        </td>
                                        <td>{{ $partner->order }}</td>
                                        <td>
                                            <form method="POST" action="{{ route('partner.status', $partner->id) }}"
                                                style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="btn btn-sm {{ $partner->status ? 'btn-success' : 'btn-danger' }}"
                                                    onclick="return confirm('Are you sure?')">
                                                    {{ $partner->status ? 'Active' : 'Inactive' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            @if ($partner->website_url)
                                                <a href="{{ $partner->website_url }}" target="_blank"
                                                    class="btn btn-sm btn-info">Visit</a>
                                            @else
                                                <span class="text-muted">No URL</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('partner.edit', $partner->id) }}" class="btn btn-info sm"
                                                title="Edit Data">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('partner.destroy', $partner->id) }}"
                                                style="display: inline;"
                                                onsubmit="return confirm('Are you sure you want to delete this partner?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger sm" title="Delete Data">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

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
