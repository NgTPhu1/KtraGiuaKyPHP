<?php
require_once('app/config/database.php');
require_once('app/models/SinhVienModel.php');
require_once('app/utils/ImageProcessor.php');

class SinhVienController
{
    private $sinhVienModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->sinhVienModel = new SinhVienModel($this->db);
    }

    public function index()
    {
        $sinhViens = $this->sinhVienModel->getSinhViens();
        include 'app/views/sinhvien/list.php';
    }

    public function detail($maSV)
    {
        $sinhVien = $this->sinhVienModel->getSinhVienById($maSV);
        if ($sinhVien) {
            include 'app/views/sinhvien/detail.php';
        } else {
            $_SESSION['error'] = "Không tìm thấy sinh viên.";
            header('Location: /php/QUANLYSV/SinhVien');
        }
    }

    public function add()
    {
        $nganhHocs = $this->sinhVienModel->getNganhHocs();
        include 'app/views/sinhvien/add.php';
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maSV = $_POST['maSV'] ?? '';
            $hoTen = $_POST['hoTen'] ?? '';
            $gioiTinh = $_POST['gioiTinh'] ?? '';
            $ngaySinh = $_POST['ngaySinh'] ?? null;
            $maNganh = $_POST['maNganh'] ?? null;
            $image_base64 = $_POST['image_base64'] ?? null;
            
            // Process uploaded image
            $image = $image_base64;
            if (isset($_FILES['hinh']) && $_FILES['hinh']['error'] === UPLOAD_ERR_OK) {
                // Create images directory if it doesn't exist
                $image_dir = BASE_PATH . '/public/images/';
                if (!file_exists($image_dir)) {
                    mkdir($image_dir, 0755, true);
                }
                
                $image_tmp = $_FILES['hinh']['tmp_name'];
                $image_name = 'student_' . uniqid() . '_' . $_FILES['hinh']['name'];
                $target_path = $image_dir . $image_name;
                
                if (move_uploaded_file($image_tmp, $target_path)) {
                    $image = $image_name;
                }
            }

            $result = $this->sinhVienModel->addSinhVien($maSV, $hoTen, $gioiTinh, $ngaySinh, $maNganh, $image);

            if (is_array($result)) {
                $errors = $result;
                $nganhHocs = $this->sinhVienModel->getNganhHocs();
                include 'app/views/sinhvien/add.php';
            } else {
                $_SESSION['success'] = "Thêm sinh viên thành công!";
                header('Location: /php/QUANLYSV/SinhVien');
            }
        }
    }

    public function edit($maSV)
    {
        $sinhVien = $this->sinhVienModel->getSinhVienById($maSV);
        if ($sinhVien) {
            $nganhHocs = $this->sinhVienModel->getNganhHocs();
            include 'app/views/sinhvien/edit.php';
        } else {
            $_SESSION['error'] = "Không tìm thấy sinh viên.";
            header('Location: /php/QUANLYSV/SinhVien');
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maSV = $_POST['maSV'];
            $hoTen = $_POST['hoTen'];
            $gioiTinh = $_POST['gioiTinh'];
            $ngaySinh = $_POST['ngaySinh'];
            $maNganh = $_POST['maNganh'];
            $image_base64 = $_POST['image_base64'] ?? null;
            $current_image = $_POST['current_image'] ?? null;
            
            // Process uploaded image
            $image = $current_image;
            if (isset($_FILES['hinh']) && $_FILES['hinh']['error'] === UPLOAD_ERR_OK) {
                // Create images directory if it doesn't exist
                $image_dir = BASE_PATH . '/public/images/';
                if (!file_exists($image_dir)) {
                    mkdir($image_dir, 0755, true);
                }
                
                $image_tmp = $_FILES['hinh']['tmp_name'];
                $image_name = 'student_' . uniqid() . '_' . $_FILES['hinh']['name'];
                $target_path = $image_dir . $image_name;
                
                if (move_uploaded_file($image_tmp, $target_path)) {
                    $image = $image_name;
                }
            } else if ($image_base64) {
                $image = $image_base64;
            }

            $result = $this->sinhVienModel->updateSinhVien($maSV, $hoTen, $gioiTinh, $ngaySinh, $maNganh, $image);

            if ($result) {
                $_SESSION['success'] = "Cập nhật sinh viên thành công!";
                header('Location: /php/QUANLYSV/SinhVien');
            } else {
                $_SESSION['error'] = "Đã xảy ra lỗi khi cập nhật sinh viên.";
                header('Location: /php/QUANLYSV/SinhVien/edit/' . $maSV);
            }
        }
    }

    public function delete($maSV)
    {
        $result = $this->sinhVienModel->deleteSinhVien($maSV);
        
        if ($result === 'success') {
            $_SESSION['success'] = "Xóa sinh viên thành công!";
        } else if ($result === 'cannot_delete') {
            $_SESSION['error'] = "Không thể xóa sinh viên này vì đã có đăng ký học phần.";
        } else {
            $_SESSION['error'] = "Đã xảy ra lỗi khi xóa sinh viên.";
        }
        
        header('Location: /php/QUANLYSV/SinhVien');
    }
}
