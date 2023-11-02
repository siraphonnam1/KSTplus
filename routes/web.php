<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ManageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
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

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/home', function () {
    return view('page.home');
})->middleware(['auth', 'verified'])->name('home');
Route::get('/main', function () {
    return view('page.main');
})->middleware(['auth', 'verified'])->name('main');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/icon', [ProfileController::class, 'updateIcon'])->name('icon.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // page
    Route::get('/course/detail', [HomeController::class, 'courseDetail'])->name('course.detail');
    Route::get('/course/all', [HomeController::class, 'allCourse'])->name('course.all');
    Route::get('/users/all', [HomeController::class, 'allUsers'])->name('users.all');
    Route::get('/users/detail/{id}', [HomeController::class, 'userDetail'])->name('user.detail');
    Route::get('/request/all', [HomeController::class, 'requestAll'])->name('request.all');
    Route::get('/manage', [ManageController::class, 'index'])->name('manage');

    // Manage
    Route::post('/manage/addAgency', [ManageController::class,'createAgency'])->name('add.agency');
    Route::post('/manage/addBranch', [ManageController::class,'createBranch'])->name('add.branch');
    Route::post('/manage/addDpm', [ManageController::class,'createDpm'])->name('add.dpm');
    Route::post('/manage/addRole', [ManageController::class,'createRole']);
    Route::post('/manage/addPerm', [ManageController::class,'createPerm']);
    Route::post('/manage/delete', [ManageController::class,'deleteData']);

    //User
    Route::post('/user/register', [UserController::class,'create'])->name('user.register');
    Route::post('/user/delete', [UserController::class,'destroy']);
    Route::post('/user/update', [UserController::class,'update']);

    // course
    Route::post('/course/add', [CourseController::class,'store']);
    Route::post('/course/delete', [CourseController::class,'delete']);
});

require __DIR__.'/auth.php';
