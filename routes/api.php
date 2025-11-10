<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BookmarkController;
use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\CourseController;
use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\PastQuestionController;
use App\Http\Controllers\API\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->prefix('profile')->group(function () {
    Route::get('/', [ProfileController::class, 'show']);
    Route::put('/update', [ProfileController::class, 'update']);
    Route::delete('/delete', [ProfileController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->prefix('past-questions')->group(function () {
    Route::get('/', [PastQuestionController::class, 'index']);           // Get all past questions
    Route::get('/{id}', [PastQuestionController::class, 'show']);        // View single past question
    Route::post('/', [PastQuestionController::class, 'store']);          // Upload new past question
    Route::get('/{id}/download', [PastQuestionController::class, 'download']); // Download file
    Route::put('/{id}', [PastQuestionController::class, 'update']);      // Update past question
    Route::delete('/{id}', [PastQuestionController::class, 'destroy']);  // Delete past question
});

Route::middleware('auth:sanctum')->prefix('courses')->group(function () {
    Route::get('/', [CourseController::class, 'index']);     // List ND/HND courses
    Route::get('/{id}', [CourseController::class, 'show']);  // Show single course + past questions
    Route::post('/', [CourseController::class, 'store']);    // Create new course
    Route::delete('/{id}', [CourseController::class, 'destroy']); // Delete course
});

Route::middleware('auth:sanctum')->prefix('comments')->group(function () {
    Route::get('/past-question/{pastQuestionId}', [CommentController::class, 'index']); // Get comments for a past question
    Route::post('/past-question/{pastQuestionId}', [CommentController::class, 'store']); // Add new comment
    Route::delete('/{id}', [CommentController::class, 'destroy']); // Delete comment
});

Route::middleware('auth:sanctum')->prefix('bookmarks')->group(function () {
    Route::get('/', [BookmarkController::class, 'index']);                 // Get all user bookmarks
    Route::post('/{pastQuestionId}', [BookmarkController::class, 'store']); // Add bookmark
    Route::delete('/{pastQuestionId}', [BookmarkController::class, 'destroy']); // Remove bookmark
});

Route::middleware('auth:sanctum')->get('/dashboard', [HomeController::class, 'index']);
