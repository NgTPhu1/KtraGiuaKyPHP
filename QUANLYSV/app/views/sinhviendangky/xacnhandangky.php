<?php include 'app/views/shares/header.php'; ?>
<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">XÁC NHẬN ĐĂNG KÝ HỌC PHẦN</h4>
    </div>
    <div class="card-body">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        
        <!-- Phần thông tin sinh viên -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Thông tin Đăng ký</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Mã số sinh viên:</strong> <?php echo $sinhVien->MaSV; ?></p>
                        <p><strong>Họ tên sinh viên:</strong> <?php echo htmlspecialchars($sinhVien->HoTen); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Ngày sinh:</strong> <?php echo date('d/m/Y', strtotime($sinhVien->NgaySinh)); ?></p>
                        <p><strong>Ngành học:</strong> <?php echo htmlspecialchars($sinhVien->TenNganh); ?></p>
                        <p><strong>Ngày đăng ký:</strong> <?php echo date('d/m/Y'); ?></p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Phần danh sách học phần đăng ký -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Danh sách học phần đăng ký</h5>
            </div>
            <div class="card-body">
                <?php 
                $totalCredits = 0;
                $courseCount = 0;
                
                if (isset($_SESSION['giohang_hocphan'])) {
                    $courseCount = count($_SESSION['giohang_hocphan']);
                    foreach ($_SESSION['giohang_hocphan'] as $hocPhan) {
                        $totalCredits += $hocPhan['SoTinChi'];
                    }
                }
                ?>
                
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>MãHP</th>
                                <th>Tên Học Phần</th>
                                <th>Số Tín Chỉ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($_SESSION['giohang_hocphan'] as $maHP => $hocPhan): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($hocPhan['MaHP']); ?></td>
                                <td><?php echo htmlspecialchars($hocPhan['TenHP']); ?></td>
                                <td><?php echo $hocPhan['SoTinChi']; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="table-info">
                                <td colspan="2"><strong>Tổng cộng</strong></td>
                                <td><strong><?php echo $totalCredits; ?></strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <div class="mt-3">
                    <p><strong>Số học phần: <?php echo $courseCount; ?></strong></p>
                    <p><strong>Tổng số tín chỉ: <?php echo $totalCredits; ?></strong></p>
                </div>
            </div>
        </div>
        
        <!-- Nút điều hướng -->
        <div class="mt-4 text-center">
            <a href="/php/QUANLYSV/SinhVienDangKy/dangky" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Trở về giỏ hàng
            </a>
            <a href="/php/QUANLYSV/SinhVienDangKy/luudangky" 
               class="btn btn-primary btn-lg ml-3"
               onclick="return confirm('Bạn có chắc chắn muốn xác nhận đăng ký các học phần này?')">
                <i class="fas fa-check"></i> Xác Nhận
            </a>
        </div>
    </div>
</div>
<?php include 'app/views/shares/footer.php'; ?>
