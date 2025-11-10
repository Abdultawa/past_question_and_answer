<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\PastQuestion;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * Display all comments for a specific past question.
     */
    public function index($pastQuestionId)
    {
        $pastQuestion = PastQuestion::with('comments.user')->find($pastQuestionId);

        if (!$pastQuestion) {
            return response()->json([
                'status' => false,
                'message' => 'Past question not found.',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Comments retrieved successfully.',
            'data' => $pastQuestion->comments,
        ]);
    }

    /**
     * Store a new comment for a specific past question.
     */
    public function store(Request $request, $pastQuestionId)
    {
        $validator = Validator::make($request->all(), [
            'body' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $pastQuestion = PastQuestion::find($pastQuestionId);

        if (!$pastQuestion) {
            return response()->json([
                'status' => false,
                'message' => 'Past question not found.',
            ], 404);
        }

        $comment = $pastQuestion->comments()->create([
            'user_id' => $request->user()->id,
            'body' => $request->body,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Comment added successfully.',
            'data' => $comment->load('user'),
        ], 201);
    }

    /**
     * Delete a comment (only by the owner or admin).
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return response()->json([
                'status' => false,
                'message' => 'Comment not found.',
            ], 404);
        }

        if ($comment->user_id !== auth()->id()) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized action.',
            ], 403);
        }

        $comment->delete();

        return response()->json([
            'status' => true,
            'message' => 'Comment deleted successfully.',
        ]);
    }
}
