@extends('layout')

@section('content')

<div class="card shadow">
    <div class="card-header">
        <h5>Hệ thống đặt lịch</h5>
    </div>

    <!-- NÚT -->
    <div class="d-flex justify-content-end m-2">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">
            + Đặt lịch
        </button>
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Khách</th>
                    <th>Ngày</th>
                    <th>Giờ</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach($appointments as $a)
                <tr>
                    <td>{{ $a->customer->name }}</td>
                    <td>{{ $a->date }}</td>
                    <td>{{ $a->time }}</td>

                    <td>
                        <form method="POST" action="{{ route('booking.delete', $a->id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Hủy</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

<!-- MODAL -->
<div class="modal fade" id="addModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="POST" action="{{ route('booking.store') }}">
                @csrf

                <div class="modal-header">
                    <h5>Đặt lịch</h5>
                </div>

                <div class="modal-body">
                    <input name="name" class="form-control mb-2" placeholder="Tên khách">
                    <input type="date" name="date" class="form-control mb-2">
                    <input type="time" name="time" class="form-control mb-2">
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Đặt</button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection