<?php include 'app/views/shares/header.php'; ?>
<div class="card mb-4">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">ĐĂNG KÍ HỌC PHẦN</h4>
        <div>
            <a href="/php/QUANLYSV/SinhVienDangKy/hocphan" class="btn btn-info">
                <i class="fas fa-list"></i> Danh sách học phần
            </a>
            <a href="/php/QUANLYSV/SinhVienDangKy/logout" class="btn btn-warning ml-2">
                <i class="fas fa-sign-out-alt"></i> Đăng xuất
            </a>
        </div>
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
                <i class="fas fa-user"></i> Sinh viên: <strong><?php echo htmlspecialchars($_SESSION['sinhvien_name']); ?></strong> (<?php echo $_SESSION['sinhvien_id']; ?>)
            </div>
        <?php endif; ?>
        
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
        
        <?php if ($courseCount == 0): ?>
            <div class="alert alert-warning">
                <i class="fas fa-info-circle"></i> Bạn chưa đăng ký học phần nào.
                <a href="/php/QUANLYSV/SinhVienDangKy/hocphan" class="btn btn-link">Đăng ký ngay</a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>MãHP</th>
                            <th>Tên Học Phần</th>
                            <th>Số Tín Chỉ</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['giohang_hocphan'] as $maHP => $hocPhan): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($hocPhan['MaHP']); ?></td>
                            <td><?php echo htmlspecialchars($hocPhan['TenHP']); ?></td>
                            <td><?php echo $hocPhan['SoTinChi']; ?></td>
                            <td>
                                <a href="/php/QUANLYSV/SinhVienDangKy/xoahocphan/<?php echo $maHP; ?>" 
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa học phần này?')">
                                    <i class="fas fa-trash-alt"></i> Xóa
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr class="table-info">
                            <td colspan="2"><strong>Tổng cộng</strong></td>
                            <td><strong><?php echo $totalCredits; ?></strong></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <div class="mt-3">
                <div class="row">
                    <div class="col">
                        <p><strong>Số học phần: <?php echo $courseCount; ?></strong></p>
                        <p><strong>Tổng số tín chỉ: <?php echo $totalCredits; ?></strong></p>
                    </div>
                    <div class="col text-right">
                        <a href="/php/QUANLYSV/SinhVienDangKy/xoatoanbo" 
                           class="btn btn-danger"
                           onclick="return confirm('Bạn có chắc chắn muốn xóa toàn bộ đăng ký?')">
                            <i class="fas fa-trash-alt"></i> Xóa Đăng Ký
                        </a>
                        <!-- Thay đổi đường dẫn từ luudangky sang xacnhandangky -->
                        <a href="/php/QUANLYSV/SinhVienDangKy/xacnhandangky" 
                           class="btn btn-success">
                            <i class="fas fa-save"></i> Lưu đăng ký
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php include 'app/views/shares/footer.php'; ?>
