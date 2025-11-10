<?php

use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\PastQuestionController;
use App\Http\Controllers\ProfileController;
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
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['can:admin'])->group(function () {
    Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create'); 
    Route::get('/past-questions/create', [PastQuestionController::class, 'create'])->name('pastQuestions.create');
    Route::get('/past-questions/all', [PastQuestionController::class, 'allPastQuestions'])->name('pastQuestions.all');
    Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');

    Route::get('/past-questions/{pastQuestion}/edit', [PastQuestionController::class, 'edit'])->name('pastQuestions.edit');
    Route::put('/past-questions/{pastQuestion}', [PastQuestionController::class, 'update'])->name('pastQuestions.update');
    Route::delete('/past-questions/{pastQuestion}', [PastQuestionController::class, 'destroy'])->name('pastQuestions.destroy');
});
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index')->middleware('auth');
Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show')->middleware('auth');


Route::middleware(['auth'])->group(function () {

Route::get('/past-questions/{pastQuestion}/download', [PastQuestionController::class, 'download'])->name('pastQuestions.download');
Route::get('/past-questions/{pastQuestion}/view', [PastQuestionController::class, 'view'])->name('pastQuestions.view');
Route::post('/past-questions/{pastQuestion}/comments', [CommentController::class, 'store'])->name('comments.store');

Route::post('past-questions/{pastQuestion}/bookmark', [BookmarkController::class, 'store'])->name('bookmarks.store');
Route::delete('past-questions/{pastQuestion}/bookmark', [BookmarkController::class, 'destroy'])->name('bookmarks.destroy');
Route::get('user/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');

Route::post('/past-questions', [PastQuestionController::class, 'store'])->middleware('auth')->name('pastQuestions.store');
Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('courses.destroy')->middleware('can:admin');

});



require __DIR__.'/auth.php';
