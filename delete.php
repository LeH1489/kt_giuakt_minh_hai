<?php
// Kết nối CSDL
require_once 'ketnoi.php';

// Kiểm tra xem có dữ liệu được gửi từ form không
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nv_id'])) {
    // Lấy user_id từ form
    $nv_id = $_POST['nv_id'];

    // Câu lệnh SQL xóa nhân viên
    $sql = "DELETE FROM nhanvien WHERE MA_NV = '$nv_id'";

    // Thực thi câu lệnh SQL và kiểm tra kết quả
    if (mysqli_query($conn, $sql)) {
        // Nếu xóa thành công, chuyển hướng người dùng đến trang index.php hoặc trang khác
        header("location: index.php");
        exit(); // Kết thúc script sau khi chuyển hướng
    } else {
        // Nếu có lỗi, hiển thị thông báo lỗi
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Đóng kết nối CSDL
mysqli_close($conn);
