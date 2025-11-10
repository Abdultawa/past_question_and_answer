<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
{
    $query = Course::query();

    if ($request->has('search')) {
        $query->where('name', 'LIKE', '%' . $request->search . '%');
    }

    $ndCourses = $query->where('category', 'ND')->paginate(5, ['*'], 'ndPage');
    $hndCourses = Course::where('category', 'HND')->paginate(5, ['*'], 'hndPage');

    // Temporary debugging output
    // dd($ndCourses, $hndCourses);

    return view('courses.index', compact('ndCourses', 'hndCourses'));
}

    public function show(Course $course)
    {
        $course->load('pastQuestions'); // Eager load past questions
        return view('courses.show', compact('course'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|in:ND,HND', // Validate the category
        ]);

        Course::create([
            'name' => $request->name,
            'category' => $request->category,
        ]);

        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    public function destroy($id)
{
    $course = Course::findOrFail($id);
    $course->delete();

    return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
}
}
