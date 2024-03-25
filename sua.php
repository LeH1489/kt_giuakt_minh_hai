<?php
// Kết nối CSDL
require_once 'ketnoi.php';

// Kiểm tra xem có dữ liệu được gửi từ form không
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nv_id'])) {
    // Lấy thông tin từ form và mã nhân viên
    $nv_id = $_POST['nv_id'];
    $tennv = $_POST['tennv'];
    $gioitinh = $_POST['gioitinh'];
    $noisinh = $_POST['noisinh'];
    $maphong = $_POST['maphong'];
    $luong = $_POST['luong'];

    // Câu lệnh SQL cập nhật thông tin nhân viên
    $sql = "UPDATE nhanvien SET TEN_NV = '$tennv', PHAI = '$gioitinh', Noi_Sinh = '$noisinh', Ma_Phong = '$maphong', Luong = '$luong' WHERE MA_NV = '$nv_id'";

    // Thực thi câu lệnh SQL và kiểm tra kết quả
    if (mysqli_query($conn, $sql)) {
        // Nếu cập nhật thành công, chuyển hướng người dùng đến trang index.php hoặc trang khác
        header("location: index.php");
        exit(); // Kết thúc script sau khi chuyển hướng
    } else {
        // Nếu có lỗi, hiển thị thông báo lỗi
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Lấy thông tin của nhân viên từ CSDL để hiển thị trong form
if (isset($_GET['nv_id'])) {
    $nv_id = $_GET['nv_id'];
    // Câu lệnh SQL lấy thông tin nhân viên dựa vào mã nhân viên
    $query = "SELECT * FROM nhanvien WHERE MA_NV = '$nv_id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
} else {
    // Nếu không có mã nhân viên được chọn, chuyển hướng người dùng đến trang index.php hoặc trang khác
    header("location: index.php");
    exit();
}

// Đóng kết nối CSDL
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa thông tin nhân viên</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" />
</head>

<body>
    <div class="container">
        <h1>Sửa thông tin nhân viên</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="hidden" name="nv_id" value="<?php echo $_GET['nv_id']; ?>">
            <div class="form-group">
                <label for="tennv">Tên nhân viên:</label>
                <input type="text" class="form-control" id="tennv" name="tennv" value="<?php echo $row['TEN_NV']; ?>" required>
            </div>
            <div class="form-group">
                <label for="gioitinh">Giới tính:</label>
                <input type="text" class="form-control" id="gioitinh" name="gioitinh" value="<?php echo $row['PHAI']; ?>" required>
            </div>
            <div class="form-group">
                <label for="noisinh">Nơi sinh:</label>
                <input type="text" class="form-control" id="noisinh" name="noisinh" value="<?php echo $row['Noi_Sinh']; ?>" required>
            </div>
            <div class="form-group">
                <label for="maphong">Mã phòng:</label>
                <input type="text" class="form-control" id="maphong" name="maphong" value="<?php echo $row['Ma_Phong']; ?>" required>
            </div>
            <div class="form-group">
                <label for="luong">Lương:</label>
                <input type="number" class="form-control" id="luong" name="luong" value="<?php echo $row['Luong']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Lưu</button>
        </form>
    </div>
</body>

</html>