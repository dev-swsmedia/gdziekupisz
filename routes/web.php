<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\LogoutController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\FilesController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\BlogController;
use App\Http\Controllers\Web\EmbedController;
use App\Http\Controllers\Admin\POSController;
use App\Http\Controllers\Admin\POSCategoryController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



/*
|--------------------------------------------------------------------------
| Client Routing
|--------------------------------------------------------------------------
 */
Route::name('web.')->group(function() { 
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('/blog/{category_slug?}/{id},{slug}', [BlogController::class, 'post'])->name('blog.post');
    Route::get('/blog/{category_slug?}', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/embed/pos/map', [EmbedController::class, 'map'])->name('embed.pos.map');
});


/*
|--------------------------------------------------------------------------
| Admin Routing
|--------------------------------------------------------------------------
*/

Route::prefix('manager')->group(function () {

    /*
     * Login Routes
     */

    Route::get('/sign-in', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('admin.login.perform');
    
    Route::get('/reset-password', [LoginController::class, 'resetPasswordShow'])->name('admin.password.reset');
    Route::get('/reset-password/{code}', [LoginController::class, 'newPasswordShow'])->name('admin.password.new');
    
    Route::get('/reset-password-confirmation', [LoginController::class, 'confirm_message'])->name('admin.password.confirm_message');
    
    Route::post('/action/reset-password', [LoginController::class, 'resetPassword'])->name('admin.password.reset.action');
    Route::post('/action/new-password', [LoginController::class, 'newPassword'])->name('admin.password.new.action');
    
    /**
     * Logout Routes
     */
    Route::get('/logout', [LogoutController::class, 'perform'])->name('logout.perform');
    
    /*
     * Service Management Routes
     */
    
    Route::group(['middleware' => ['auth:admin']], function() {    
    
        Route::get('/', [DashboardController::class, 'index'])->name('admin.index');
        
        Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile');
        Route::post('/profile/save', [ProfileController::class, 'save'])->name('admin.profile.save');
        
        Route::get('/blog', [AdminBlogController::class, 'index'])->name('admin.blog.index');
        Route::get('/blog/edit/{id?}', [AdminBlogController::class, 'edit'])->name('admin.blog.edit');
        Route::post('/blog/save/{id?}', [AdminBlogController::class, 'save'])->name('admin.blog.save');
        Route::get('/blog/delete/{id}', [AdminBlogController::class, 'delete'])->name('admin.blog.delete');
        Route::get('/blog/categories', [AdminBlogController::class, 'categories_index'])->name('admin.blog.categories');
        Route::get('/blog/categories/delete/{id}', [AdminBlogController::class, 'category_delete'])->name('admin.blog.categories.delete');
        Route::get('/blog/categories/save', [AdminBlogController::class, 'category_save'])->name('admin.blog.categories.save');
        
        Route::get('/pos', [POSController::class, 'index'])->name('admin.pos.index');
        Route::get('/pos/edit/{id?}', [POSController::class, 'edit'])->name('admin.pos.edit');
        Route::post('/pos/save/{id?}', [POSController::class, 'save'])->name('admin.pos.save');
        Route::get('/pos/delete/{id}', [POSController::class, 'delete'])->name('admin.pos.delete');
        Route::get('/pos/categories', [POSCategoryController::class, 'index'])->name('admin.pos.categories');
        Route::get('/pos/categories/delete/{id}', [POSCategoryController::class, 'delete'])->name('admin.pos.categories.delete');
        Route::post('/pos/categories/save', [POSCategoryController::class, 'save'])->name('admin.pos.categories.save');
        Route::post('/pos/import', [POSController::class, 'import'])->name('admin.pos.import');
        
        Route::get('/filesmanager', [FilesController::class, 'index'])->name('admin.filesmanager.index');
        Route::get('/filesmanager/edit/{id?}', [FilesController::class, 'edit'])->name('admin.filesmanager.edit');
        Route::post('/filesmanager/save/{id?}', [FilesController::class, 'save'])->name('admin.filesmanager.save');
        Route::get('/filesmanager/delete/{id}', [FilesController::class, 'delete'])->name('admin.filesmanager.delete');
         /*
         * AJAX
         */
                
        Route::get('/ajax/filesmanager/dt_get_files', [FilesController::class, '__dt_getFiles'])->name('admin.ajax.filesmanager.dt_getfiles');
        Route::get('/ajax/blog/dt_get_pages', [AdminBlogController::class, '__dt_getPosts'])->name('admin.ajax.blog.dt_getPosts');
        Route::get('/ajax/pos/dt_get', [POSController::class, '__dt_get'])->name('admin.ajax.pos.dt_get');
        
        
    });
});