<?php
use App\Http\Controllers\PermissonController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\superadmin\userController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('auth.login');
// });
Route::get('/', function () {
    return view('w3crm.layout');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth','verified'])->group(function () {
    // Dashboard route for all authenticated users
    Route::get('/dashboard',[RedirectController::class,'redirectUser'])->name('dashboard');
    
    // Route accessible only to super-admin role
    Route::middleware(['role:super-admin'])->group(function () {
        Route::get('/superadmin/dashboard', function () {
            
            return view('superadmin.dashboard');
        })->name('superadmin.dashboard');
        Route::get('/createUser',[userController::class,'createUser'])->name('createUser');
        Route::post('/createUser',[userController::class,'store'])->name('postUser');
        Route::get('userList',[userController::class,'userList'])->name('user.list');
        Route::get('edit',[userController::class,'edit'])->name('user.edit');
        Route::post('updateUser',[userController::class,'update'])->name('user.update');
        Route::get('delete',[userController::class,'delete'])->name('user.delete');
        Route::get('role',[RoleController::class,'index'])->name('role');
        Route::get('permissonByRole',[RoleController::class,'permissonByRoleId'])->name('rolesPermisson');
        Route::post('permissonUpdate',[RoleController::class,'updatePermissonOfRole'])->name('permissonUpdateOfRole');
        // Route::get('roleList',[RoleController::class,'roleList'])->name('roleList');
        Route::get('searchData',[userController::class,'searchData'])->name('search.data');
        Route::post('permisson',[PermissonController::class,'create'])->name('permisson.create');
        Route::get('permisson',[PermissonController::class,'permissonList'])->name('permisson.list');
        Route::get('permissonDelete',[PermissonController::class,'permissonDeleteCross'])->name('permisson.delete');

    });
    
    // Route accessible only to manager role
    Route::middleware(['role:manager'])->group(function () {
        Route::get('/manager/dashboard', function () {
            return view('manager.dashboard');
        })->name('manager.dashboard');
    });
    
    // Route accessible only to user role
    Route::middleware(['role:user'])->group(function () {
        Route::get('/user/dashboard', function () {
            return view('dashboard');
        })->name('user.dashboard');
    });
});


require __DIR__.'/auth.php';
