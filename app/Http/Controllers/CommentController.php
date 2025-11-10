<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\PastQuestion;

class CommentController extends Controller
{
    public function store(Request $request, PastQuestion $pastQuestion)
    {
        $request->validate([
            'body' => 'required',
        ]);

        $pastQuestion->comments()->create([
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);

        return redirect()->back()->with('message', 'Comment added successfully!');
    }
}
