<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "QuanLyNhanSu";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Đặt charset để hỗ trợ tiếng Việt
$conn->set_charset("utf8");
?>