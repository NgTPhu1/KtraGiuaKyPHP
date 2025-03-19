<?php
require_once('app/config/database.php');
require_once('app/models/SinhVienModel.php');
require_once('app/models/HocPhanModel.php');
require_once('app/models/DangKyModel.php');

class SinhVienDangKyController
{
    private $db;
    private $sinhVienModel;
    private $hocPhanModel;
    private $dangKyModel;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->sinhVienModel = new SinhVienModel($this->db);
        $this->hocPhanModel = new HocPhanModel($this->db);
        $this->dangKyModel = new DangKyModel($this->db);
    }

    // Hiển thị trang đăng nhập
    public function login()
    {
        // Nếu đã đăng nhập thì chuyển hướng đến danh sách học phần
        if (isset($_SESSION['sinhvien_id'])) {
            header('Location: /php/QUANLYSV/SinhVienDangKy/hocphan');
            exit;
        }
        
        include 'app/views/sinhviendangky/login.php';
    }

    // Xử lý đăng nhập
    public function authenticate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maSV = $_POST['maSV'] ?? '';
            
            // Kiểm tra mã sinh viên có tồn tại không
            $sinhVien = $this->sinhVienModel->getSinhVienById($maSV);
            
            if ($sinhVien) {
                // Lưu thông tin sinh viên vào session
                $_SESSION['sinhvien_id'] = $sinhVien->MaSV;
                $_SESSION['sinhvien_name'] = $sinhVien->HoTen;
                
                // Chuyển hướng đến trang danh sách học phần
                header('Location: /php/QUANLYSV/SinhVienDangKy/hocphan');
            } else {
                $_SESSION['error'] = "Mã sinh viên không tồn tại trong hệ thống";
                header('Location: /php/QUANLYSV/SinhVienDangKy/login');
            }
        }
    }

    // Đăng xuất
    public function logout()
    {
        // Xóa thông tin sinh viên khỏi session
        unset($_SESSION['sinhvien_id']);
        unset($_SESSION['sinhvien_name']);
        unset($_SESSION['giohang_hocphan']);
        
        $_SESSION['success'] = "Đã đăng xuất thành công";
        header('Location: /php/QUANLYSV/SinhVienDangKy/login');
    }

    // Hiển thị danh sách học phần
    public function hocphan()
    {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['sinhvien_id'])) {
            $_SESSION['error'] = "Bạn cần đăng nhập để xem danh sách học phần";
            header('Location: /php/QUANLYSV/SinhVienDangKy/login');
            exit;
        }
        
        $hocPhans = $this->hocPhanModel->getHocPhans();
        include 'app/views/sinhviendangky/hocphan.php';
    }

    // Thêm học phần vào giỏ đăng ký
    public function themhocphan($maHP)
    {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['sinhvien_id'])) {
            $_SESSION['error'] = "Bạn cần đăng nhập để đăng ký học phần";
            header('Location: /php/QUANLYSV/SinhVienDangKy/login');
            exit;
        }
        
        // Lấy thông tin học phần
        $hocPhan = $this->hocPhanModel->getHocPhanById($maHP);
        
        if (!$hocPhan) {
            $_SESSION['error'] = "Học phần không tồn tại";
            header('Location: /php/QUANLYSV/SinhVienDangKy/hocphan');
            exit;
        }
        
        // Khởi tạo giỏ đăng ký nếu chưa có
        if (!isset($_SESSION['giohang_hocphan'])) {
            $_SESSION['giohang_hocphan'] = [];
        }
        
        // Thêm học phần vào giỏ nếu chưa có
        if (!isset($_SESSION['giohang_hocphan'][$maHP])) {
            $_SESSION['giohang_hocphan'][$maHP] = [
                'MaHP' => $hocPhan->MaHP,
                'TenHP' => $hocPhan->TenHP,
                'SoTinChi' => $hocPhan->SoTinChi
            ];
            $_SESSION['success'] = "Đã thêm học phần {$hocPhan->TenHP} vào danh sách đăng ký";
        } else {
            $_SESSION['error'] = "Học phần {$hocPhan->TenHP} đã có trong danh sách đăng ký";
        }
        
        header('Location: /php/QUANLYSV/SinhVienDangKy/hocphan');
    }

    // Hiển thị danh sách học phần đã đăng ký
    public function dangky()
    {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['sinhvien_id'])) {
            $_SESSION['error'] = "Bạn cần đăng nhập để xem đăng ký học phần";
            header('Location: /php/QUANLYSV/SinhVienDangKy/login');
            exit;
        }
        
        include 'app/views/sinhviendangky/dangky.php';
    }

    // Xóa học phần khỏi giỏ đăng ký
    public function xoahocphan($maHP)
    {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['sinhvien_id'])) {
            $_SESSION['error'] = "Bạn cần đăng nhập để xóa học phần";
            header('Location: /php/QUANLYSV/SinhVienDangKy/login');
            exit;
        }
        
        // Xóa học phần khỏi giỏ
        if (isset($_SESSION['giohang_hocphan'][$maHP])) {
            $tenHP = $_SESSION['giohang_hocphan'][$maHP]['TenHP'];
            unset($_SESSION['giohang_hocphan'][$maHP]);
            $_SESSION['success'] = "Đã xóa học phần {$tenHP} khỏi danh sách đăng ký";
        }
        
        header('Location: /php/QUANLYSV/SinhVienDangKy/dangky');
    }

    // Xóa toàn bộ giỏ đăng ký
    public function xoatoanbo()
    {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['sinhvien_id'])) {
            $_SESSION['error'] = "Bạn cần đăng nhập để xóa đăng ký";
            header('Location: /php/QUANLYSV/SinhVienDangKy/login');
            exit;
        }
        
        // Xóa toàn bộ giỏ
        $_SESSION['giohang_hocphan'] = [];
        $_SESSION['success'] = "Đã xóa toàn bộ danh sách đăng ký học phần";
        
        header('Location: /php/QUANLYSV/SinhVienDangKy/dangky');
    }

    // Xác nhận trước khi lưu đăng ký học phần
    public function xacnhandangky()
    {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['sinhvien_id'])) {
            $_SESSION['error'] = "Bạn cần đăng nhập để xác nhận đăng ký học phần";
            header('Location: /php/QUANLYSV/SinhVienDangKy/login');
            exit;
        }
        
        // Kiểm tra giỏ có học phần nào không
        if (!isset($_SESSION['giohang_hocphan']) || count($_SESSION['giohang_hocphan']) == 0) {
            $_SESSION['error'] = "Danh sách đăng ký của bạn đang trống";
            header('Location: /php/QUANLYSV/SinhVienDangKy/dangky');
            exit;
        }
        
        // Lấy thông tin sinh viên để hiển thị
        $sinhVien = $this->sinhVienModel->getSinhVienById($_SESSION['sinhvien_id']);
        
        // Truyền dữ liệu đến view xác nhận
        include 'app/views/sinhviendangky/xacnhandangky.php';
    }

    // Lưu đăng ký học phần (đã sửa)
    public function luudangky()
    {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['sinhvien_id'])) {
            $_SESSION['error'] = "Bạn cần đăng nhập để lưu đăng ký học phần";
            header('Location: /php/QUANLYSV/SinhVienDangKy/login');
            exit;
        }
        
        // Kiểm tra giỏ có học phần nào không
        if (!isset($_SESSION['giohang_hocphan']) || count($_SESSION['giohang_hocphan']) == 0) {
            $_SESSION['error'] = "Danh sách đăng ký của bạn đang trống";
            header('Location: /php/QUANLYSV/SinhVienDangKy/dangky');
            exit;
        }
        
        // Chuẩn bị dữ liệu
        $maSV = $_SESSION['sinhvien_id'];
        $ngayDK = date('Y-m-d');
        $maHPs = array_keys($_SESSION['giohang_hocphan']);
        
        // Kiểm tra tồn tại của sinh viên
        $sinhVien = $this->sinhVienModel->getSinhVienById($maSV);
        if (!$sinhVien) {
            $_SESSION['error'] = "Không tìm thấy thông tin sinh viên. Vui lòng đăng nhập lại.";
            header('Location: /php/QUANLYSV/SinhVienDangKy/login');
            exit;
        }
        
        // Kiểm tra tồn tại của các học phần
        $invalidCourses = [];
        foreach ($maHPs as $maHP) {
            $hocPhan = $this->hocPhanModel->getHocPhanById($maHP);
            if (!$hocPhan) {
                $invalidCourses[] = $maHP;
            }
        }
        
        if (!empty($invalidCourses)) {
            $_SESSION['error'] = "Các học phần sau không tồn tại: " . implode(", ", $invalidCourses);
            header('Location: /php/QUANLYSV/SinhVienDangKy/dangky');
            exit;
        }
        
        // Lưu đăng ký
        $result = $this->dangKyModel->addDangKy($maSV, $ngayDK, $maHPs);
        
        if ($result === true) {
            $_SESSION['success'] = "Thông Tin Học Phần Đã Lưu";
            // Xóa giỏ sau khi lưu thành công
            $_SESSION['giohang_hocphan'] = [];
            // Hiển thị trang thông báo thành công
            header('Location: /php/QUANLYSV/SinhVienDangKy/dangkythanhcong');
        } else {
            if (is_array($result) && isset($result['database_error'])) {
                $_SESSION['error'] = "Lỗi cơ sở dữ liệu: " . $result['database_error'];
            } else {
                $_SESSION['error'] = "Đã xảy ra lỗi khi lưu đăng ký học phần";
            }
            header('Location: /php/QUANLYSV/SinhVienDangKy/dangky');
        }
    }
    
    // Hiển thị trang thông báo đăng ký thành công
    public function dangkythanhcong()
    {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['sinhvien_id'])) {
            header('Location: /php/QUANLYSV/SinhVienDangKy/login');
            exit;
        }
        
        include 'app/views/sinhviendangky/dangkythanhcong.php';
    }
}
