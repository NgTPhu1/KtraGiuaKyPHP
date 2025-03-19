<?php include 'app/views/shares/header.php'; ?>
<div class="card mb-4">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">DANH SÁCH HỌC PHẦN</h4>
        <?php if (isset($_SESSION['sinhvien_id'])): ?>
            <div>
                <a href="/php/QUANLYSV/SinhVienDangKy/dangky" class="btn btn-success">
                    <i class="fas fa-shopping-cart"></i> 
                    Xem danh sách đăng ký
                    <?php if (isset($_SESSION['giohang_hocphan']) && count($_SESSION['giohang_hocphan']) > 0): ?>
                    <span class="badge badge-light"><?php echo count($_SESSION['giohang_hocphan']); ?></span>
                    <?php endif; ?>
                </a>
                <a href="/php/QUANLYSV/SinhVienDangKy/logout" class="btn btn-warning ml-2">
                    <i class="fas fa-sign-out-alt"></i> Đăng xuất
                </a>
            </div>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['sinhvien_id']) && isset($_SESSION['sinhvien_name'])): ?>
            <div class="alert alert-info">
                <i class="fas fa-user"></i> Xin chào, <strong><?php echo htmlspecialchars($_SESSION['sinhvien_name']); ?></strong>
            </div>
        <?php endif; ?>
        
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Mã Học Phần</th>
                        <th>Tên Học Phần</th>
                        <th>Số Tín Chỉ</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($hocPhans as $hocPhan): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($hocPhan->MaHP); ?></td>
                        <td><?php echo htmlspecialchars($hocPhan->TenHP); ?></td>
                        <td><?php echo $hocPhan->SoTinChi; ?></td>
                        <td>
                            <a href="/php/QUANLYSV/SinhVienDangKy/themhocphan/<?php echo $hocPhan->MaHP; ?>" 
                               class="btn btn-primary btn-sm">
                                <i class="fas fa-plus-circle"></i> Đăng Kí
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include 'app/views/shares/footer.php'; ?>
