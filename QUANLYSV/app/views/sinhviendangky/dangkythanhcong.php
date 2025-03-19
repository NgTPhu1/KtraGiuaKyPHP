<?php include 'app/views/shares/header.php'; ?>
<div class="card mb-4">
    <div class="card-header bg-success text-white">
        <h4 class="mb-0"><i class="fas fa-check-circle"></i> ĐĂNG KÝ THÀNH CÔNG</h4>
    </div>
    <div class="card-body text-center">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <h3><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></h3>
            </div>
        <?php else: ?>
            <div class="alert alert-success">
                <h3>Thông Tin Học Phần Đã Lưu</h3>
            </div>
        <?php endif; ?>
        
        <p class="lead">Cảm ơn bạn đã đăng ký học phần. Thông tin đăng ký của bạn đã được lưu thành công vào hệ thống.</p>
        
        <div class="mt-5">
            <a href="/php/QUANLYSV/SinhVienDangKy/hocphan" class="btn btn-primary">
                <i class="fas fa-list"></i> Xem danh sách học phần
            </a>
            <a href="/php/QUANLYSV/SinhVienDangKy/dangky" class="btn btn-info ml-2">
                <i class="fas fa-plus-circle"></i> Đăng ký thêm học phần
            </a>
        </div>
    </div>
</div>
<?php include 'app/views/shares/footer.php'; ?>
