<?php

use App\Http\Controllers\About\AboutController;
use App\Http\Controllers\About\AwardController;
use App\Http\Controllers\About\EducationController;
use App\Http\Controllers\About\SkillController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\TagController as AdminTagController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Home\HomeSlideController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TechnologyController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebsiteInfoController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// -------------- Frontend --------------- //
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', [AboutController::class, 'home'])->name('about');

Route::get('/services', [ServiceController::class, 'home'])->name('services');
Route::get('/services/{service:slug}', [ServiceController::class, 'details'])->name('services.details');

Route::get('/portfolio', [PortfolioController::class, 'home'])->name('portfolio');
Route::get('/portfolio/{portfolio:slug}', [PortfolioController::class, 'details'])->name('portfolio.details');

Route::get('/contact-us', function () {
    return view('frontend.pages.contact');
})->name('contact-us');

// Blog routes
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Blog interaction routes (require authentication)
Route::middleware('auth')->group(function () {
    // Comments
    Route::post('/blog/{blog}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Likes (AJAX routes)
    Route::post('/blog/{blog}/like', [LikeController::class, 'toggleBlog'])->name('blog.like');
    Route::post('/comment/{comment}/like', [LikeController::class, 'toggleComment'])->name('comment.like');

    // Bookmarks
    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
    Route::post('/blog/{blog}/bookmark', [BookmarkController::class, 'toggle'])->name('blog.bookmark');
    Route::delete('/bookmarks/{bookmark}', [BookmarkController::class, 'destroy'])->name('bookmarks.destroy');
});

// contact form
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// -------------- Admin --------------- //
Route::prefix('/admin')->group(function () {
    // dashboard
    Route::middleware(['auth', 'user.status'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    });

    // profile - accessible to both admin and users (but must be active)
    Route::middleware(['auth', 'user.status'])->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // user contact messages - accessible to users to see their own messages
        Route::get('/my-messages', [ContactController::class, 'userMessages'])->name('user.messages');
        Route::get('/my-messages/{contact}', [ContactController::class, 'userMessageShow'])->name('user.messages.show');

        // notification routes - accessible to all authenticated users
        Route::post('/notifications/{id}/read', function ($id) {
            Auth::user()->notifications()->where('id', $id)->first()?->markAsRead();
            return response()->json(['status' => 'success']);
        })->name('notifications.read');
        Route::post('/notifications/mark-all-read', function () {
            // Mark all user notifications as read
            Auth::user()->unreadNotifications()->update(['read_at' => now()]);

            // Mark all contact messages as read (only for admins)
            if (Auth::user()->isAdmin()) {
                \App\Models\Contact::where('is_read', false)->update(['is_read' => true]);
            }

            return response()->json(['status' => 'success', 'message' => 'All notifications marked as read']);
        })->name('notifications.mark-all-read');
    });

    // Admin-only routes
    Route::middleware(['auth', 'verified', 'admin'])->group(function () {

        // ---- home ---- //
        // home slide
        Route::controller(HomeSlideController::class)->group(function () {
            Route::get('/slide', 'index')->name('home.slide');
            Route::post('/slide', 'store')->name('home.slide.store');
        });

        // ---- about ---- //
        // about
        Route::get('/about', [AboutController::class, 'index'])->name('admin.about');
        Route::post('/about', [AboutController::class, 'store'])->name('about.store');

        // awards
        Route::get('/awards', [AwardController::class, 'index'])->name('award');
        Route::post('/awards', [AwardController::class, 'store'])->name('award.store');
        Route::get('/awards/edit/{award}', [AwardController::class, 'edit'])->name('award.edit');
        Route::put('/awards/update/{award}', [AwardController::class, 'update'])->name('award.update');
        Route::delete('/awards/delete/{award}', [AwardController::class, 'destroy'])->name('award.destroy');

        // education
        Route::get('/educations', [EducationController::class, 'index'])->name('education');
        Route::post('/educations', [EducationController::class, 'store'])->name('education.store');
        Route::get('/educations/edit/{education}', [EducationController::class, 'edit'])->name('education.edit');
        Route::put('/educations/update/{education}', [EducationController::class, 'update'])->name('education.update');
        Route::delete('/educations/delete/{education}', [EducationController::class, 'destroy'])->name('education.destroy');

        // skills
        Route::get('/skills', [SkillController::class, 'index'])->name('skill');
        Route::post('/skills', [SkillController::class, 'store'])->name('skill.store');
        Route::get('/skills/edit/{skill}', [SkillController::class, 'edit'])->name('skill.edit');
        Route::put('/skills/update/{skill}', [SkillController::class, 'update'])->name('skill.update');
        Route::delete('/skills/delete/{skill}', [SkillController::class, 'destroy'])->name('skill.destroy');

        // service
        Route::get('/services', [ServiceController::class, 'index'])->name('service');
        Route::post('/services', [ServiceController::class, 'store'])->name('service.store');
        Route::get('/services/edit/{service}', [ServiceController::class, 'edit'])->name('service.edit');
        Route::put('/services/update/{service}', [ServiceController::class, 'update'])->name('service.update');
        Route::delete('/services/delete/{service}', [ServiceController::class, 'destroy'])->name('service.destroy');

        // portfolio
        Route::get('/portfolios', [PortfolioController::class, 'index'])->name('admin.portfolio');
        Route::post('/portfolios', [PortfolioController::class, 'store'])->name('portfolio.store');
        Route::get('/portfolios/edit/{portfolio}', [PortfolioController::class, 'edit'])->name('portfolio.edit');
        Route::put('/portfolios/update/{portfolio}', [PortfolioController::class, 'update'])->name('portfolio.update');
        Route::patch('/portfolios/status/{portfolio}', [PortfolioController::class, 'status'])->name('portfolio.status');
        Route::delete('/portfolios/delete/{portfolio}', [PortfolioController::class, 'destroy'])->name('portfolio.destroy');

        // testimonials
        Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonial');
        Route::post('/testimonials', [TestimonialController::class, 'store'])->name('testimonial.store');
        Route::get('/testimonials/edit/{testimonial}', [TestimonialController::class, 'edit'])->name('testimonial.edit');
        Route::put('/testimonials/update/{testimonial}', [TestimonialController::class, 'update'])->name('testimonial.update');
        Route::patch('/testimonials/status/{testimonial}', [TestimonialController::class, 'status'])->name('testimonial.status');
        Route::delete('/testimonials/delete/{testimonial}', [TestimonialController::class, 'destroy'])->name('testimonial.destroy');

        // partners
        Route::get('/partners', [PartnerController::class, 'index'])->name('partner');
        Route::post('/partners', [PartnerController::class, 'store'])->name('partner.store');
        Route::get('/partners/edit/{partner}', [PartnerController::class, 'edit'])->name('partner.edit');
        Route::put('/partners/update/{partner}', [PartnerController::class, 'update'])->name('partner.update');
        Route::patch('/partners/status/{partner}', [PartnerController::class, 'status'])->name('partner.status');
        Route::delete('/partners/delete/{partner}', [PartnerController::class, 'destroy'])->name('partner.destroy');

        // technologies
        Route::get('/technologies', [TechnologyController::class, 'index'])->name('technology');
        Route::post('/technologies', [TechnologyController::class, 'store'])->name('technology.store');
        Route::get('/technologies/edit/{technology}', [TechnologyController::class, 'edit'])->name('technology.edit');
        Route::put('/technologies/update/{technology}', [TechnologyController::class, 'update'])->name('technology.update');
        Route::patch('/technologies/status/{technology}', [TechnologyController::class, 'status'])->name('technology.status');
        Route::delete('/technologies/delete/{technology}', [TechnologyController::class, 'destroy'])->name('technology.destroy');

        // website information
        Route::get('/website-info', [WebsiteInfoController::class, 'index'])->name('website-info');
        Route::put('/website-info/{websiteInfo}', [WebsiteInfoController::class, 'update'])->name('website-info.update');

        // contacts/messages
        Route::get('/contacts', [ContactController::class, 'index'])->name('contact');
        Route::get('/contacts/{contact}', [ContactController::class, 'show'])->name('contact.show');
        Route::post('/contacts/{contact}/reply', [ContactController::class, 'reply'])->name('contact.reply');
        Route::patch('/contacts/{contact}/mark-read', [ContactController::class, 'markAsRead'])->name('contact.mark-read');
        Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])->name('contact.destroy');

        // notification endpoints
        Route::get('/notifications/contacts', [ContactController::class, 'getNotifications'])->name('contact.notifications');

        // user management
        Route::resource('users', UserController::class);
        Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    
    }); // End admin middleware group


    Route::middleware(['auth', 'user.status', 'verified'])->group(function () {

        // blog management
        Route::get('/blogs', [AdminBlogController::class, 'index'])->name('admin.blogs.index');
        Route::get('/blogs/create', [AdminBlogController::class, 'create'])->name('admin.blogs.create');
        Route::post('/blogs', [AdminBlogController::class, 'store'])->name('admin.blogs.store');
        Route::get('/blogs/{blog}', [AdminBlogController::class, 'show'])->name('admin.blogs.show');
        Route::get('/blogs/{blog}/edit', [AdminBlogController::class, 'edit'])->name('admin.blogs.edit');
        Route::put('/blogs/{blog}', [AdminBlogController::class, 'update'])->name('admin.blogs.update');
        Route::delete('/blogs/{blog}', [AdminBlogController::class, 'destroy'])->name('admin.blogs.destroy');
        Route::patch('/blogs/{blog}/toggle-status', [AdminBlogController::class, 'toggleStatus'])->name('admin.blogs.toggle-status');
        Route::post('/blogs/bulk-action', [AdminBlogController::class, 'bulkAction'])->name('admin.blogs.bulk-action');
        Route::get('/blogs-stats', [AdminBlogController::class, 'stats'])->name('admin.blogs.stats');
        Route::post('/blogs/{blog}/duplicate', [AdminBlogController::class, 'duplicate'])->name('admin.blogs.duplicate');

        // category management
        Route::get('/categories', [AdminCategoryController::class, 'index'])->name('admin.categories.index');
        Route::get('/categories/create', [AdminCategoryController::class, 'create'])->name('admin.categories.create');
        Route::post('/categories', [AdminCategoryController::class, 'store'])->name('admin.categories.store');
        Route::get('/categories/{category}', [AdminCategoryController::class, 'show'])->name('admin.categories.show');
        Route::get('/categories/{category}/edit', [AdminCategoryController::class, 'edit'])->name('admin.categories.edit');
        Route::put('/categories/{category}', [AdminCategoryController::class, 'update'])->name('admin.categories.update');
        Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('admin.categories.destroy');
        Route::patch('/categories/{category}/toggle-status', [AdminCategoryController::class, 'toggleStatus'])->name('admin.categories.toggle-status');
        Route::post('/categories/bulk-action', [AdminCategoryController::class, 'bulkAction'])->name('admin.categories.bulk-action');

        // tag management
        Route::get('/tags', [AdminTagController::class, 'index'])->name('admin.tags.index');
        Route::get('/tags/create', [AdminTagController::class, 'create'])->name('admin.tags.create');
        Route::post('/tags', [AdminTagController::class, 'store'])->name('admin.tags.store');
        Route::get('/tags/{tag}', [AdminTagController::class, 'show'])->name('admin.tags.show');
        Route::get('/tags/{tag}/edit', [AdminTagController::class, 'edit'])->name('admin.tags.edit');
        Route::put('/tags/{tag}', [AdminTagController::class, 'update'])->name('admin.tags.update');
        Route::delete('/tags/{tag}', [AdminTagController::class, 'destroy'])->name('admin.tags.destroy');
        Route::patch('/tags/{tag}/toggle-status', [AdminTagController::class, 'toggleStatus'])->name('admin.tags.toggle-status');
        Route::post('/tags/bulk-action', [AdminTagController::class, 'bulkAction'])->name('admin.tags.bulk-action');

        // comment management
        Route::get('/comments', [AdminCommentController::class, 'index'])->name('admin.comments.index');
        Route::get('/comments/{comment}', [AdminCommentController::class, 'show'])->name('admin.comments.show');
        Route::get('/comments/{comment}/edit', [AdminCommentController::class, 'edit'])->name('admin.comments.edit');
        Route::put('/comments/{comment}', [AdminCommentController::class, 'update'])->name('admin.comments.update');
        Route::delete('/comments/{comment}', [AdminCommentController::class, 'destroy'])->name('admin.comments.destroy');
        Route::patch('/comments/{comment}/toggle-status', [AdminCommentController::class, 'toggleStatus'])->name('admin.comments.toggle-status');
        Route::patch('/comments/{comment}/approve', [AdminCommentController::class, 'approve'])->name('admin.comments.approve');
        Route::patch('/comments/{comment}/reject', [AdminCommentController::class, 'reject'])->name('admin.comments.reject');
        Route::post('/comments/bulk-action', [AdminCommentController::class, 'bulkAction'])->name('admin.comments.bulk-action');
    });
}); // End admin prefix group

require __DIR__ . '/auth.php';