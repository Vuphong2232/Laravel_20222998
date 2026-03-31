@extends('layout')

@section('content')

<div class="card shadow">
    <div class="card-header d-flex justify-content-between">
        <h5>Danh sách sinh viên</h5>

        
    </div>

    <div class="card-body">

        <form method="GET" class="mb-3 d-flex justify-content-between">

    <!-- Bên trái -->
    <div class="d-flex">
        <input type="text" name="keyword" 
               value="{{ request('keyword') }}" 
               class="form-control me-2" 
               placeholder="Tìm tên"
               style="width: 400px;">

        <button class="btn btn-primary">Tìm</button>
    </div>

    <div>
        <select name="sort" class="form-select" onchange="this.form.submit()" style="width: 300px;">>
            <option value="">-- Sắp xếp --</option>
            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>
                Theo tên (A → Z)
            </option>
        </select>
    </div>

    <!-- Bên phải -->
    <button type="button" 
        class="btn btn-success" 
        data-bs-toggle="modal" 
        data-bs-target="#addModal">
    + Thêm sinh viên
</button>

</form>
        

        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Tên</th>
                    <th>Ngành</th>
                    <th>Email</th>
                </tr>
            </thead>

            <tbody>
                @foreach($students as $index => $sv)
                <tr>
                    <td>{{ $students->firstItem() + $index }}</td>
                    <td>{{ $sv->name }}</td>
                    <td>{{ $sv->major }}</td>
                    <td>{{ $sv->email }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $students->links('pagination::bootstrap-5') }}
        </div>

    </div>
</div>

<!-- Modal thêm -->
<div class="modal fade" id="addModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="POST" action="{{ route('students.store') }}">
                @csrf

                <div class="modal-header">
                    <h5>Thêm sinh viên</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="text" name="name" class="form-control mb-2" placeholder="Tên">
                    <input type="text" name="major" class="form-control mb-2" placeholder="Ngành">
                    <input type="email" name="email" class="form-control mb-2" placeholder="Email">
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Lưu</button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection