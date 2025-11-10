<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\PastQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PastQuestionController extends Controller
{
    public function create()
    {
        $courses = Course::all();
        return view('pastQuestions.create', compact('courses'));
    }

    public function view($id)
    {
        $pastQuestion = PastQuestion::findOrFail($id);
        return view('pastQuestions.view', compact('pastQuestion'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'file' => 'required|file|mimes:pdf|max:2048',
            'image' => 'required|file|mimes:png,jpg,jpeg|max:2048',
        ]);

        $filePath = $request->file('file')->store('past_questions');
        $image = $request->file('image')->store('past_questions_images');

        PastQuestion::create([
            'course_id' => $request->course_id,
            'year' => $request->year,
            'file_path' => $filePath,
            'image' => $image,
        ]);

        return redirect()->route('courses.show', $request->course_id)->with('success', 'Past question uploaded successfully.');
    }

    public function download($id)
    {
        $pastQuestion = PastQuestion::findOrFail($id);
        return Storage::download($pastQuestion->file_path);
    }

    public function allPastQuestions()
{
    $pastQuestions = PastQuestion::with('course')->get();
    return view('pastQuestions.all', compact('pastQuestions'));
}

    public function edit(PastQuestion $pastQuestion)
    {
        $courses = Course::all();
        return view('pastQuestions.edit', compact('pastQuestion', 'courses'));
    }

    public function update(Request $request, PastQuestion $pastQuestion)
    {
        $request->validate([
           'course_id' => 'required|exists:courses,id',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'file' => 'required|file|mimes:pdf|max:2048',
        ]);
        $filePath = $request->file('file')->store('past_questions');
        $pastQuestion->update([
            'course_id' => $request->course_id,
            'year' => $request->year,
            'file_path' => $filePath,
        ]);

        return redirect()->route('courses.show', $pastQuestion->course_id)->with('success', 'Past question updated successfully.');
    }

    public function destroy(PastQuestion $pastQuestion)
    {
        $courseId = $pastQuestion->course_id;
        $pastQuestion->delete();

        return redirect()->back()->with('success', 'Past question deleted successfully.');
    }

}
