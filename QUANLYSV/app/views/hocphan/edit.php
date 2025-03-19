<?php include 'app/views/shares/header.php'; ?>
<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Sửa thông tin học phần</h4>
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
        
        <form method="POST" action="/php/QUANLYSV/HocPhan/update" onsubmit="return validateHocPhanForm();">
            <input type="hidden" name="maHP" value="<?php echo $hocPhan->MaHP; ?>">
            
            <div class="form-group">
                <label for="maHP">Mã học phần:</label>
                <input type="text" id="maHP" class="form-control" value="<?php echo htmlspecialchars($hocPhan->MaHP, ENT_QUOTES, 'UTF-8'); ?>" disabled>
                <small class="form-text text-muted">Mã học phần không thể thay đổi.</small>
            </div>
            <div class="form-group">
                <label for="tenHP">Tên học phần:</label>
                <input type="text" id="tenHP" name="tenHP" class="form-control" value="<?php echo htmlspecialchars($hocPhan->TenHP, ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
            <div class="form-group">
                <label for="soTinChi">Số tín chỉ:</label>
                <input type="number" id="soTinChi" name="soTinChi" class="form-control" min="1" value="<?php echo $hocPhan->SoTinChi; ?>" required>
            </div>
            
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i> Lưu thay đổi
            </button>
            <a href="/php/QUANLYSV/HocPhan" class="btn btn-secondary mt-2">
                <i class="fa fa-arrow-left"></i> Quay lại
            </a>
        </form>
    </div>
</div>

<script>
function validateHocPhanForm() {
    var tenHP = document.getElementById('tenHP').value;
    var soTinChi = document.getElementById('soTinChi').value;
    
    if (tenHP.trim() === '') {
        alert('Vui lòng nhập tên học phần');
        return false;
    }
    
    if (soTinChi <= 0) {
        alert('Số tín chỉ phải lớn hơn 0');
        return false;
    }
    
    return true;
}
</script>

<?php include 'app/views/shares/footer.php'; ?>
