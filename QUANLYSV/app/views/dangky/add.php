<?php include 'app/views/shares/header.php'; ?>
<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Thêm đăng ký học phần mới</h4>
    </div>
    <div class="card-body">
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="/php/QUANLYSV/DangKy/save" onsubmit="return validateDangKyForm();">
            <div class="form-group">
                <label for="maSV">Sinh viên:</label>
                <select id="maSV" name="maSV" class="form-control" required>
                    <option value="">-- Chọn sinh viên --</option>
                    <?php foreach ($sinhViens as $sinhVien): ?>
                        <option value="<?php echo $sinhVien->MaSV; ?>">
                            <?php echo htmlspecialchars($sinhVien->MaSV . ' - ' . $sinhVien->HoTen, ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="ngayDK">Ngày đăng ký:</label>
                <input type="date" id="ngayDK" name="ngayDK" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Chọn học phần:</label>
                <div class="card">
                    <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                        <?php foreach ($hocPhans as $hocPhan): ?>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="hp_<?php echo $hocPhan->MaHP; ?>" 
                                       name="maHPs[]" value="<?php echo $hocPhan->MaHP; ?>">
                                <label class="custom-control-label" for="hp_<?php echo $hocPhan->MaHP; ?>">
                                    <?php echo htmlspecialchars($hocPhan->MaHP . ' - ' . $hocPhan->TenHP . ' (' . $hocPhan->SoTinChi . ' tín chỉ)', ENT_QUOTES, 'UTF-8'); ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i> Lưu đăng ký
            </button>
            <a href="/php/QUANLYSV/DangKy" class="btn btn-secondary mt-2">
                <i class="fa fa-arrow-left"></i> Quay lại
            </a>
        </form>
    </div>
</div>

<script>
function validateDangKyForm() {
    var maSV = document.getElementById('maSV').value;
    var selectedHP = document.querySelectorAll('input[name="maHPs[]"]:checked');
    
    if (maSV.trim() === '') {
        alert('Vui lòng chọn sinh viên');
        return false;
    }
    
    if (selectedHP.length === 0) {
        alert('Vui lòng chọn ít nhất một học phần');
        return false;
    }
    
    return true;
}
</script>

<?php include 'app/views/shares/footer.php'; ?>
