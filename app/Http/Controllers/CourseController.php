<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::query();

        // 🔍 tìm kiếm
        if ($request->keyword) {
            $query->where('course_name', 'like', '%' . $request->keyword . '%');
        }

        // 🔽 sắp xếp
        if ($request->sort == 'name') {
            $query->orderBy('course_name');
        }

        if ($request->sort == 'credits') {
            $query->orderBy('credits');
        }

        $courses = $query->paginate(5)->appends($request->all());

        return view('courses.index', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_name' => 'required',
            'credits' => 'required|integer|min:1'
        ]);

        Course::create([
    'name' => $request->course_name,
    'credits' => $request->credits
]);

        return back()->with('success', 'Thêm môn học thành công');
    }
}