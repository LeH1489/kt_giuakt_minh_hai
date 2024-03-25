<?php
session_start();


require_once 'ketnoi.php';

// Kiểm tra xem có dữ liệu được gửi từ form không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Truy vấn kiểm tra thông tin đăng nhập
    $sql = "SELECT * FROM user WHERE user_name = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    // Đếm số dòng trả về từ truy vấn
    $count = mysqli_num_rows($result);

    if ($count == 1) {
        // Lấy thông tin của người dùng
        $user = mysqli_fetch_assoc($result);

        // Lưu vai trò của người dùng vào session
        $_SESSION['role'] = $user['role'];


        header("location: index.php");
        exit();
    } else {

        echo "<div class='container mt-3'><div class='alert alert-danger'>Invalid username or password.</div></div>";
    }
}
