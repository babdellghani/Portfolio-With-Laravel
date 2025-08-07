@extends('admin.partials.master')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <!-- Page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Dashboard</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row">
            <!-- Users Stats -->
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-1 overflow-hidden">
                                <p class="text-truncate font-size-14 mb-2">Total Users</p>
                                <h4 class="mb-0">{{ $stats['users']['total'] }}</h4>
                            </div>
                            <div class="text-primary">
                                <i class="ri-user-line font-size-24"></i>
                            </div>
                        </div>
                        <p class="text-muted mb-0">
                            <span class="text-success fw-bold font-size-12">
                                <i class="mdi mdi-arrow-top-right"></i> {{ $stats['users']['active'] }}
                            </span> Active Users
                        </p>
                    </div>
                </div>
            </div>

            <!-- Blogs Stats -->
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-1 overflow-hidden">
                                <p class="text-truncate font-size-14 mb-2">Total Blogs</p>
                                <h4 class="mb-0">{{ $stats['blogs']['total'] }}</h4>
                            </div>
                            <div class="text-success">
                                <i class="ri-article-line font-size-24"></i>
                            </div>
                        </div>
                        <p class="text-muted mb-0">
                            <span class="text-success fw-bold font-size-12">
                                <i class="mdi mdi-arrow-top-right"></i> {{ $stats['blogs']['published'] }}
                            </span> Published
                        </p>
                    </div>
                </div>
            </div>

            <!-- Comments Stats -->
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-1 overflow-hidden">
                                <p class="text-truncate font-size-14 mb-2">Total Comments</p>
                                <h4 class="mb-0">{{ $stats['comments']['total'] }}</h4>
                            </div>
                            <div class="text-info">
                                <i class="ri-chat-3-line font-size-24"></i>
                            </div>
                        </div>
                        <p class="text-muted mb-0">
                            <span class="text-warning fw-bold font-size-12">
                                <i class="mdi mdi-arrow-top-right"></i> {{ $stats['comments']['pending'] }}
                            </span> Pending
                        </p>
                    </div>
                </div>
            </div>

            <!-- Views Stats -->
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-1 overflow-hidden">
                                <p class="text-truncate font-size-14 mb-2">Total Views</p>
                                <h4 class="mb-0">{{ number_format($stats['blogs']['total_views']) }}</h4>
                            </div>
                            <div class="text-warning">
                                <i class="ri-eye-line font-size-24"></i>
                            </div>
                        </div>
                        <p class="text-muted mb-0">
                            <span class="text-success fw-bold font-size-12">
                                <i class="mdi mdi-arrow-top-right"></i> {{ $stats['interactions']['total_likes'] }}
                            </span> Total Likes
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts and Recent Activities -->
        <div class="row">
            <!-- Monthly Blog Chart -->
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <div class="d-sm-flex flex-wrap">
                            <h4 class="card-title mb-4">Monthly Blog Posts</h4>
                        </div>
                        <div id="monthly-blog-chart" class="apex-charts" dir="ltr"></div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Quick Actions</h4>
                        <div class="list-group list-group-flush">
                            <a href="{{ route('admin.blogs.create') }}" class="list-group-item list-group-item-action">
                                <i class="ri-add-circle-line me-2"></i> Create New Blog
                            </a>
                            <a href="{{ route('admin.categories.create') }}" class="list-group-item list-group-item-action">
                                <i class="ri-folder-add-line me-2"></i> Add Category
                            </a>
                            <a href="{{ route('admin.tags.create') }}" class="list-group-item list-group-item-action">
                                <i class="ri-price-tag-3-line me-2"></i> Add Tag
                            </a>
                            <a href="{{ route('admin.comments.index') }}" class="list-group-item list-group-item-action">
                                <i class="ri-chat-check-line me-2"></i> Moderate Comments
                            </a>
                            <a href="{{ route('admin.blogs.stats') }}" class="list-group-item list-group-item-action">
                                <i class="ri-bar-chart-line me-2"></i> View Statistics
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="row">
            <!-- Recent Blogs -->
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-sm-flex flex-wrap">
                            <h4 class="card-title mb-4">Recent Blog Posts</h4>
                            <div class="ms-auto">
                                <a href="{{ route('admin.blogs.index') }}" class="btn btn-sm btn-primary">View All</a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap mb-0">
                                <tbody>
                                    @forelse($recentBlogs as $blog)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0 me-3">
                                                        @if($blog->thumbnail)
                                                            <img src="{{ asset('storage/' . $blog->thumbnail) }}" alt=""
                                                                class="avatar-sm rounded">
                                                        @else
                                                            <div class="avatar-sm">
                                                                <span class="avatar-title rounded bg-primary">
                                                                    {{ strtoupper(substr($blog->title, 0, 1)) }}
                                                                </span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1">{{ Str::limit($blog->title, 40) }}</h6>
                                                        <p class="text-muted font-size-13 mb-0">By {{ $blog->user->name }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge badge-pill badge-soft-{{ $blog->status === 'published' ? 'success' : 'warning' }} font-size-12">
                                                    {{ ucfirst($blog->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <i class="ri-eye-line me-1"></i>{{ $blog->views }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">No recent blogs found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Comments -->
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-sm-flex flex-wrap">
                            <h4 class="card-title mb-4">Recent Comments</h4>
                            <div class="ms-auto">
                                <a href="{{ route('admin.comments.index') }}" class="btn btn-sm btn-primary">View
                                    All</a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap mb-0">
                                <tbody>
                                    @forelse($recentComments as $comment)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar-sm">
                                                            <span class="avatar-title rounded bg-info">
                                                                {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1">{{ $comment->user->name }}</h6>
                                                        <p class="text-muted font-size-13 mb-0">
                                                            {{ Str::limit($comment->content, 50) }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge badge-pill badge-soft-{{ $comment->status ? 'success' : 'warning' }} font-size-12">
                                                    {{ $comment->status ? 'Approved' : 'Pending' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center">No recent comments found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Statistics -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Content Overview</h4>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h5 class="text-primary">{{ $stats['content']['categories'] }}</h5>
                                    <p class="text-muted mb-0">Categories</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h5 class="text-success">{{ $stats['content']['tags'] }}</h5>
                                    <p class="text-muted mb-0">Tags</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h5 class="text-info">{{ $stats['interactions']['total_bookmarks'] }}</h5>
                                    <p class="text-muted mb-0">Bookmarks</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h5 class="text-warning">{{ $stats['interactions']['total_likes'] }}</h5>
                                    <p class="text-muted mb-0">Total Likes</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ApexCharts -->
    <script src="{{ asset('backend/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Monthly Blog Chart
            var chartData = @json($chartData);
            var options = {
                series: [{
                    name: 'Blog Posts',
                    data: chartData
                }],
                chart: {
                    type: 'area',
                    height: 350,
                    zoom: {
                        enabled: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                },
                colors: ['#556ee6'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.9,
                        stops: [0, 90, 100]
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#monthly-blog-chart"), options);
            chart.render();
        });
    </script>
@endsection