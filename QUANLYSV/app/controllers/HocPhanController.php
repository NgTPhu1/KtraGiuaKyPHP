<?php
require_once('app/config/database.php');
require_once('app/models/HocPhanModel.php');

class HocPhanController
{
    private $hocPhanModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->hocPhanModel = new HocPhanModel($this->db);
    }

    public function index()
    {
        $hocPhans = $this->hocPhanModel->getHocPhans();
        include 'app/views/hocphan/list.php';
    }

    public function detail($maHP)
    {
        $hocPhan = $this->hocPhanModel->getHocPhanById($maHP);
        if ($hocPhan) {
            include 'app/views/hocphan/detail.php';
        } else {
            $_SESSION['error'] = "Không tìm thấy học phần.";
            header('Location: /php/QUANLYSV/HocPhan');
        }
    }

    public function add()
    {
        include 'app/views/hocphan/add.php';
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maHP = $_POST['maHP'] ?? '';
            $tenHP = $_POST['tenHP'] ?? '';
            $soTinChi = $_POST['soTinChi'] ?? '';

            $result = $this->hocPhanModel->addHocPhan($maHP, $tenHP, $soTinChi);

            if (is_array($result)) {
                $errors = $result;
                include 'app/views/hocphan/add.php';
            } else {
                $_SESSION['success'] = "Thêm học phần thành công!";
                header('Location: /php/QUANLYSV/HocPhan');
            }
        }
    }

    public function edit($maHP)
    {
        $hocPhan = $this->hocPhanModel->getHocPhanById($maHP);
        if ($hocPhan) {
            include 'app/views/hocphan/edit.php';
        } else {
            $_SESSION['error'] = "Không tìm thấy học phần.";
            header('Location: /php/QUANLYSV/HocPhan');
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maHP = $_POST['maHP'];
            $tenHP = $_POST['tenHP'];
            $soTinChi = $_POST['soTinChi'];

            if ($this->hocPhanModel->updateHocPhan($maHP, $tenHP, $soTinChi)) {
                $_SESSION['success'] = "Cập nhật học phần thành công!";
                header('Location: /php/QUANLYSV/HocPhan');
            } else {
                $_SESSION['error'] = "Đã xảy ra lỗi khi cập nhật học phần.";
                header('Location: /php/QUANLYSV/HocPhan/edit/' . $maHP);
            }
        }
    }

    public function delete($maHP)
    {
        $result = $this->hocPhanModel->deleteHocPhan($maHP);
        
        if ($result === 'success') {
            $_SESSION['success'] = "Xóa học phần thành công!";
        } else if ($result === 'cannot_delete') {
            $_SESSION['error'] = "Không thể xóa học phần này vì đã có sinh viên đăng ký.";
        } else {
            $_SESSION['error'] = "Đã xảy ra lỗi khi xóa học phần.";
        }
        
        header('Location: /php/QUANLYSV/HocPhan');
    }
}
