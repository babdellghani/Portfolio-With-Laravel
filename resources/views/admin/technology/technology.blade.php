@extends('admin.partials.master')

@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Technology Management</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Technologies</li>
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

                        <h4 class="card-title">Add New Technology</h4>

                        <form method="post" action="{{ route('technology.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Technology Name</label>
                                    <input name="name" class="form-control" type="text" value="{{ old('name') }}"
                                        id="name">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="type" class="form-label">Type</label>
                                    <select name="type" class="form-control" id="type">
                                        <option value="">Select Type</option>
                                        <option value="language" {{ old('type') == 'language' ? 'selected' : '' }}>
                                            Programming Language</option>
                                        <option value="framework" {{ old('type') == 'framework' ? 'selected' : '' }}>
                                            Framework</option>
                                        <option value="tool" {{ old('type') == 'tool' ? 'selected' : '' }}>Tool</option>
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
                                </div>
                                <div class="col-md-6">
                                    <label for="dark_icon" class="form-label">Dark Icon</label>
                                    <input name="dark_icon" class="form-control" type="file" id="dark_icon">
                                    @error('dark_icon')
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
                                            <input type="checkbox" id="square-switch3" value="1" switch="bool" name="status"
                                                @checked(old('status', true)) />
                                            <label for="square-switch3" data-on-label="Yes" data-off-label="No"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Light Icon Preview</label>
                                    <div>
                                        <img id="lightIconPreview" src="#" alt="Light Icon Preview"
                                            style="display: none; max-width: 50px; max-height: 50px; object-fit: contain;">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Dark Icon Preview</label>
                                    <div>
                                        <img id="darkIconPreview" src="#" alt="Dark Icon Preview"
                                            style="display: none; max-width: 50px; max-height: 50px; object-fit: contain;">
                                    </div>
                                </div>
                            </div>

                            <input type="submit" class="btn btn-info waves-effect waves-light" value="Add Technology">
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <!-- Technologies List -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">All Technologies</h4>

                        <table id="datatable" class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Light Icon</th>
                                    <th>Dark Icon</th>
                                    <th>Order</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($technologies as $technology)
                                    <tr>
                                        <td>{{ $technology->name }}</td>
                                        <td>
                                            <span
                                                class="badge badge-{{ $technology->type == 'language' ? 'primary' : ($technology->type == 'framework' ? 'success' : 'info') }}">
                                                {{ ucfirst($technology->type) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($technology->light_icon)
                                                <img src="{{ $technology->light_icon && str_starts_with($technology->light_icon, 'defaults_images/') ? asset($technology->light_icon) : asset('storage/' . $technology->light_icon) }}"
                                                    style="width: 30px; height: 30px; object-fit: contain;">
                                            @else
                                                <span class="badge badge-danger">No Icon</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($technology->dark_icon)
                                                <img src="{{ $technology->dark_icon && str_starts_with($technology->dark_icon, 'defaults_images/') ? asset($technology->dark_icon) : asset('storage/' . $technology->dark_icon) }}"
                                                    style="width: 30px; height: 30px; object-fit: contain;">
                                            @else
                                                <span class="badge badge-danger">No Icon</span>
                                            @endif
                                        </td>
                                        <td>{{ $technology->order }}</td>
                                        <td>
                                            <form method="POST"
                                                action="{{ route('technology.status', $technology->id) }}"
                                                style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="btn btn-sm {{ $technology->status ? 'btn-success' : 'btn-danger' }}"
                                                    onclick="return confirm('Are you sure?')">
                                                    {{ $technology->status ? 'Active' : 'Inactive' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <a href="{{ route('technology.edit', $technology->id) }}"
                                                class="btn btn-info sm" title="Edit Data">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST"
                                                action="{{ route('technology.destroy', $technology->id) }}"
                                                style="display: inline;"
                                                onsubmit="return confirm('Are you sure you want to delete this technology?');">
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

        document.getElementById('light_icon').addEventListener('change', function() {
            previewImage(this, 'lightIconPreview');
        });

        document.getElementById('dark_icon').addEventListener('change', function() {
            previewImage(this, 'darkIconPreview');
        });
    </script>
@endsection
