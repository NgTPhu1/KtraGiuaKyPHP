<?php
class HocPhanModel
{
    private $conn;
    private $table_name = "HocPhan";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getHocPhans()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getHocPhanById($maHP)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE MaHP = :maHP";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':maHP', $maHP);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function addHocPhan($maHP, $tenHP, $soTinChi)
    {
        $errors = [];
        if (empty($maHP)) {
            $errors['maHP'] = 'Mã học phần không được để trống';
        }
        if (empty($tenHP)) {
            $errors['tenHP'] = 'Tên học phần không được để trống';
        }
        if (!is_numeric($soTinChi) || $soTinChi <= 0) {
            $errors['soTinChi'] = 'Số tín chỉ phải là số dương';
        }
        if (count($errors) > 0) {
            return $errors;
        }

        // Check if course ID already exists
        $check_query = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE MaHP = :maHP";
        $check_stmt = $this->conn->prepare($check_query);
        $check_stmt->bindParam(':maHP', $maHP);
        $check_stmt->execute();
        if ($check_stmt->fetchColumn() > 0) {
            $errors['maHP'] = 'Mã học phần đã tồn tại';
            return $errors;
        }

        $query = "INSERT INTO " . $this->table_name . " 
                  (MaHP, TenHP, SoTinChi) 
                  VALUES (:maHP, :tenHP, :soTinChi)";
        $stmt = $this->conn->prepare($query);

        $maHP = htmlspecialchars(strip_tags($maHP));
        $tenHP = htmlspecialchars(strip_tags($tenHP));
        $soTinChi = htmlspecialchars(strip_tags($soTinChi));

        $stmt->bindParam(':maHP', $maHP);
        $stmt->bindParam(':tenHP', $tenHP);
        $stmt->bindParam(':soTinChi', $soTinChi);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function updateHocPhan($maHP, $tenHP, $soTinChi)
    {
        $query = "UPDATE " . $this->table_name . " SET 
                  TenHP = :tenHP, 
                  SoTinChi = :soTinChi 
                  WHERE MaHP = :maHP";
        $stmt = $this->conn->prepare($query);

        $tenHP = htmlspecialchars(strip_tags($tenHP));
        $soTinChi = htmlspecialchars(strip_tags($soTinChi));

        $stmt->bindParam(':maHP', $maHP);
        $stmt->bindParam(':tenHP', $tenHP);
        $stmt->bindParam(':soTinChi', $soTinChi);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function deleteHocPhan($maHP)
    {
        // First check if course has registrations
        $check_query = "SELECT COUNT(*) FROM ChiTietDangKy WHERE MaHP = :maHP";
        $check_stmt = $this->conn->prepare($check_query);
        $check_stmt->bindParam(':maHP', $maHP);
        $check_stmt->execute();
        if ($check_stmt->fetchColumn() > 0) {
            return 'cannot_delete';
        }
        
        $query = "DELETE FROM " . $this->table_name . " WHERE MaHP = :maHP";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':maHP', $maHP);

        if ($stmt->execute()) {
            return 'success';
        }
        return 'error';
    }
}
?>
