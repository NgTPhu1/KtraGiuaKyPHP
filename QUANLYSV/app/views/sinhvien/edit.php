<?php include 'app/views/shares/header.php'; ?>
<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Sửa thông tin sinh viên</h4>
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
        
        <form method="POST" action="/php/QUANLYSV/SinhVien/update" enctype="multipart/form-data" onsubmit="return validateForm();">
            <input type="hidden" name="maSV" value="<?php echo $sinhVien->MaSV; ?>">
            <input type="hidden" name="current_image" value="<?php echo $sinhVien->Hinh ?? ''; ?>">
            
            <div class="form-group">
                <label for="maSV">Mã sinh viên:</label>
                <input type="text" id="maSV" class="form-control" value="<?php echo htmlspecialchars($sinhVien->MaSV, ENT_QUOTES, 'UTF-8'); ?>" disabled>
                <small class="form-text text-muted">Mã sinh viên không thể thay đổi.</small>
            </div>
            <div class="form-group">
                <label for="hoTen">Họ tên:</label>
                <input type="text" id="hoTen" name="hoTen" class="form-control" value="<?php echo htmlspecialchars($sinhVien->HoTen, ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
            <div class="form-group">
                <label for="gioiTinh">Giới tính:</label>
                <select id="gioiTinh" name="gioiTinh" class="form-control">
                    <option value="Nam" <?php echo $sinhVien->GioiTinh === 'Nam' ? 'selected' : ''; ?>>Nam</option>
                    <option value="Nữ" <?php echo $sinhVien->GioiTinh === 'Nữ' ? 'selected' : ''; ?>>Nữ</option>
                </select>
            </div>
            <div class="form-group">
                <label for="ngaySinh">Ngày sinh:</label>
                <input type="date" id="ngaySinh" name="ngaySinh" class="form-control" value="<?php echo $sinhVien->NgaySinh; ?>" required>
            </div>
            <div class="form-group">
                <label for="maNganh">Ngành học:</label>
                <select id="maNganh" name="maNganh" class="form-control" required>
                    <option value="">-- Chọn ngành học --</option>
                    <?php foreach ($nganhHocs as $nganhHoc): ?>
                        <option value="<?php echo $nganhHoc->MaNganh; ?>" <?php echo $nganhHoc->MaNganh === $sinhVien->MaNganh ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($nganhHoc->TenNganh, ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>Hình ảnh hiện tại:</label>
                <?php if (!empty($sinhVien->Hinh)): ?>
                    <div class="mb-2">
                        <img src="/php/QUANLYSV/public/images/<?php echo $sinhVien->Hinh; ?>" 
                             alt="<?php echo htmlspecialchars($sinhVien->HoTen, ENT_QUOTES, 'UTF-8'); ?>" 
                             class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                    </div>
                <?php else: ?>
                    <p>Không có hình ảnh.</p>
                <?php endif; ?>
                
                <label for="hinh">Thay đổi hình ảnh:</label>
                <input type="file" id="hinh" name="hinh" class="form-control-file" accept="image/*">
                <small class="form-text text-muted">Chọn hình ảnh mới nếu muốn thay đổi.</small>
            </div>
            
            <!-- Hidden field to store base64 image if needed -->
            <input type="hidden" id="image_base64" name="image_base64">
            
            <!-- Image preview -->
            <div class="mt-2 mb-3">
                <img id="image_preview" src="" alt="Xem trước hình ảnh" 
                     style="max-width: 200px; max-height: 200px; display: none;" class="img-thumbnail">
            </div>
            
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i> Lưu thay đổi
            </button>
            <a href="/php/QUANLYSV/SinhVien" class="btn btn-secondary mt-2">
                <i class="fa fa-arrow-left"></i> Quay lại
            </a>
        </form>
    </div>
</div>

<script>
// Preview image when selected
document.getElementById('hinh').addEventListener('change', function(e) {
    var fileReader = new FileReader();
    fileReader.onload = function(event) {
        document.getElementById('image_preview').src = event.target.result;
        document.getElementById('image_preview').style.display = 'block';
    };
    fileReader.readAsDataURL(e.target.files[0]);
});

// Function to save base64 image from URL
function saveBase64Image(base64Url) {
    document.getElementById('image_base64').value = base64Url;
    document.getElementById('image_preview').src = base64Url;
    document.getElementById('image_preview').style.display = 'block';
}
</script>

<?php include 'app/views/shares/footer.php'; ?>
