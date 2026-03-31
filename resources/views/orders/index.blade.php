@extends('layout')

@section('content')

<div class="card shadow">
    <div class="card-header d-flex justify-content-between">
        <h5>Quản lý đơn hàng</h5>
    </div>

    <!-- NÚT THÊM -->
    <form class="d-flex justify-content-end" style="margin-top:10px;margin-right:20px;">
        <button type="button" 
                class="btn btn-success" 
                data-bs-toggle="modal" 
                data-bs-target="#addModal">
            + Tạo đơn
        </button>
    </form>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- TABLE -->
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Khách</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Chi tiết</th>
                </tr>
            </thead>

            <tbody>
                @foreach($orders as $o)
                <tr>
                    <td>{{ $o->id }}</td>
                    <td>{{ $o->customer_name }}</td>
                    <td>{{ $o->total }}</td>

                    <td>
                        @if($o->status == 'pending')
                            <span class="badge bg-warning">Pending</span>
                        @elseif($o->status == 'processing')
                            <span class="badge bg-primary">Processing</span>
                        @else
                            <span class="badge bg-success">Completed</span>
                        @endif
                    </td>

                    <td>
                        <button class="btn btn-sm btn-info"
        data-bs-toggle="modal"
        data-bs-target="#viewModal{{ $o->id }}">
    Xem
</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $orders->links('pagination::bootstrap-5') }}

    </div>
</div>

<!-- ================= MODAL ================= -->
<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form method="POST" action="{{ route('orders.store') }}">
                @csrf

                <div class="modal-header">
                    <h5>Tạo đơn hàng</h5>
                </div>

                <div class="modal-body">

                    <!-- TÊN KHÁCH -->
                    <input name="customer_name" 
                           class="form-control mb-3" 
                           placeholder="Tên khách">

                    <!-- DANH SÁCH SẢN PHẨM -->
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($products as $p)
                            <tr>
                                <td>{{ $p->name }}</td>
                                <td>{{ $p->price }}</td>
                                <td>
                                    <input type="number" 
                                           name="products[{{ $p->id }}]" 
                                           value="0" min="0" 
                                           class="form-control">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Tạo đơn</button>
                </div>

            </form>

        </div>
    </div>
</div>

<!-- Modal xem chi tiết -->
<div class="modal fade" id="viewModal{{ $o->id }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5>Chi tiết đơn #{{ $o->id }}</h5>
            </div>

            <div class="modal-body">

                <p><b>Khách:</b> {{ $o->customer_name }}</p>
                <p><b>Tổng tiền:</b> {{ $o->total }}</p>

                <p><b>Trạng thái:</b>
                    @if($o->status == 'pending')
                        <span class="badge bg-warning">Pending</span>
                    @elseif($o->status == 'processing')
                        <span class="badge bg-primary">Processing</span>
                    @else
                        <span class="badge bg-success">Completed</span>
                    @endif
                </p>

                <hr>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($o->items as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->price }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->price * $item->quantity }}.00</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>

        </div>
    </div>
</div>

@endsection