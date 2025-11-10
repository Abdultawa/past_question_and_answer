<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\PastQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PastQuestionController extends Controller
{
    /**
     * Get all past questions (with related course info)
     */
    public function index()
    {
        $pastQuestions = PastQuestion::with('course')->get();

        return response()->json([
            'status' => true,
            'message' => 'Past questions retrieved successfully.',
            'data' => $pastQuestions,
        ]);
    }

    /**
     * Get a single past question
     */
    public function show($id)
    {
        $pastQuestion = PastQuestion::with('course')->find($id);

        if (!$pastQuestion) {
            return response()->json([
                'status' => false,
                'message' => 'Past question not found.',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $pastQuestion,
        ]);
    }

    /**
     * Store a new past question
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|exists:courses,id',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'file' => 'required|file|mimes:pdf|max:2048',
            'image' => 'required|file|mimes:png,jpg,jpeg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $filePath = $request->file('file')->store('past_questions');
        $imagePath = $request->file('image')->store('past_questions_images');

        $pastQuestion = PastQuestion::create([
            'course_id' => $request->course_id,
            'year' => $request->year,
            'file_path' => $filePath,
            'image' => $imagePath,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Past question uploaded successfully.',
            'data' => $pastQuestion,
        ], 201);
    }

    /**
     * Download a past question file
     */
    public function download($id)
    {
        $pastQuestion = PastQuestion::find($id);

        if (!$pastQuestion || !Storage::exists($pastQuestion->file_path)) {
            return response()->json([
                'status' => false,
                'message' => 'File not found.',
            ], 404);
        }

        return response()->download(storage_path('app/' . $pastQuestion->file_path));
    }

    /**
     * Update an existing past question
     */
    public function update(Request $request, $id)
    {
        $pastQuestion = PastQuestion::find($id);

        if (!$pastQuestion) {
            return response()->json([
                'status' => false,
                'message' => 'Past question not found.',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'course_id' => 'required|exists:courses,id',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'file' => 'nullable|file|mimes:pdf|max:2048',
            'image' => 'nullable|file|mimes:png,jpg,jpeg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        if ($request->hasFile('file')) {
            // Delete old file
            if (Storage::exists($pastQuestion->file_path)) {
                Storage::delete($pastQuestion->file_path);
            }
            $pastQuestion->file_path = $request->file('file')->store('past_questions');
        }

        if ($request->hasFile('image')) {
            // Delete old image
            if (Storage::exists($pastQuestion->image)) {
                Storage::delete($pastQuestion->image);
            }
            $pastQuestion->image = $request->file('image')->store('past_questions_images');
        }

        $pastQuestion->update([
            'course_id' => $request->course_id,
            'year' => $request->year,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Past question updated successfully.',
            'data' => $pastQuestion,
        ]);
    }

    /**
     * Delete a past question
     */
    public function destroy($id)
    {
        $pastQuestion = PastQuestion::find($id);

        if (!$pastQuestion) {
            return response()->json([
                'status' => false,
                'message' => 'Past question not found.',
            ], 404);
        }

        // Delete stored files
        if (Storage::exists($pastQuestion->file_path)) {
            Storage::delete($pastQuestion->file_path);
        }

        if ($pastQuestion->image && Storage::exists($pastQuestion->image)) {
            Storage::delete($pastQuestion->image);
        }

        $pastQuestion->delete();

        return response()->json([
            'status' => true,
            'message' => 'Past question deleted successfully.',
        ]);
    }
}
