<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
 Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
}); 


	Route::get('/logout', function () {
	  return redirect()->route('login');
		 
	});
	
	
Route::get('/', [FrontendController::class, 'dash'])->middleware('auth');

Route::get('/success-register',[RegisteredUserController::class, 'successRegister'])->name('successRegister');
Route::get('/clearcache', [FrontendController::class, 'clearCache'])->name('clearCache');


Route::group(['prefix'=>'admin','middleware' => ['PreventBackHistory','isAdmin'],'as'=>'admin.'],function(){
	Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
	Route::get('/clients', [AdminController::class, 'clients'])->name('clients');
	Route::post('/clients/approve', [AdminController::class, 'clientsApprove'])->name('clientsApprove');
	Route::get('/users', [AdminController::class, 'users'])->name('users');
	Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
	Route::post('/save-settings', [AdminController::class, 'saveSettings'])->name('saveSettings');
	
	Route::get('/property/{id}/{revenueY?}/{expenseY?}', [AdminController::class, 'propertyDetail'])->name('propertyDetail');
	//Route::get('/property/{id}/{revenueY}/{expenseY}', [AdminController::class, 'propertyDetail'])->name('propertyDetail');
	
	Route::post('/property/add', [AdminController::class, 'addProperty'])->name('addProperty');
	Route::post('/property/addTransaction', [AdminController::class, 'addTransaction'])->name('addTransaction');
	Route::post('/property/upd', [AdminController::class, 'prop_update'])->name('prop_update');
	Route::post('/property/chat', [AdminController::class, 'propertyChat'])->name('propertyChat');
	Route::post('/property/add-owner', [AdminController::class, 'addPropOwner'])->name('addPropOwner');
	Route::post('/property/update-owner', [AdminController::class, 'updatePropOwner'])->name('updatePropOwner');
	Route::get('/add-user', [AdminController::class, 'addUser'])->name('addUser');
	Route::get('/add-client', [AdminController::class, 'addClient'])->name('addClient');
	Route::get('/edit-user/{id}', [AdminController::class, 'editUser'])->name('editUser');
	Route::post('/update-user', [AdminController::class, 'updateUser'])->name('updateUser');
	Route::get('/delete-user/{id}', [AdminController::class, 'deleteUser'])->name('deleteUser');
	Route::post('/create-user', [AdminController::class, 'create_user'])->name('create_user');

	
	
	Route::post('/property/updateProperty', [AdminController::class, 'updateProperty'])->name('updateProperty');
	
	
	
	Route::post('/property/update-property-meta', [AdminController::class, 'updatePropMeta'])->name('updatePropMeta');
	Route::post('/property/bulk-action', [AdminController::class, 'propBulkAction'])->name('propBulkAction');

	Route::post('/property/add-document', [AdminController::class, 'addPropDocument'])->name('addPropDocument');
	Route::post('/property/add-gallery', [AdminController::class, 'addPropGallery'])->name('addPropGallery');
	
	Route::post('/delete-documents', [AdminController::class, 'deleteDocument'])->name('deleteDocument');
	
	Route::get('/pdf-view/{id}/{revenueY?}/{expenseY?}', [App\Http\Controllers\AdminController::class, 'pdfview'])->name('pdfview');
    Route::get('/download-view/{id}/{revenueY?}/{expenseY?}', [App\Http\Controllers\AdminController::class, 'downloadpdfview'])->name('downloadpdfview');
});
Route::group(['middleware' => ['PreventBackHistory','isUser'],'as'=>'user.'],function(){
	Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');
	Route::get('/settings', [UserController::class, 'settings'])->name('settings');
	Route::post('/save-settings', [UserController::class, 'saveSettings'])->name('saveSettings');
	
	Route::get('/properties', [UserController::class, 'properties'])->name('properties');
	Route::get('/property/{id}/{revenueY?}/{expenseY?}', [UserController::class, 'propertyDetail'])->name('propertyDetail');
	
	Route::get('/pdf-view/{id}/{revenueY?}/{expenseY?}', [App\Http\Controllers\UserController::class, 'pdfview'])->name('pdfview');
    Route::get('/download-view/{id}/{revenueY?}/{expenseY?}', [App\Http\Controllers\UserController::class, 'downloadpdfview'])->name('downloadpdfview'); 
});

require __DIR__.'/auth.php';
