<?php include 'app/views/shares/header.php'; ?>
<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Danh sách sinh viên</h4>
    </div>
    <div class="card-body">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        
        <a href="/php/QUANLYSV/SinhVien/add" class="btn btn-success mb-3">
            <i class="fa fa-plus"></i> Thêm sinh viên mới
        </a>
        
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Mã SV</th>
                    <th>Hình</th>
                    <th>Họ tên</th>
                    <th>Giới tính</th>
                    <th>Ngày sinh</th>
                    <th>Ngành học</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sinhViens as $sinhVien): ?>
                <tr>
                    <td><?php echo $sinhVien->MaSV; ?></td>
                    <td>
                        <?php if(!empty($sinhVien->Hinh)): ?>
                            <img src="/php/QUANLYSV/public/images/<?php echo $sinhVien->Hinh; ?>" 
                                 alt="<?php echo htmlspecialchars($sinhVien->HoTen, ENT_QUOTES, 'UTF-8'); ?>" 
                                 style="max-width: 50px; max-height: 50px;" class="img-thumbnail">
                        <?php else: ?>
                            <img src="/php/QUANLYSV/public/images/no-image.jpg" 
                                 alt="Không có hình ảnh" 
                                 style="max-width: 50px; max-height: 50px;" class="img-thumbnail">
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="/php/QUANLYSV/SinhVien/detail/<?php echo $sinhVien->MaSV; ?>">
                            <?php echo htmlspecialchars($sinhVien->HoTen, ENT_QUOTES, 'UTF-8'); ?>
                        </a>
                    </td>
                    <td><?php echo htmlspecialchars($sinhVien->GioiTinh, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($sinhVien->NgaySinh)); ?></td>
                    <td><?php echo htmlspecialchars($sinhVien->TenNganh, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td>
                        <a href="/php/QUANLYSV/SinhVien/detail/<?php echo $sinhVien->MaSV; ?>" 
                           class="btn btn-info btn-sm">
                            <i class="fa fa-eye"></i> Chi tiết
                        </a>
                        <a href="/php/QUANLYSV/SinhVien/edit/<?php echo $sinhVien->MaSV; ?>" 
                           class="btn btn-warning btn-sm">
                            <i class="fa fa-edit"></i> Sửa
                        </a>
                        <a href="/php/QUANLYSV/SinhVien/delete/<?php echo $sinhVien->MaSV; ?>" 
                           class="btn btn-danger btn-sm" 
                           onclick="return confirm('Bạn có chắc chắn muốn xóa sinh viên này?')">
                            <i class="fa fa-trash"></i> Xóa
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include 'app/views/shares/footer.php'; ?>
