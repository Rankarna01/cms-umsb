<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// --- KUMPULAN SEMUA CONTROLLER ---
// Admin
use App\Http\Controllers\Admin\AlbumController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DocumentCategoryController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\FacultyController;
use App\Http\Controllers\Admin\LecturerController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\Admin\PhotoController;
use App\Http\Controllers\Admin\PostCategoryController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\StudyProgramController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\FactoidController;
use App\Http\Controllers\Admin\LeaderController;
// Controller dengan nama panggilan (alias)
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\PageController as AdminPageController; // <-- TAMBAHKAN ALIAS INI
// Frontend
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PostController as FrontendPostController;
use App\Http\Controllers\Frontend\PageController as FrontendPageController; // <-- TAMBAHKAN INI


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- ROUTE UNTUK PENGUNJUNG (FRONTEND) ---
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/berita', [FrontendPostController::class, 'index'])->name('posts.index');
Route::get('/berita/{slug}', [FrontendPostController::class, 'show'])->name('posts.show');
Route::get('/halaman/{slug}', [FrontendPageController::class, 'show'])->name('pages.show'); // <-- PERBAIKAN DI SINI


// --- ROUTE UNTUK SISTEM LOGIN & ADMIN ---
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // === GROUP ROUTE UNTUK SEMUA MENU ADMIN ===
    Route::prefix('admin')->name('admin.')->group(function () {
        
        // --- Route Resource (CRUD Standar) ---
        Route::resource('posts', AdminPostController::class);
        Route::resource('pages', AdminPageController::class); // <-- PERBAIKAN DI SINI
        Route::resource('categories', PostCategoryController::class);
        Route::resource('sliders', SliderController::class);
        Route::resource('announcements', AnnouncementController::class);
        Route::resource('events', EventController::class);
        Route::resource('faculties', FacultyController::class);
        Route::resource('study-programs', StudyProgramController::class);
        Route::resource('lecturers', LecturerController::class);
        Route::resource('document-categories', DocumentCategoryController::class);
        Route::resource('documents', DocumentController::class);
        Route::resource('albums', AlbumController::class);
        Route::resource('videos', VideoController::class);
        Route::resource('factoids', FactoidController::class);
        Route::resource('partners', PartnerController::class);
        Route::resource('users', UserController::class)->middleware('role:Super Admin');
        Route::resource('leaders', LeaderController::class);

        // --- Route Custom (Non-Resource) ---
        Route::get('users/{user}/permissions', [UserController::class, 'editPermissions'])->name('users.permissions.edit')->middleware('role:Super Admin');
        Route::put('users/{user}/permissions', [UserController::class, 'updatePermissions'])->name('users.permissions.update')->middleware('role:Super Admin');
        
        Route::prefix('roles')->name('roles.')->middleware('role:Super Admin')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('index');
            Route::get('/create', [RoleController::class, 'create'])->name('create');
            Route::post('/', [RoleController::class, 'store'])->name('store');
            Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('edit');
            Route::put('/{role}', [RoleController::class, 'update'])->name('update');
        });
        
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
        
        Route::get('menus', [MenuController::class, 'index'])->name('menus.index');
        Route::get('menus/{menu}/builder', [MenuController::class, 'show'])->name('menus.show');
        Route::get('menus/{menu}/items/create', [MenuItemController::class, 'create'])->name('menu-items.create');
        Route::post('menus/{menu}/items', [MenuItemController::class, 'store'])->name('menu-items.store');
        Route::get('items/{menuItem}/edit', [MenuItemController::class, 'edit'])->name('menu-items.edit');
        Route::put('items/{menuItem}', [MenuItemController::class, 'update'])->name('menu-items.update');
        Route::delete('items/{menuItem}', [MenuItemController::class, 'destroy'])->name('menu-items.destroy');
        
        Route::get('albums/{album}/photos/create', [PhotoController::class, 'create'])->name('photos.create');
        Route::post('albums/{album}/photos', [PhotoController::class, 'store'])->name('photos.store');
        Route::delete('photos/{photo}', [PhotoController::class, 'destroy'])->name('photos.destroy');
    });
});

require __DIR__ . '/auth.php';
