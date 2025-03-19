<?php include 'app/views/shares/header.php'; ?>
<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Thông tin chi tiết sinh viên</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <?php if(!empty($sinhVien->Hinh)): ?>
                    <img src="/php/QUANLYSV/public/images/<?php echo $sinhVien->Hinh; ?>" 
                         alt="<?php echo htmlspecialchars($sinhVien->HoTen, ENT_QUOTES, 'UTF-8'); ?>" 
                         class="img-fluid rounded">
                <?php else: ?>
                    <img src="/php/QUANLYSV/public/images/no-image.jpg" 
                         alt="Không có hình ảnh" 
                         class="img-fluid rounded">
                <?php endif; ?>
            </div>
            <div class="col-md-8">
                <h2><?php echo htmlspecialchars($sinhVien->HoTen, ENT_QUOTES, 'UTF-8'); ?></h2>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong><i class="fas fa-id-card"></i> Mã sinh viên:</strong> <?php echo $sinhVien->MaSV; ?></p>
                        <p><strong><i class="fas fa-venus-mars"></i> Giới tính:</strong> <?php echo htmlspecialchars($sinhVien->GioiTinh, ENT_QUOTES, 'UTF-8'); ?></p>
                        <p><strong><i class="fas fa-birthday-cake"></i> Ngày sinh:</strong> <?php echo date('d/m/Y', strtotime($sinhVien->NgaySinh)); ?></p>
                        <p><strong><i class="fas fa-graduation-cap"></i> Ngành học:</strong> <?php echo htmlspecialchars($sinhVien->TenNganh, ENT_QUOTES, 'UTF-8'); ?></p>
                    </div>
                </div>
                
                <div class="mt-4">
                    <a href="/php/QUANLYSV/SinhVien/edit/<?php echo $sinhVien->MaSV; ?>" class="btn btn-warning">
                        <i class="fa fa-edit"></i> Chỉnh sửa
                    </a>
                    <a href="/php/QUANLYSV/SinhVien" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Quay lại danh sách
                    </a>
                    <a href="/php/QUANLYSV/SinhVien/delete/<?php echo $sinhVien->MaSV; ?>" 
                       class="btn btn-danger"
                       onclick="return confirm('Bạn có chắc chắn muốn xóa sinh viên này?')">
                        <i class="fa fa-trash"></i> Xóa sinh viên
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if(isset($dangKys) && count($dangKys) > 0): ?>
<div class="card mt-4">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0">Các học phần đã đăng ký</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Mã đăng ký</th>
                    <th>Ngày đăng ký</th>
                    <th>Số học phần</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dangKys as $dangKy): ?>
                <tr>
                    <td><?php echo $dangKy->MaDK; ?></td>
                    <td><?php echo date('d/m/Y', strtotime($dangKy->NgayDK)); ?></td>
                    <td><?php echo $dangKy->SoLuongHP; ?></td>
                    <td>
                        <a href="/php/QUANLYSV/DangKy/detail/<?php echo $dangKy->MaDK; ?>" class="btn btn-info btn-sm">
                            <i class="fa fa-eye"></i> Chi tiết
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<?php include 'app/views/shares/footer.php'; ?>
