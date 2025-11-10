<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\PastQuestion;
use App\Models\Comment;
use App\Models\Bookmark;

class HomeController extends Controller
{
    /**
     * Get dashboard summary data for the authenticated user.
     */
    public function index(Request $request)
    {
        // Authenticated user
        $user = $request->user();

        // Counts and data summaries
        $data = [
            'user' => $user,
            'total_courses' => Course::count(),
            'total_past_questions' => PastQuestion::count(),
            'total_comments' => Comment::count(),
            'total_bookmarks' => Bookmark::where('user_id', $user->id)->count(),
            'recent_past_questions' => PastQuestion::with('course')
                ->latest()
                ->take(5)
                ->get(),
            'user_bookmarks' => Bookmark::with('pastQuestion.course')
                ->where('user_id', $user->id)
                ->latest()
                ->take(5)
                ->get(),
        ];

        return response()->json([
            'status' => true,
            'message' => 'Dashboard data retrieved successfully.',
            'data' => $data,
        ]);
    }
}
