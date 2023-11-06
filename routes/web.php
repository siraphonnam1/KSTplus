<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ManageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    Auth::logout();
    return view('auth.login');
});

// Route::get('/home', function () {
//     return view('page.home');
// })->middleware(['auth', 'verified'])->name('home');

// Route::get('/main', function () {
//     return view('page.main');
// })->middleware(['auth', 'verified'])->name('main');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/icon', [ProfileController::class, 'updateIcon'])->name('icon.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // page
    Route::get('/main', [HomeController::class, 'main'])->name('main');
    Route::get('/home', [HomeController::class, 'home'])->name('home');
    Route::get('/course{id}/detail', [HomeController::class, 'courseDetail'])->name('course.detail');
    Route::get('/course/all', [HomeController::class, 'allCourse'])->name('course.all');
    Route::get('/users/all', [HomeController::class, 'allUsers'])->name('users.all');
    Route::get('/users/detail/{id}', [HomeController::class, 'userDetail'])->name('user.detail');
    Route::get('/request/all', [HomeController::class, 'requestAll'])->name('request.all');
    Route::get('/course/own', [HomeController::class, 'ownCourse'])->name('ownCourse');
    Route::get('/course/classroom', [HomeController::class, 'classroom'])->name('classroom');
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
    Route::post('/user/renew', [UserController::class,'renew']);
    Route::post('/user/add/course', [UserController::class,'addCourse']);
    Route::post('/user/remove/course', [UserController::class,'removeCourse']);

    // course
    Route::post('/course/add', [CourseController::class,'store']);
    Route::post('/course/update', [CourseController::class,'update']);
    Route::post('/course/delete', [CourseController::class,'delete']);
    Route::get('/search-courses', [CourseController::class, 'search'])->name('courses.search');
    Route::get('/search-mycourses', [CourseController::class, 'searchMy'])->name('courses.searchmy');
    Route::post('/course/lesson/add', [CourseController::class,'addLesson'])->name('lesson.add');
    Route::post('/course/lesson/update', [CourseController::class,'updateLesson'])->name('lesson.update');
    Route::post('/lesson/sublesson/add', [CourseController::class,'subLessAdd']);
    Route::post('/lesson/sublesson/delete', [CourseController::class,'subLessDel']);
});

require __DIR__.'/auth.php';
