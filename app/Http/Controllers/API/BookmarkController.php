<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bookmark;
use App\Models\PastQuestion;

class BookmarkController extends Controller
{
    /**
     * Display all bookmarks for the authenticated user.
     */
    public function index(Request $request)
    {
        $bookmarks = $request->user()
            ->bookmarks()
            ->with('pastQuestion.course') // eager load past question and related course
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Bookmarks retrieved successfully.',
            'data' => $bookmarks,
        ]);
    }

    /**
     * Store a new bookmark for a past question.
     */
    public function store(Request $request, $pastQuestionId)
    {
        $pastQuestion = PastQuestion::find($pastQuestionId);

        if (!$pastQuestion) {
            return response()->json([
                'status' => false,
                'message' => 'Past question not found.',
            ], 404);
        }

        $bookmark = Bookmark::firstOrCreate([
            'user_id' => $request->user()->id,
            'past_question_id' => $pastQuestion->id,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Bookmarked successfully.',
            'data' => $bookmark->load('pastQuestion.course'),
        ], 201);
    }

    /**
     * Remove a bookmark for a specific past question.
     */
    public function destroy(Request $request, $pastQuestionId)
    {
        $bookmark = Bookmark::where('user_id', $request->user()->id)
            ->where('past_question_id', $pastQuestionId)
            ->first();

        if (!$bookmark) {
            return response()->json([
                'status' => false,
                'message' => 'Bookmark not found.',
            ], 404);
        }

        $bookmark->delete();

        return response()->json([
            'status' => true,
            'message' => 'Bookmark removed successfully.',
        ]);
    }
}
