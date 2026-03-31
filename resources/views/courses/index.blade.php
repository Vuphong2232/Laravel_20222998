@extends('layout')

@section('content')

<div class="card shadow">

    <!-- HEADER -->
    <div class="card-header">
        <h5 class="mb-0">Quản lý môn học</h5>
    </div>

    <!-- BODY -->
    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- FORM -->
         <form method="GET" class="d-flex justify-content-end" style="margin-bottom:10px; " >

    <button type="button" 
            class="btn btn-success" 
            data-bs-toggle="modal" 
            data-bs-target="#addModal">
        + Thêm môn học
    </button>

</form>

        <!-- TABLE -->
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Tên môn</th>
                    <th>Tín chỉ</th>
                </tr>
            </thead>

            <tbody>
                @foreach($courses as $index => $c)
                <tr>
                    <td>{{ $courses->firstItem() + $index }}</td>
                    <td>{{ $c->name }}</td>
                    <td>{{ $c->credits }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- PAGINATION -->
        <div class="d-flex justify-content-center">
            {{ $courses->links('pagination::bootstrap-5') }}
        </div>

    </div>
</div>

<!-- MODAL -->
<div class="modal fade" id="addModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="POST" action="{{ route('courses.store') }}">
                @csrf

                <div class="modal-header">
                    <h5>Thêm môn học</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input name="course_name" class="form-control mb-2" placeholder="Tên môn">
                    <input name="credits" class="form-control mb-2" placeholder="Số tín chỉ">
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Lưu</button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection