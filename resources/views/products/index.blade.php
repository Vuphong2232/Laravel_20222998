@extends('layout')

@section('content')

<div class="card shadow">
    <div class="card-header d-flex justify-content-between">
        <h5>Quản lý sản phẩm</h5>

        
    </div>

   <form method="GET" class="d-flex justify-content-end" style="margin-top:10px;margin-right:20px; " >

    <button type="button" 
            class="btn btn-success" 
            data-bs-toggle="modal" 
            data-bs-target="#addModal">
        + Thêm sản phẩm
    </button>

</form>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- TABLE -->
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Tên</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Danh mục</th>
                    <th>Trạng thái</th>
                    <th>Tồn kho</th>
                </tr>
            </thead>

            <tbody>
                @foreach($products as $p)
                <tr>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->price }}</td>
                    <td>{{ $p->quantity }}</td>
                    <td>{{ $p->category }}</td>

                    <td>
                        @if($p->quantity == 0)
                            <span class="badge bg-danger">Hết hàng</span>
                        @elseif($p->quantity < 5)
                            <span class="badge bg-warning">Sắp hết</span>
                        @else
                            <span class="badge bg-success">Còn hàng</span>
                        @endif
                    </td>

                    <td class="d-flex">
                        <!-- update -->
                        <form method="POST" action="{{ route('products.update', $p->id) }}" class="me-1">
                            @csrf
                            @method('PUT')

                            <input type="number" name="quantity" style="width:80px" value="{{ $p->quantity }}">
                            <button class="btn btn-sm btn-primary">Update</button>
                        </form>

                        <!-- delete -->
                        <form method="POST" action="{{ route('products.destroy', $p->id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $products->links('pagination::bootstrap-5') }}

    </div>
</div>

<!-- MODAL -->
<div class="modal fade" id="addModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="POST" action="{{ route('products.store') }}">
                @csrf

                <div class="modal-header">
                    <h5>Thêm sản phẩm</h5>
                </div>

                <div class="modal-body">
                    <input name="name" class="form-control mb-2" placeholder="Tên">
                    <input name="price" class="form-control mb-2" placeholder="Giá">
                    <input name="quantity" class="form-control mb-2" placeholder="Số lượng">
                    <input name="category" class="form-control mb-2" placeholder="Danh mục">
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Lưu</button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection