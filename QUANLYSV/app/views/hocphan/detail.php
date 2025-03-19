<?php include 'app/views/shares/header.php'; ?>
<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Chi tiết học phần</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <h2><?php echo htmlspecialchars($hocPhan->TenHP, ENT_QUOTES, 'UTF-8'); ?></h2>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong><i class="fas fa-code"></i> Mã học phần:</strong> <?php echo $hocPhan->MaHP; ?></p>
                        <p><strong><i class="fas fa-star"></i> Số tín chỉ:</strong> <?php echo $hocPhan->SoTinChi; ?></p>
                    </div>
                </div>
                
                <div class="mt-4">
                    <a href="/php/QUANLYSV/HocPhan/edit/<?php echo $hocPhan->MaHP; ?>" class="btn btn-warning">
                        <i class="fa fa-edit"></i> Chỉnh sửa
                    </a>
                    <a href="/php/QUANLYSV/HocPhan" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Quay lại danh sách
                    </a>
                    <a href="/php/QUANLYSV/HocPhan/delete/<?php echo $hocPhan->MaHP; ?>" 
                       class="btn btn-danger"
                       onclick="return confirm('Bạn có chắc chắn muốn xóa học phần này?')">
                        <i class="fa fa-trash"></i> Xóa học phần
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'app/views/shares/footer.php'; ?>
