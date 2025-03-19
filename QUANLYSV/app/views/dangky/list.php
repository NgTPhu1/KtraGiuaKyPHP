<?php include 'app/views/shares/header.php'; ?>
<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Danh sách đăng ký học phần</h4>
    </div>
    <div class="card-body">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        
        <a href="/php/QUANLYSV/DangKy/add" class="btn btn-success mb-3">
            <i class="fa fa-plus"></i> Thêm đăng ký học phần mới
        </a>
        
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Mã ĐK</th>
                    <th>Ngày đăng ký</th>
                    <th>Sinh viên</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dangKys as $dangKy): ?>
                <tr>
                    <td><?php echo $dangKy->MaDK; ?></td>
                    <td><?php echo date('d/m/Y', strtotime($dangKy->NgayDK)); ?></td>
                    <td>
                        <a href="/php/QUANLYSV/SinhVien/detail/<?php echo $dangKy->MaSV; ?>">
                            <?php echo htmlspecialchars($dangKy->HoTen, ENT_QUOTES, 'UTF-8'); ?>
                        </a>
                    </td>
                    <td>
                        <a href="/php/QUANLYSV/DangKy/detail/<?php echo $dangKy->MaDK; ?>" 
                           class="btn btn-info btn-sm">
                            <i class="fa fa-eye"></i> Chi tiết
                        </a>
                        <a href="/php/QUANLYSV/DangKy/delete/<?php echo $dangKy->MaDK; ?>" 
                           class="btn btn-danger btn-sm" 
                           onclick="return confirm('Bạn có chắc chắn muốn xóa đăng ký học phần này?')">
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
