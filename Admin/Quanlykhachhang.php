<?php
include_once('../db/connect.php');
include_once('Navbar_admin.php');
ob_start();

$showAll = !isset($_GET['find_btn']) || empty($_GET['q']);

// Xử lý tìm kiếm nếu có từ khóa
if (isset($_GET['find_btn'])) {
    $keyword = $_GET['q'];
    $sql_search_khachhang = "SELECT HoTen, CCCD, SDT, GioiTinh, NgaySinh, Email FROM khach_hang WHERE Da_xoa = 0 AND (HoTen LIKE '%$keyword%' OR CCCD LIKE '%$keyword%' OR SDT LIKE '%$keyword%' OR GioiTinh LIKE '%$keyword%' OR NgaySinh LIKE '%$keyword%' OR Email LIKE '%$keyword%')";
    $result_search_khachhang = mysqli_query($conn, $sql_search_khachhang);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý khách hàng</title>
    <link rel="stylesheet" href="../CSS/Qly_KH.css">
    <link rel="stylesheet" href="../CSS/Navbar_admin.css" />
</head>

<body>
    <nav class="Nav-search">
        <form class="search" action="#" method="get" style="float: right">
            <input type="search" name="q" placeholder="Nhập từ khóa..."
                value="<?php echo isset($keyword) ? $keyword : ''; ?>">
            <button style="margin-right: 5px; margin-left: 10px; width: 50px; height: 32px;" name="find_btn"
                type="submit">Tìm</button>
        </form>
    </nav>

    <div style="width: 85%; margin: auto;">
        <div style="width: 100%">
            <div class="col-md-8">
                <?php
                if (isset($_GET['sua']) == true) {
                    $id = $_GET['Sua'];
                    $sql_capnhat = mysqli_query($conn, "SELECT HoTen, CCCD, SDT, GioiTinh, NgaySinh, Email FROM khach_hang WHERE Da_xoa = 0 AND CCCD='$id'");
                    $row_capnhat = mysqli_fetch_array($sql_capnhat);
                    $id_KH = $row_capnhat['CCCD'];
                    $_SESSION['CCCD'] = $id_KH;
                    ?>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="container" style="margin-top: 50px">
                            <label>Họ tên khách hàng</label>
                            <input type="text" class="form-control" name="HotenKH"
                                value="<?php echo $row_capnhat['HoTen'] ?>"><br>
                            <input type="hidden" class="form-control" name="id_update"
                                value="<?php echo $row_capnhat['CCCD'] ?>">
                            <label>Số CCCD</label>
                            <input type="text" class="form-control" name="CCCD"
                                value="<?php echo $row_capnhat['CCCD'] ?>"><br>

                            <label>SĐT</label>
                            <input type="text" class="form-control" name="SDT"
                                value="<?php echo $row_capnhat['SDT'] ?>"><br>
                        </div>
                        <div class="container">
                            <label for="gender">Giới tính</label>
                            <select id="gender" name="gender" required>
                                <option value="Nam">Nam</option>
                                <option value="Nữ">Nữ
                                </option>
                            </select>

                            <label for="dob">Ngày sinh</label>
                            <input type="date" id="dob" name="dob" value="<?php echo $row_capnhat['NgaySinh']; ?>" required>

                            <label for="email">Địa chỉ email:</label>
                            <input type="email" id="email" name="email" value="<?php echo $row_capnhat['Email']; ?>"
                                required>
                        </div>
                        <input style="background-color: #1baf3d; width: 50%; margin-left: 25%; margin-top: 20px"
                            type="submit" name="Capnhat" value="Cập nhật" class="btn btn-default">
                    </form>

                    <?php
                } else if ($showAll) {
                    // Hiển thị tất cả thông tin khách hàng
                    echo '<h2>Danh sách khách hàng</h2>';
                    $sql_select_khachhang = mysqli_query($conn, "SELECT HoTen, CCCD, SDT, GioiTinh, NgaySinh, Email FROM khach_hang WHERE Da_xoa = 0");
                    ?>
                        <table style="width: 100%" class="table table-bordered">
                            <tr>
                                <th></th>
                                <th>Họ tên khách hàng</th>
                                <th>Số CCCD</th>
                                <th>Số điện thoại</th>
                                <th>Giới tính</th>
                                <th>Ngày sinh</th>
                                <th>Email</th>
                                <th> </th>
                            </tr>
                            <?php
                            $i = 0;
                            while ($row_khachhang = mysqli_fetch_array($sql_select_khachhang)) {
                                $i++;
                                ?>
                                <tr>
                                    <td>
                                    <?php echo $i ?>
                                    </td>
                                    <td>
                                    <?php echo $row_khachhang['HoTen'] ?>
                                    </td>
                                    <td>
                                    <?php echo $row_khachhang['CCCD']; ?>
                                    </td>
                                    <td>
                                    <?php echo $row_khachhang['SDT'] ?>
                                    </td>
                                    <td>
                                    <?php echo $row_khachhang['GioiTinh'] ?>
                                    </td>
                                    <td>
                                    <?php echo $row_khachhang['NgaySinh'] ?>
                                    </td>
                                    <td>
                                    <?php echo $row_khachhang['Email'] ?>
                                    </td>
                                    <td>
                                        <a href="Quanlykhachhang.php?sua=true&Sua=<?php echo $row_khachhang['CCCD']; ?>">Sửa</a> |
                                        <a href="?Xoa=<?php echo $row_khachhang['CCCD'] ?>" onclick="return confirmDelete()">
                                            Xóa</a>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </table>
                    <?php
                } else {
                    echo '<h2>Kết quả tìm kiếm cho "' . $keyword . '"</h2>';
                    if (isset($result_search_khachhang)) {
                        echo '<table style="width: 100%" class="table table-bordered">';
                        echo '<tr>
                    <th></th>
                    <th>Họ tên khách hàng</th>
                    <th>Số CCCD</th>
                    <th>Số điện thoại</th>
                    <th>Giới tính</th>
                    <th>Ngày sinh</th>
                    <th>Email</th>
                    <th></th>
                  </tr>';

                        $i = 0;
                        while ($row_search_khachhang = mysqli_fetch_array($result_search_khachhang)) {
                            $i++;
                            echo '<tr>
                        <td>' . $i . '</td>
                        <td>' . $row_search_khachhang['HoTen'] . '</td>
                        <td>' . $row_search_khachhang['CCCD'] . '</td>
                        <td>' . $row_search_khachhang['SDT'] . '</td>
                        <td>' . $row_search_khachhang['GioiTinh'] . '</td>
                        <td>' . $row_search_khachhang['NgaySinh'] . '</td>
                        <td>' . $row_search_khachhang['Email'] . '</td>
                        <td><a href="Quanlykhachhang.php?Sua=' . $row_search_khachhang['CCCD'] . '">Sửa thông tin</a> | <a href="?Xoa=' . $row_search_khachhang['CCCD'] . '" onclick="return confirmDelete()">Xóa khách hàng</a></td>
                      </tr>';
                        }
                        echo '</table>';
                    } else {
                        echo "<p>Không có kết quả nào được tìm thấy.</p>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <?php
    // vào bảng khách hàng tìm kh có mã xyz nếu có thì vào bảng su_dung_dich_vu tìm khách hàng có mã đó
// và status = 2 (đã quá hạn) và Da_xoa = 0 nếu có thì xóa
    if (isset($_GET['Xoa'])) {
        $id = $_GET['Xoa'];
        $XoaTK = md5($_GET['Xoa']);
        $querySelect = "SELECT * FROM su_dung_dich_vu WHERE SoCCCD = '$id' AND Da_xoa = 0 AND status = 2";
        $resultSelect = mysqli_query($conn, $querySelect);

        $querySelect1 = "SELECT * FROM su_dung_dich_vu WHERE SoCCCD = '$id' AND Da_xoa = 0 AND status != 2";
        $resultSelect1 = mysqli_query($conn, $querySelect1);

        if ($resultSelect) {
            // Kiểm tra xem có dòng thỏa mãn điều kiện không
            if (mysqli_num_rows($resultSelect) != 0) {
                echo '<script>
            function confirmDelete() {
                return confirm("Có chắc chắn xóa không");
            }
          </script>';
                // Tiến hành xóa các thông tin liên quan
                $sql_XoaKH = mysqli_query($conn, "UPDATE khach_hang SET Da_xoa = 1 WHERE CCCD='$id'");
                $sql_XoaTaiKhoan = mysqli_query($conn, "UPDATE tai_khoan SET Da_xoa = 1 WHERE Mat_khau='$XoaTK'");
                // $sql_SDDV = mysqli_query($conn, "UPDATE su_dung_dich_vu SET Da_xoa = 1 WHERE SoCCCD='$id'");
    
                // Kiểm tra xem các câu lệnh UPDATE có thành công không
                if ($sql_XoaKH && $sql_XoaTaiKhoan && $sql_SDDV) {
                    echo '<script type="text/javascript"> alert(\'Xóa thông tin khách hàng thành công\'); </script>';
                } else {
                    echo '<script type="text/javascript"> alert(\'Lỗi khi xóa thông tin liên quan: ' . mysqli_error($conn) . '\'); </script>';
                }
                header('Location: Quanlykhachhang.php');
            } else {
                // Có dòng thỏa mãn điều kiện, không thực hiện xóa
                echo '<script type="text/javascript"> alert(\'Không thể xóa khách hàng đang sử dụng dịch vụ\'); </script>';
            }
        }

    } else
        if (isset($_POST['Capnhat'])) {
            $id_update = $_POST['id_update'];
            $HotenKH = $_POST['HotenKH'];
            $CCCD = $_POST['CCCD'];
            $MK = md5($CCCD);
            $MK_check = md5($_SESSION['CCCD']);
            $SDT = $_POST['SDT'];
            $gender = $_POST['gender'];
            $dob = $_POST['dob'];
            $email = $_POST['email'];

            $sql_CapnhatKH = "UPDATE khach_hang SET HoTen='$HotenKH', CCCD='$CCCD', SDT='$SDT', GioiTinh='$gender', NgaySinh='$dob', Email='$email' WHERE CCCD='$id_update'";
            $sql_CapnhatTaiKhoan = "UPDATE tai_khoan SET Tai_khoan='$email', Mat_khau = '$MK' WHERE Mat_khau='$MK_check'";
            mysqli_query($conn, $sql_CapnhatKH);
            mysqli_query($conn, $sql_CapnhatTaiKhoan);
            header('Location:Quanlykhachhang.php');
            exit();
        }

    ?>
</body>
<script>
    function confirmDelete() {
        return confirm("Bạn có chắc chắn muốn xóa khách hàng này?");
    }
</script>

</html>