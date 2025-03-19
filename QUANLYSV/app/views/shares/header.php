<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Hệ thống quản lý sinh viên">
    <title>Quản lý sinh viên</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/php/QUANLYSV/public/images/favicon.png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/php/QUANLYSV/public/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/php/QUANLYSV">
                <i class="fas fa-graduation-cap me-2"></i>
                <span>SINH VIEN</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/php/QUANLYSV/SinhVien">
                            <i class="fas fa-user-graduate me-1"></i> Sinh viên
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/php/QUANLYSV/HocPhan">
                            <i class="fas fa-book me-1"></i> Học phần
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/php/QUANLYSV/DangKy">
                            <i class="fas fa-clipboard-list me-1"></i> Đăng ký
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <?php if (isset($_SESSION['sinhvien_id'])): ?>
                            <div class="d-flex align-items-center">
                                <span class="nav-link me-2">
                                    <i class="fas fa-user"></i> <?php echo htmlspecialchars($_SESSION['sinhvien_name']); ?>
                                </span>
                                <a class="btn btn-outline-danger btn-sm" href="/php/QUANLYSV/SinhVienDangKy/logout">
                                    <i class="fas fa-sign-out-alt"></i> Đăng xuất
                                </a>
                            </div>
                        <?php else: ?>
                            <a class="btn btn-outline-primary btn-sm" href="/php/QUANLYSV/SinhVienDangKy/login">
                                <i class="fas fa-sign-in-alt"></i> Đăng nhập
                            </a>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container my-4">
