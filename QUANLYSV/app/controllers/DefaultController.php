<?php
require_once('app/config/database.php');
require_once('app/controllers/SinhVienController.php');

class DefaultController
{
    public function index()
    {
        // Redirect to the SinhVien controller to display the student list
        $sinhVienController = new SinhVienController();
        $sinhVienController->index();
    }
}
