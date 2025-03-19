<?php
// Khởi động session
session_start();

// Định nghĩa hằng số cho đường dẫn gốc
define('BASE_PATH', __DIR__); // Đường dẫn đến thư mục hiện tại (QUANLYSV/)

// Yêu cầu các file cần thiết từ app/
require_once BASE_PATH . '/app/config/database.php';
require_once BASE_PATH . '/app/controllers/DefaultController.php'; 
require_once BASE_PATH . '/app/controllers/SinhVienController.php';
require_once BASE_PATH . '/app/controllers/HocPhanController.php';
require_once BASE_PATH . '/app/controllers/DangKyController.php';
require_once BASE_PATH . '/app/controllers/SinhVienDangKyController.php';

// Lấy URL và phân tích
$request = $_SERVER['REQUEST_URI'];
$baseUrl = '/php/QUANLYSV'; // URL cơ sở

// Xử lý URL để trích xuất đúng controller và action
if (strpos($request, $baseUrl) === 0) {
    // Cắt bỏ phần baseUrl từ request
    $uri = substr($request, strlen($baseUrl));
    $uri = trim($uri, '/');
    $segments = explode('/', $uri);

    // Xác định controller và action
    $controllerName = !empty($segments[0]) ? ucfirst($segments[0]) . 'Controller' : 'DefaultController';
    $action = !empty($segments[1]) ? $segments[1] : 'index';
    $param = !empty($segments[2]) ? $segments[2] : null;
} else {
    // Nếu không tìm thấy baseUrl, sử dụng controller mặc định
    $controllerName = 'DefaultController';
    $action = 'index';
    $param = null;
}

// Khởi tạo controller và gọi action
if (class_exists($controllerName)) {
    $controller = new $controllerName();
    if (method_exists($controller, $action)) {
        if ($param) {
            $controller->$action($param);
        } else {
            $controller->$action();
        }
    } else {
        echo "Action không tồn tại: " . $action;
    }
} else {
    echo "Controller không tồn tại: " . $controllerName;
}
