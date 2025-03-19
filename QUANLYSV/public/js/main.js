// JavaScript chính cho ứng dụng
document.addEventListener('DOMContentLoaded', function() {
    console.log('Quản lý sinh viên MVC đã sẵn sàng!');
    
    // Tự động đóng thông báo alert sau 5 giây
    setTimeout(function() {
        var alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            if (alert && alert.parentNode) {
                alert.parentNode.removeChild(alert);
            }
        });
    }, 5000);
});

// Xác thực form sinh viên
function validateForm() {
    var maSV = document.getElementById('maSV');
    var hoTen = document.getElementById('hoTen');
    var ngaySinh = document.getElementById('ngaySinh');
    
    if (maSV && maSV.value.trim() === '') {
        alert('Vui lòng nhập mã sinh viên');
        return false;
    }
    
    if (hoTen.value.trim() === '') {
        alert('Vui lòng nhập họ tên sinh viên');
        return false;
    }

    if (ngaySinh.value === '') {
        alert('Vui lòng chọn ngày sinh');
        return false;
    }
    
    return true;
}

// Xác thực form học phần
function validateHocPhanForm() {
    var maHP = document.getElementById('maHP');
    var tenHP = document.getElementById('tenHP');
    var soTinChi = document.getElementById('soTinChi');
    
    if (maHP && maHP.value.trim() === '') {
        alert('Vui lòng nhập mã học phần');
        return false;
    }
    
    if (tenHP.value.trim() === '') {
        alert('Vui lòng nhập tên học phần');
        return false;
    }
    
    if (parseInt(soTinChi.value) <= 0) {
        alert('Số tín chỉ phải lớn hơn 0');
        return false;
    }
    
    return true;
}
