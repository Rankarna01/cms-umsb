<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// --- CONTROLLER ---
// Dikelompokkan agar rapi
use App\Http\Controllers\Admin\{
    AlbumController,
    AnnouncementController,
    DashboardController,
    DocumentCategoryController,
    DocumentController,
    FactoidController,
    FacultyController,
    ImageUploadController,
    LeaderController,
    LecturerController as AdminLecturerController,
    MenuController,
    MenuItemController,
    EventController as AdminEventController,
    PageController as AdminPageController,
    PartnerController,
    PhotoController,
    PostCategoryController,
    PostController as AdminPostController,
    QuickLinkController,
    RoleController,
    SettingController,
    SliderController,
    StudyProgramController,
    UserController,
    VideoController,
    SlideImageController,
    TestimonialController,
    AcademicServiceController
};
use App\Http\Controllers\Frontend\{
    GalleryController,
    HomeController,
    AnnouncementController as FrontendAnnouncementController,
    EventController as FrontendEventController,
    LecturerController as FrontendLecturerController,
    PageController as FrontendPageController,
    PostController as FrontendPostController
};


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- ROUTE UNTUK PENGUNJUNG (FRONTEND) ---
Route::redirect('/', '/home');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/berita', [FrontendPostController::class, 'index'])->name('posts.index');
Route::get('/pmb', [FrontendPageController::class, 'showPmb'])->name('page.pmb');
Route::get('/berita/{slug}', [FrontendPostController::class, 'show'])->name('posts.show');
Route::get('/halaman/{slug}', [FrontendPageController::class, 'show'])->name('pages.show');
Route::get('/galeri', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/dosen', [FrontendLecturerController::class, 'index'])->name('lecturers.index');
Route::get('/dosen/{lecturer}', [FrontendLecturerController::class, 'show'])->name('lecturers.show');
Route::get('/pengumuman/{announcement:slug}', [FrontendAnnouncementController::class, 'show'])->name('announcements.show');
Route::get('/agenda/{event:slug}', [FrontendEventController::class, 'show'])->name('event.show');


// --- ROUTE UNTUK SISTEM LOGIN & ADMIN ---
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // === GROUP ROUTE UNTUK SEMUA MENU ADMIN ===
    Route::prefix('admin')->name('admin.')->group(function () {
        // --- Route Resource (CRUD Standar) ---
        Route::resource('posts', AdminPostController::class);
        Route::resource('pages', AdminPageController::class);
        Route::resource('categories', PostCategoryController::class);
        Route::resource('sliders', SliderController::class);
        Route::delete('/slide-images/{image}', [SlideImageController::class, 'destroy'])
        ->name('slide-images.destroy');
        Route::resource('announcements', AnnouncementController::class);
        Route::resource('faculties', FacultyController::class);
        Route::resource('study-programs', StudyProgramController::class);
        Route::resource('lecturers', AdminLecturerController::class);
        Route::resource('document-categories', DocumentCategoryController::class);
        Route::resource('documents', DocumentController::class);
        Route::resource('albums', AlbumController::class)->only(['index', 'create', 'store', 'destroy']);
        Route::resource('photos', PhotoController::class)->only(['index', 'create', 'store', 'destroy']);
        Route::resource('videos', VideoController::class);
        Route::resource('quick-links', QuickLinkController::class);
        Route::resource('factoids', FactoidController::class);
        Route::resource('partners', PartnerController::class);
        Route::resource('leaders', LeaderController::class);
        Route::resource('users', UserController::class)->middleware('role:Super Admin');
        Route::resource('testimonials', TestimonialController::class);
        Route::resource('academic-services', AcademicServiceController::class);

        // --- Route Custom (Non-Resource) ---
        Route::post('images/upload', [ImageUploadController::class, 'store'])->name('images.upload');

        Route::get('users/{user}/permissions', [UserController::class, 'editPermissions'])
            ->name('users.permissions.edit')
            ->middleware('role:Super Admin');

        Route::put('users/{user}/permissions', [UserController::class, 'updatePermissions'])
            ->name('users.permissions.update')
            ->middleware('role:Super Admin');

        Route::prefix('roles')->name('roles.')->middleware('role:Super Admin')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('index');
            Route::get('/create', [RoleController::class, 'create'])->name('create');
            Route::post('/', [RoleController::class, 'store'])->name('store');
            Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('edit');
            Route::put('/{role}', [RoleController::class, 'update'])->name('update');
        });

        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
        Route::resource('events', AdminEventController::class); // <-- MENGGUNAKAN ALIAS
        Route::get('menus', [MenuController::class, 'index'])->name('menus.index');
        Route::get('menus/{menu}/builder', [MenuController::class, 'show'])->name('menus.show');
        Route::get('menus/{menu}/items/create', [MenuItemController::class, 'create'])->name('menu-items.create');
        Route::post('menus/{menu}/items', [MenuItemController::class, 'store'])->name('menu-items.store');
        Route::get('items/{menuItem}/edit', [MenuItemController::class, 'edit'])->name('menu-items.edit');
        Route::put('items/{menuItem}', [MenuItemController::class, 'update'])->name('menu-items.update');
        Route::delete('items/{menuItem}', [MenuItemController::class, 'destroy'])->name('menu-items.destroy');
    });
});

require __DIR__ . '/auth.php';