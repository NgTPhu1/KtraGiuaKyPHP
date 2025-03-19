<?php include 'app/views/shares/header.php'; ?>
<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">ĐĂNG NHẬP</h4>
    </div>
    <div class="card-body">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="POST" action="/php/QUANLYSV/SinhVienDangKy/authenticate">
                    <div class="form-group">
                        <label for="maSV">Mã sinh viên:</label>
                        <input type="text" class="form-control" id="maSV" name="maSV" placeholder="Nhập mã sinh viên (vd: 1234567890)" required>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-sign-in-alt"></i> Đăng Nhập
                        </button>
                    </div>
                </form>
                <div class="text-center mt-3">
                    <a href="/php/QUANLYSV/SinhVien" class="btn btn-link">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'app/views/shares/footer.php'; ?>
