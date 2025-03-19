<?php
require_once('app/config/database.php');
require_once('app/models/DangKyModel.php');
require_once('app/models/SinhVienModel.php');
require_once('app/models/HocPhanModel.php');

class DangKyController
{
    private $dangKyModel;
    private $sinhVienModel;
    private $hocPhanModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->dangKyModel = new DangKyModel($this->db);
        $this->sinhVienModel = new SinhVienModel($this->db);
        $this->hocPhanModel = new HocPhanModel($this->db);
    }

    public function index()
    {
        $dangKys = $this->dangKyModel->getDangKys();
        include 'app/views/dangky/list.php';
    }

    public function detail($maDK)
    {
        $dangKy = $this->dangKyModel->getDangKyById($maDK);
        if ($dangKy) {
            $chiTiets = $this->dangKyModel->getChiTietDangKy($maDK);
            include 'app/views/dangky/detail.php';
        } else {
            $_SESSION['error'] = "Không tìm thấy đăng ký.";
            header('Location: /php/QUANLYSV/DangKy');
        }
    }

    public function add()
    {
        $sinhViens = $this->sinhVienModel->getSinhViens();
        $hocPhans = $this->hocPhanModel->getHocPhans();
        include 'app/views/dangky/add.php';
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maSV = $_POST['maSV'] ?? '';
            $ngayDK = $_POST['ngayDK'] ?? date('Y-m-d');
            $maHPs = $_POST['maHPs'] ?? [];

            $result = $this->dangKyModel->addDangKy($maSV, $ngayDK, $maHPs);

            if (is_array($result)) {
                $errors = $result;
                $sinhViens = $this->sinhVienModel->getSinhViens();
                $hocPhans = $this->hocPhanModel->getHocPhans();
                include 'app/views/dangky/add.php';
            } else {
                $_SESSION['success'] = "Thêm đăng ký học phần thành công!";
                header('Location: /php/QUANLYSV/DangKy');
            }
        }
    }

    public function delete($maDK)
    {
        $result = $this->dangKyModel->deleteDangKy($maDK);
        
        if ($result === 'success') {
            $_SESSION['success'] = "Xóa đăng ký học phần thành công!";
        } else {
            $_SESSION['error'] = "Đã xảy ra lỗi khi xóa đăng ký học phần.";
        }
        
        header('Location: /php/QUANLYSV/DangKy');
    }
}
