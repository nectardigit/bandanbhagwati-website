<?php

use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

Route::get('/sitemap.xml', [SiteController::class, 'sitemap'])->name('sitemap');

Route::get('/', [SiteController::class, 'home'])->name('home');
Route::get('/about', [SiteController::class, 'about'])->name('about');

Route::get('/service', [SiteController::class, 'services'])->name('services');
Route::get('/services/{service}', [SiteController::class, 'serviceShow'])->name('services.show');

Route::get('/equipment', [SiteController::class, 'equipment'])->name('equipment');
Route::get('/equipment/{equipment}', [SiteController::class, 'equipmentShow'])->name('equipment.show');
Route::post('/equipment/{equipment}/enquiry', [SiteController::class, 'equipmentEnquiry'])->name('equipment.enquiry');

Route::get('/project', [SiteController::class, 'projects'])->name('projects');
Route::get('/projects/{project}', [SiteController::class, 'projectShow'])->name('projects.show');

Route::get('/team', [SiteController::class, 'team'])->name('team');

Route::get('/clients', [SiteController::class, 'clients'])->name('clients');

Route::get('/gallery', [SiteController::class, 'gallery'])->name('gallery');
Route::get('/gallery/{album}', [SiteController::class, 'albumShow'])->name('gallery.show');

Route::get('/blog', [SiteController::class, 'blog'])->name('blog');
Route::get('/blog/{blogPost}', [SiteController::class, 'blogShow'])->name('blog.show');

Route::get('/faq', [SiteController::class, 'faqs'])->name('faq');

Route::get('/page/{page}', [SiteController::class, 'page'])->name('page.show');

Route::get('/contact', [SiteController::class, 'contact'])->name('contact');
Route::post('/contact', [SiteController::class, 'contactSubmit'])->name('contact.submit');
Route::post('/newsletter', [SiteController::class, 'newsletterSubmit'])->name('newsletter.submit');

// Keep legacy detail URLs working (Route::redirect is route-cache safe; closures are not).
Route::redirect('/service-detail', '/service');
Route::redirect('/project-detail', '/project');
Route::redirect('/blog-detail', '/blog');

// unisharp/laravel-filemanager — media browser, protected by auth (same guard as the Filament panel).
Route::group(['prefix' => 'filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

// Clean page URLs (/<slug>) — MUST be last so real routes win first. Controller (not closure) so it's route-cache safe.
Route::fallback([SiteController::class, 'fallbackPage']);
