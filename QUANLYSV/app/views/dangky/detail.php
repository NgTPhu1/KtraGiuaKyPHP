<?php include 'app/views/shares/header.php'; ?>
<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Chi tiết đăng ký học phần</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <h2>Thông tin đăng ký</h2>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong><i class="fas fa-id-card"></i> Mã đăng ký:</strong> <?php echo $dangKy->MaDK; ?></p>
                        <p><strong><i class="fas fa-calendar-alt"></i> Ngày đăng ký:</strong> <?php echo date('d/m/Y', strtotime($dangKy->NgayDK)); ?></p>
                        <p><strong><i class="fas fa-user-graduate"></i> Sinh viên:</strong> 
                            <a href="/php/QUANLYSV/SinhVien/detail/<?php echo $dangKy->MaSV; ?>">
                                <?php echo htmlspecialchars($dangKy->HoTen, ENT_QUOTES, 'UTF-8'); ?>
                            </a>
                        </p>
                    </div>
                </div>
                
                <h3 class="mt-4">Danh sách học phần đăng ký</h3>
                <table class="table table-bordered table-striped mt-3">
                    <thead class="thead-dark">
                        <tr>
                            <th>Mã học phần</th>
                            <th>Tên học phần</th>
                            <th>Số tín chỉ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $totalCredits = 0;
                        foreach ($chiTiets as $chiTiet): 
                            $totalCredits += $chiTiet->SoTinChi;
                        ?>
                        <tr>
                            <td><?php echo $chiTiet->MaHP; ?></td>
                            <td>
                                <a href="/php/QUANLYSV/HocPhan/detail/<?php echo $chiTiet->MaHP; ?>">
                                    <?php echo htmlspecialchars($chiTiet->TenHP, ENT_QUOTES, 'UTF-8'); ?>
                                </a>
                            </td>
                            <td><?php echo $chiTiet->SoTinChi; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr class="table-info">
                            <td colspan="2" class="text-right"><strong>Tổng số tín chỉ:</strong></td>
                            <td><strong><?php echo $totalCredits; ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
                
                <div class="mt-4">
                    <a href="/php/QUANLYSV/DangKy" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Quay lại danh sách
                    </a>
                    <a href="/php/QUANLYSV/DangKy/delete/<?php echo $dangKy->MaDK; ?>" 
                       class="btn btn-danger"
                       onclick="return confirm('Bạn có chắc chắn muốn xóa đăng ký học phần này?')">
                        <i class="fa fa-trash"></i> Xóa đăng ký
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'app/views/shares/footer.php'; ?>
