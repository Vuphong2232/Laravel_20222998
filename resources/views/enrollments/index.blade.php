@extends('layout')

@section('content')

<div class="card shadow">
    <div class="card-header">
        <h5>Đăng ký môn học</h5>
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- FORM -->
        <form method="POST" action="{{ route('enrollments.store') }}" class="row g-2 mb-3">
            @csrf

            <!-- sinh viên -->
            <div class="col">
                <select name="student_id" class="form-select">
                    @foreach($students as $s)
                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- môn -->
            <div class="col">
                <select name="course_id" class="form-select">
                    @foreach($courses as $c)
                        <option value="{{ $c->id }}">
                            {{ $c->name }} ({{ $c->credits }} TC)
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col">
                <button class="btn btn-success">Đăng ký</button>
            </div>
        </form>

        <!-- TABLE -->
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Sinh viên</th>
                    <th>Môn học</th>
                    <th>Tín chỉ</th>
                </tr>
            </thead>

            <tbody>
                @foreach($enrollments as $e)
                <tr>
                    <td>{{ $e->student->name }}</td>
                    <td>{{ $e->course->name }}</td>
                    <td>{{ $e->course->credits }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@endsection