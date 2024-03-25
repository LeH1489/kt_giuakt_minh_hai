<?php
// Kết nối CSDL
require_once 'ketnoi.php';

// Kiểm tra xem có dữ liệu được gửi từ form không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $manv = $_POST['manv'];
    $tennv = $_POST['tennv'];
    $gioitinh = $_POST['gioitinh'];
    $noisinh = $_POST['noisinh'];
    $maphong = $_POST['maphong'];
    $luong = $_POST['luong'];

    // Câu lệnh SQL thêm nhân viên vào cơ sở dữ liệu
    $sql = "INSERT INTO nhanvien (MA_NV, TEN_NV, PHAI, Noi_Sinh, Ma_Phong, Luong) VALUES ('$manv', '$tennv', '$gioitinh', '$noisinh', '$maphong', '$luong')";

    // Thực thi câu lệnh SQL và kiểm tra kết quả
    if (mysqli_query($conn, $sql)) {
        // Nếu thêm thành công, chuyển hướng người dùng đến trang index.php
        header("location: index.php");
        exit(); // Kết thúc script sau khi chuyển hướng
    } else {
        // Nếu có lỗi, hiển thị thông báo lỗi
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Đóng kết nối CSDL
mysqli_close($conn);
