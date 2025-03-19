<?php
require_once('app/utils/ImageProcessor.php');

class SinhVienModel
{
    private $conn;
    private $table_name = "SinhVien";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getSinhViens()
    {
        $query = "SELECT sv.*, ng.TenNganh 
                  FROM " . $this->table_name . " sv
                  LEFT JOIN NganhHoc ng ON sv.MaNganh = ng.MaNganh
                  ORDER BY sv.HoTen";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getSinhVienById($maSV)
    {
        $query = "SELECT sv.*, ng.TenNganh 
                  FROM " . $this->table_name . " sv
                  LEFT JOIN NganhHoc ng ON sv.MaNganh = ng.MaNganh
                  WHERE sv.MaSV = :maSV";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':maSV', $maSV);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function addSinhVien($maSV, $hoTen, $gioiTinh, $ngaySinh, $maNganh, $hinh = null)
    {
        $errors = [];
        if (empty($maSV)) {
            $errors['maSV'] = 'Mã sinh viên không được để trống';
        }
        if (empty($hoTen)) {
            $errors['hoTen'] = 'Họ tên sinh viên không được để trống';
        }
        if (empty($ngaySinh)) {
            $errors['ngaySinh'] = 'Ngày sinh không được để trống';
        }
        if (count($errors) > 0) {
            return $errors;
        }

        // Check if student ID already exists
        $check_query = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE MaSV = :maSV";
        $check_stmt = $this->conn->prepare($check_query);
        $check_stmt->bindParam(':maSV', $maSV);
        $check_stmt->execute();
        if ($check_stmt->fetchColumn() > 0) {
            $errors['maSV'] = 'Mã sinh viên đã tồn tại';
            return $errors;
        }

        // Process image if it's a base64 string
        $image_filename = $hinh;
        if ($hinh && strpos($hinh, 'data:image') === 0) {
            $image_filename = ImageProcessor::saveBase64Image($hinh, 'student');
        }

        $query = "INSERT INTO " . $this->table_name . " 
                 (MaSV, HoTen, GioiTinh, NgaySinh, MaNganh, Hinh) 
                 VALUES (:maSV, :hoTen, :gioiTinh, :ngaySinh, :maNganh, :hinh)";
        
        $stmt = $this->conn->prepare($query);

        $maSV = htmlspecialchars(strip_tags($maSV));
        $hoTen = htmlspecialchars(strip_tags($hoTen));
        $gioiTinh = htmlspecialchars(strip_tags($gioiTinh));

        $stmt->bindParam(':maSV', $maSV);
        $stmt->bindParam(':hoTen', $hoTen);
        $stmt->bindParam(':gioiTinh', $gioiTinh);
        $stmt->bindParam(':ngaySinh', $ngaySinh);
        $stmt->bindParam(':maNganh', $maNganh);
        $stmt->bindParam(':hinh', $image_filename);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function updateSinhVien($maSV, $hoTen, $gioiTinh, $ngaySinh, $maNganh, $hinh = null)
    {
        // Get current student data to check if image changed
        $current_student = $this->getSinhVienById($maSV);
        $image_filename = $current_student->Hinh;
        
        // Process image if it's a base64 string
        if ($hinh && strpos($hinh, 'data:image') === 0) {
            // Delete old image if exists
            if ($image_filename) {
                ImageProcessor::deleteImage($image_filename);
            }
            $image_filename = ImageProcessor::saveBase64Image($hinh, 'student');
        } else if ($hinh && $hinh !== $current_student->Hinh) {
            $image_filename = $hinh;
        }

        $query = "UPDATE " . $this->table_name . " SET 
                  HoTen = :hoTen, 
                  GioiTinh = :gioiTinh, 
                  NgaySinh = :ngaySinh, 
                  MaNganh = :maNganh, 
                  Hinh = :hinh 
                  WHERE MaSV = :maSV";
                  
        $stmt = $this->conn->prepare($query);

        $hoTen = htmlspecialchars(strip_tags($hoTen));
        $gioiTinh = htmlspecialchars(strip_tags($gioiTinh));

        $stmt->bindParam(':maSV', $maSV);
        $stmt->bindParam(':hoTen', $hoTen);
        $stmt->bindParam(':gioiTinh', $gioiTinh);
        $stmt->bindParam(':ngaySinh', $ngaySinh);
        $stmt->bindParam(':maNganh', $maNganh);
        $stmt->bindParam(':hinh', $image_filename);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function deleteSinhVien($maSV)
    {
        // Check if student has registrations
        $check_query = "SELECT COUNT(*) FROM DangKy WHERE MaSV = :maSV";
        $check_stmt = $this->conn->prepare($check_query);
        $check_stmt->bindParam(':maSV', $maSV);
        $check_stmt->execute();
        if ($check_stmt->fetchColumn() > 0) {
            return 'cannot_delete';
        }

        // Get student to delete image if exists
        $student = $this->getSinhVienById($maSV);
        if ($student && $student->Hinh) {
            ImageProcessor::deleteImage($student->Hinh);
        }
        
        $query = "DELETE FROM " . $this->table_name . " WHERE MaSV = :maSV";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':maSV', $maSV);

        if ($stmt->execute()) {
            return 'success';
        }
        return 'error';
    }

    public function getNganhHocs()
    {
        $query = "SELECT * FROM NganhHoc";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
?>
