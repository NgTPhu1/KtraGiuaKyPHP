<?php
class DangKyModel
{
    private $conn;
    private $table_name = "DangKy";
    private $detail_table = "ChiTietDangKy";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getDangKys()
    {
        $query = "SELECT dk.*, sv.HoTen 
                  FROM " . $this->table_name . " dk
                  LEFT JOIN SinhVien sv ON dk.MaSV = sv.MaSV";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getDangKyById($maDK)
    {
        $query = "SELECT dk.*, sv.HoTen 
                  FROM " . $this->table_name . " dk
                  LEFT JOIN SinhVien sv ON dk.MaSV = sv.MaSV
                  WHERE dk.MaDK = :maDK";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':maDK', $maDK);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getChiTietDangKy($maDK)
    {
        $query = "SELECT ct.*, hp.TenHP, hp.SoTinChi 
                  FROM " . $this->detail_table . " ct
                  LEFT JOIN HocPhan hp ON ct.MaHP = hp.MaHP
                  WHERE ct.MaDK = :maDK";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':maDK', $maDK);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function addDangKy($maSV, $ngayDK, $maHPs)
    {
        $errors = [];
        if (empty($maSV)) {
            $errors['maSV'] = 'Mã sinh viên không được để trống';
        }
        if (empty($maHPs)) {
            $errors['maHP'] = 'Phải chọn ít nhất một học phần';
        }
        if (count($errors) > 0) {
            return $errors;
        }

        try {
            $this->conn->beginTransaction();
            
            // Thêm đăng ký
            $query = "INSERT INTO " . $this->table_name . " (MaSV, NgayDK) VALUES (:maSV, :ngayDK)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':maSV', $maSV);
            $stmt->bindParam(':ngayDK', $ngayDK);
            $stmt->execute();
            
            $maDK = $this->conn->lastInsertId();
            
            // Thêm chi tiết đăng ký
            foreach ($maHPs as $maHP) {
                $query = "INSERT INTO " . $this->detail_table . " (MaDK, MaHP) VALUES (:maDK, :maHP)";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':maDK', $maDK);
                $stmt->bindParam(':maHP', $maHP);
                $stmt->execute();
            }
            
            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            // Ghi lại thông tin lỗi và trả về
            error_log("Database Error in addDangKy: " . $e->getMessage());
            return ['database_error' => $e->getMessage()];
        }
    }

    public function deleteDangKy($maDK)
    {
        try {
            $this->conn->beginTransaction();
            
            // Xóa chi tiết đăng ký
            $query = "DELETE FROM " . $this->detail_table . " WHERE MaDK = :maDK";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':maDK', $maDK);
            $stmt->execute();
            
            // Xóa đăng ký
            $query = "DELETE FROM " . $this->table_name . " WHERE MaDK = :maDK";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':maDK', $maDK);
            $stmt->execute();
            
            $this->conn->commit();
            return 'success';
        } catch (PDOException $e) {
            $this->conn->rollBack();
            return 'error';
        }
    }

    public function getDangKyCountBySinhVien($maSV)
    {
        $query = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE MaSV = :maSV";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':maSV', $maSV);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getCountByHocPhan($maHP)
    {
        $query = "SELECT COUNT(*) FROM " . $this->detail_table . " WHERE MaHP = :maHP";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':maHP', $maHP);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}
?>
