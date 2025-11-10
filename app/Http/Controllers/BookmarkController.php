<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookmark;
use App\Models\PastQuestion;

class BookmarkController extends Controller
{
    public function index()
    {
        $bookmarks = auth()->user()->bookmarks()->with('pastQuestion')->get();

        return view('bookmarks.index', compact('bookmarks'));
    }

    public function store(Request $request, PastQuestion $pastQuestion)
    {
        $bookmark = Bookmark::firstOrCreate([
            'user_id' => auth()->id(),
            'past_question_id' => $pastQuestion->id,
        ]);

        return redirect()->back()->with('message', 'Bookmarked successfully!');
    }

    public function destroy(PastQuestion $pastQuestion)
    {
        $bookmark = Bookmark::where('user_id', auth()->id())
                            ->where('past_question_id', $pastQuestion->id)
                            ->first();

        if ($bookmark) {
            $bookmark->delete();
        }

        return redirect()->back()->with('message', 'Bookmark removed successfully!');
    }
}
