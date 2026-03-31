<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Course;

class EnrollmentController extends Controller
{
    public function index()
    {
        $students = Student::all(); // dùng lại bảng students
        $courses = Course::all();
        $enrollments = Enrollment::with('student', 'course')->get();

        return view('enrollments.index', compact('students', 'courses', 'enrollments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required',
            'course_id' => 'required'
        ]);

        // ❌ trùng
        $exists = Enrollment::where('student_id', $request->student_id)
            ->where('course_id', $request->course_id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Sinh viên đã đăng ký môn này');
        }

        // 🔥 tính tổng tín chỉ
        $currentCredits = Enrollment::where('student_id', $request->student_id)
            ->join('courses', 'enrollments.course_id', '=', 'courses.id')
            ->sum('credits');

        $course = Course::find($request->course_id);

        if ($currentCredits + $course->credits > 18) {
            return back()->with('error', 'Vượt quá 18 tín chỉ');
        }

        Enrollment::create([
            'student_id' => $request->student_id,
            'course_id' => $request->course_id
        ]);

        return back()->with('success', 'Đăng ký thành công');
    }
}