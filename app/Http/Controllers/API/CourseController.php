<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    /**
     * List all courses with optional search filter and pagination.
     */
    public function index(Request $request)
    {
        $query = Course::query();

        // Search by course name
        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        // Get ND and HND courses separately with pagination
        $ndCourses = (clone $query)->where('category', 'ND')->paginate(5, ['*'], 'ndPage');
        $hndCourses = Course::where('category', 'HND')->paginate(5, ['*'], 'hndPage');

        return response()->json([
            'status' => true,
            'message' => 'Courses retrieved successfully.',
            'data' => [
                'nd_courses' => $ndCourses,
                'hnd_courses' => $hndCourses,
            ],
        ]);
    }

    /**
     * Get a single course with its past questions.
     */
    public function show($id)
    {
        $course = Course::with('pastQuestions')->find($id);

        if (!$course) {
            return response()->json([
                'status' => false,
                'message' => 'Course not found.',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $course,
        ]);
    }

    /**
     * Create a new course.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category' => 'required|string|in:ND,HND',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $course = Course::create([
            'name' => $request->name,
            'category' => $request->category,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Course created successfully.',
            'data' => $course,
        ], 201);
    }

    /**
     * Delete a course.
     */
    public function destroy($id)
    {
        $course = Course::find($id);

        if (!$course) {
            return response()->json([
                'status' => false,
                'message' => 'Course not found.',
            ], 404);
        }

        $course->delete();

        return response()->json([
            'status' => true,
            'message' => 'Course deleted successfully.',
        ]);
    }
}
