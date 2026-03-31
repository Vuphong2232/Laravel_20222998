<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Quản lý sinh viên</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background: #343a40;
            color: white;
            position: fixed;
        }

        .sidebar a {
            color: white;
            display: block;
            padding: 15px;
            text-decoration: none;
        }

        .sidebar a:hover {
            background: #495057;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }
    </style>
</head>

<body>

<!-- Sidebar -->
<div class="sidebar">
    <h4 class="p-3">📚 Menu</h4>

    <a href="{{ route('students.index') }}">
        👨‍🎓 Quản lý sinh viên
    </a>

    <a href="{{ route('products.index') }}">📦 Quản lý sản phẩm</a>

    <a href="{{ route('courses.index') }}">📘 Môn học</a>

<a href="{{ route('enrollments.index') }}">📝 Đăng ký môn</a>

<a href="{{ route('orders.index') }}" class="list-group-item">
        🧾 Quản lý đơn hàng
    </a>

    <a href="{{ route('booking.index') }}" class="list-group-item">
    📅 Booking (Đặt lịch)
</a>

    <!-- Sau này thêm -->
    <!-- <a href="#">📦 Sản phẩm</a> -->
</div>

<!-- Nội dung -->
<div class="content">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>