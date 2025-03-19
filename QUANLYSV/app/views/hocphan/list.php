<?php include 'app/views/shares/header.php'; ?>
<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Danh sách học phần</h4>
    </div>
    <div class="card-body">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        
        <a href="/php/QUANLYSV/HocPhan/add" class="btn btn-success mb-3">
            <i class="fa fa-plus"></i> Thêm học phần mới
        </a>
        
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Mã HP</th>
                    <th>Tên học phần</th>
                    <th>Số tín chỉ</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($hocPhans as $hocPhan): ?>
                <tr>
                    <td><?php echo $hocPhan->MaHP; ?></td>
                    <td>
                        <a href="/php/QUANLYSV/HocPhan/detail/<?php echo $hocPhan->MaHP; ?>">
                            <?php echo htmlspecialchars($hocPhan->TenHP, ENT_QUOTES, 'UTF-8'); ?>
                        </a>
                    </td>
                    <td><?php echo $hocPhan->SoTinChi; ?></td>
                    <td>
                        <a href="/php/QUANLYSV/HocPhan/detail/<?php echo $hocPhan->MaHP; ?>" 
                           class="btn btn-info btn-sm">
                            <i class="fa fa-eye"></i> Chi tiết
                        </a>
                        <a href="/php/QUANLYSV/HocPhan/edit/<?php echo $hocPhan->MaHP; ?>" 
                           class="btn btn-warning btn-sm">
                            <i class="fa fa-edit"></i> Sửa
                        </a>
                        <a href="/php/QUANLYSV/HocPhan/delete/<?php echo $hocPhan->MaHP; ?>" 
                           class="btn btn-danger btn-sm" 
                           onclick="return confirm('Bạn có chắc chắn muốn xóa học phần này?')">
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
