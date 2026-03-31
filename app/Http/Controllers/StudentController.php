<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query();

        // Tìm kiếm
        if ($request->keyword) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        // Sắp xếp
        if ($request->sort == 'name') {
            $query->orderBy('name', 'asc');
        }

        $students = $query->paginate(5)->appends($request->all());

        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'major' => 'required',
            'email' => 'required|email|unique:students,email'
        ]);

        Student::create([
            'name' => $request->name,
            'major' => $request->major,
            'email' => $request->email
        ]);

        return redirect()->route('students.index')
                         ->with('success', 'Thêm sinh viên thành công');
    }
}