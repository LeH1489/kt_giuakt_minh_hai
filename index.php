<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liet ke danh sach sv</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" />

    <!-- jQuery library -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container">
        <h1>Danh sách nhân viên</h1>
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#myModal">
            Thêm mới sinh viên
        </button>

        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>Mã nhân viên</th>
                    <th>Tên nhân viên</th>
                    <th>Giới tính</th>
                    <th>Nơi sinh</th>
                    <th>Tên Phòng</th>
                    <th>Lương</th>
                    <th>Tác vụ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                session_start(); // Bắt đầu hoặc khởi tạo session

                // Kết nối CSDL
                require_once 'ketnoi.php'; // Thay đổi tên tập tin kết nối tùy thuộc vào tên của bạn

                // Kiểm tra và lưu vai trò của người dùng từ session
                $user_role = isset($_SESSION['role']) ? $_SESSION['role'] : '';



                // Số nhân viên mỗi trang
                $so_nv_moi_trang = 5;

                // Trang hiện tại
                $trang_hien_tai = isset($_GET['trang']) ? $_GET['trang'] : 1;

                // Vị trí bắt đầu lấy dữ liệu
                $vi_tri_bat_dau = ($trang_hien_tai - 1) * $so_nv_moi_trang;

                // Câu lệnh SQL lấy dữ liệu với phân trang
                $lietke_sql = "SELECT n.*, p.Ten_Phong FROM nhanvien n JOIN phongban p ON n.Ma_Phong = p.Ma_Phong LIMIT $vi_tri_bat_dau, $so_nv_moi_trang";

                // Thực thi câu lệnh
                $result = mysqli_query($conn, $lietke_sql);

                // Duyệt qua result và in ra
                while ($r = mysqli_fetch_assoc($result)) {
                    // Đường dẫn hình ảnh tùy thuộc vào giới tính
                    $image_path = $r['PHAI'] === 'NU' ? 'images/female.png' : 'images/male.png';
                ?>
                    <tr>
                        <td><?php echo $r['MA_NV']; ?></td>
                        <td><?php echo $r['TEN_NV']; ?></td>
                        <td><img src="<?php echo $image_path; ?>" alt="<?php echo $r['PHAI']; ?>" class="img-fluid" style="max-width: 30px;"></td>
                        <td><?php echo $r['Noi_Sinh']; ?></td>
                        <td><?php echo $r['Ten_Phong']; ?></td>
                        <td><?php echo $r['Luong']; ?></td>
                        <td>
                            <?php if ($user_role === 'ADMIN') : ?>
                                <!-- Nếu vai trò là admin, hiển thị nút xóa, sửa -->
                                <form action="delete.php" method="post">
                                    <input type="hidden" name="nv_id" value="<?php echo $r['MA_NV']; ?>">
                                    <button type="submit" class="btn btn-danger">Xóa</button>
                                </form>
                                <a href="sua.php?nv_id=<?php echo $r['MA_NV']; ?>" class="btn btn-primary">Sửa</a>
                            <?php endif; ?>

                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

        <!-- Phân trang -->
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?php
                // Số lượng nhân viên trong CSDL
                $sql_count = "SELECT COUNT(*) AS total FROM nhanvien";
                $result_count = mysqli_query($conn, $sql_count);

                $row_count = mysqli_fetch_assoc($result_count);
                $total_records = $row_count['total'];

                // Tính tổng số trang
                $total_pages = ceil($total_records / $so_nv_moi_trang);

                // Hiển thị các nút trang
                for ($i = 1; $i <= $total_pages; $i++) {
                    echo '<li class="page-item ' . ($trang_hien_tai == $i ? 'active' : '') . '"><a class="page-link" href="?trang=' . $i . '">' . $i . '</a></li>';
                }
                ?>
            </ul>
        </nav>

        <!-- modal -->
        <div class="modal" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Thêm sinh viên</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="add.php" method="post">
                            <div class="form-group">
                                <label for="manv">Mã nv:</label>
                                <input type="text" class="form-control" id="manv" name="manv" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="tennv">Tên NV:</label>
                                <input type="text" class="form-control" id="tennv" name="tennv" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="gioitinh">Gioi tính:</label>
                                <input type="text" class="form-control" id="gioitinh" name="gioitinh" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="noisinh">Nơi sinh:</label>
                                <input type="text" class="form-control" id="noisinh" name="noisinh" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="maphong">Mã phòng:</label>
                                <input type="text" class="form-control" id="maphong" name="maphong" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="luong">Lương:</label>
                                <input type="number" class="form-control" id="luong" name="luong" required class="form-control">
                            </div>
                            <button class="btn btn-success">Thêm sinh viên</button>
                        </form>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>

    </div>
</body>

</html>