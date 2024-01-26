<?php
include_once('db/connect.php');
include_once('Navbar.php');
if (isset($_GET['IDGoiDichVu']) && isset($_GET['CCCD']) && isset($_GET['GiaCuoc']) && !isset($_GET['GiaHanThem'])) {
    // $Products_id = $_GET['IDGoiDichVu'];
    // $SoCCCD = $_GET['CCCD'];
    // $GiaCuoc = $_GET['GiaCuoc'];
    // $sql_details = mysqli_query($conn, "SELECT * FROM goi_dich_vu WHERE ID = $Products_id");
    // $row_details = mysqli_fetch_array($sql_details);
    // $row_details['TenGoiDichVu'];
    // $_SESSION['chonxacnhan'] = true;

    $Products_id = $_GET['IDGoiDichVu'];
    $SoCCCD = $_GET['CCCD'];
    $_SESSION['idnumber'] = $SoCCCD;
    $GiaCuoc = $_GET['GiaCuoc'];
    $_SESSION['giacuoc'] = $GiaCuoc;
    $sql_details = mysqli_query($conn, "SELECT * FROM goi_dich_vu WHERE ID = $Products_id");
    $row_details = mysqli_fetch_array($sql_details);
    $sql_details1 = mysqli_query($conn, "SELECT * FROM su_dung_dich_vu WHERE IDGoiDichVu = $Products_id AND SoCCCD =  $SoCCCD");
    $row_details1 = mysqli_fetch_array($sql_details1);
    $ngayKetThucValue = $row_details1['NgayKetThuc'];
    $tengoicuoc = $row_details['TenGoiDichVu'];
    $_SESSION['tengoiDV'] = $tengoicuoc;
    $_SESSION['chonxacnhan'] = true;
    // lấy tên///////////////
    $sql_fullname = mysqli_query($conn, "SELECT * FROM khach_hang WHERE CCCD =  $SoCCCD");
    $row_fullname = mysqli_fetch_array($sql_fullname);
    $fullname = $row_fullname['HoTen'];
    $_SESSION['fullname'] = $fullname;
    $SDT = $row_fullname['SDT'];
    $_SESSION['phone'] = $SDT;
    $dob = $row_fullname['NgaySinh'];
    $_SESSION['dob'] = $dob;
    $gender = $row_fullname['GioiTinh'];
    $_SESSION['gender'] = $gender;
    $email = $row_fullname['Email'];
    $_SESSION['email'] = $email;

    if (isset($_POST['Xacnhan'])) {
        $thoigianDK = $_POST['goicuoc'];
        $_SESSION['thoigianDK'] = $thoigianDK;
        $ngayHienTai = date("Y-m-d");
        $ngayMoiTimestamp = strtotime($ngayHienTai . "+$thoigianDK month");
        $ngayMoi = date("Y-m-d", $ngayMoiTimestamp);
        $_SESSION['ngaymoi'] = $ngayMoi;
        $_SESSION['thanhtoan'] = ($thoigianDK * $GiaCuoc * 1000);
        $_SESSION['chonxacnhan'] = false;
        ?>
        <div class="Thanhtoan">
            <h1>Phương thức thanh toán</h1>
            <form id='FormThanhtoan' action="" method="POST" role="form" style="width: 48%; float: left;">
                <input style="width: 100%; margin-top: 3%; height: 50px;" name="Thanhtoan" type="submit"
                    value="Thanh toán tại nhà">
            </form>
            <form class="" method="POST" enctype="application/x-www-form-urlencoded" action="thanhtoan_giahan_atm.php"
                style="width: 48%; float: right;">
                <input style="width: 100%; margin-top: 3%; height: 50px;" type="submit" name="momo" value="Thanh toán momo"
                    class="btn btn-danger">
            </form>
        </div>
        <?php
    }
    if (isset($_POST['Thanhtoan'])) {
        $ngayMoi1 = $_SESSION['ngaymoi'];
        $query2 = "UPDATE su_dung_dich_vu SET NgayKetThuc = '$ngayMoi1', status = 0, Thanhtoan = 0 WHERE IDGoiDichVu = '$Products_id' AND SoCCCD = '$SoCCCD'";
        mysqli_query($conn, $query2);
        if ($conn->query($query2) === TRUE) {
            echo '<script type="text/javascript"> alert(\'Đăng kí gia hạn thành công. Vui lòng chờ quá trình xét duyệt\'); </script>';
            header('Location:Qly_goi_cuoc_User.php');
        } else {
            echo "Lỗi cập nhật: " . $conn->error;
        }
    }
}
///////////////////////////////////////////////////////////
if (isset($_GET['IDGoiDichVu']) && isset($_GET['CCCD']) && isset($_GET['GiaCuoc']) && isset($_GET['GiaHanThem'])) {
    $Products_id = $_GET['IDGoiDichVu'];
    $SoCCCD = $_GET['CCCD'];
    $_SESSION['idnumber'] = $SoCCCD;
    $GiaCuoc = $_GET['GiaCuoc'];
    $_SESSION['giacuoc'] = $GiaCuoc;
    $sql_details = mysqli_query($conn, "SELECT * FROM goi_dich_vu WHERE ID = $Products_id");
    $row_details = mysqli_fetch_array($sql_details);
    $sql_details1 = mysqli_query($conn, "SELECT * FROM su_dung_dich_vu WHERE IDGoiDichVu = $Products_id AND SoCCCD =  $SoCCCD");
    $row_details1 = mysqli_fetch_array($sql_details1);
    $ngayKetThucValue = $row_details1['NgayKetThuc'];
    $tengoicuoc = $row_details['TenGoiDichVu'];
    $_SESSION['tengoiDV'] = $tengoicuoc;
    $_SESSION['chonxacnhan'] = true;
    // lấy tên///////////////
    $sql_fullname = mysqli_query($conn, "SELECT * FROM khach_hang WHERE CCCD =  $SoCCCD");
    $row_fullname = mysqli_fetch_array($sql_fullname);
    $fullname = $row_fullname['HoTen'];
    $_SESSION['fullname'] = $fullname;
    $SDT = $row_fullname['SDT'];
    $_SESSION['phone'] = $SDT;
    $dob = $row_fullname['NgaySinh'];
    $_SESSION['dob'] = $dob;
    $gender = $row_fullname['GioiTinh'];
    $_SESSION['gender'] = $gender;
    $email = $row_fullname['Email'];
    $_SESSION['email'] = $email;

    if (isset($_POST['Xacnhan'])) {

        $thoigianDK = $_POST['goicuoc'];
        $_SESSION['thoigianDK'] = $thoigianDK;
        //$ngayHienTai = date("Y-m-d");
        $_SESSION['thoigianDK'] = $thoigianDK;
        $ngayHienTai = $ngayKetThucValue;
        $ngayMoiTimestamp = strtotime($ngayHienTai . "+$thoigianDK month");
        $ngayMoi = date("Y-m-d", $ngayMoiTimestamp);

        $_SESSION['ngaymoi'] = $ngayMoi;
        $_SESSION['thanhtoan'] = ($thoigianDK * $GiaCuoc * 1000);
        $_SESSION['chonxacnhan'] = false;
        ?>
        <div class="Thanhtoan" style="margin-left: 13%;">
            <h1>Phương thức thanh toán</h1>
            <form id='FormThanhtoan' action="" method="POST" role="form" style="width: 48%; float: left;">
                <input style="width: 100%; margin-top: 3%; height: 50px;" name="Thanhtoan" type="submit"
                    value="Thanh toán tại nhà">
            </form>
            <form class="" method="POST" enctype="application/x-www-form-urlencoded" action="thanhtoan_giahan_atm.php"
                style="width: 48%; float: right;">
                <input style="width: 100%; margin-top: 3%; height: 50px;" type="submit" name="momo" value="Thanh toán momo"
                    class="btn btn-danger">
            </form>
        </div>
        <?php
    }
    if (isset($_POST['Thanhtoan'])) {
        $ngayMoi1 = $_SESSION['ngaymoi'];
        $query2 = "UPDATE su_dung_dich_vu SET NgayKetThuc = '$ngayMoi1', status = 0, Thanhtoan = 0 WHERE IDGoiDichVu = '$Products_id' AND SoCCCD = '$SoCCCD'";
        mysqli_query($conn, $query2);
        if ($conn->query($query2) === TRUE) {
            echo '<script type="text/javascript"> alert(\'Đăng kí gia hạn thành công. Vui lòng chờ quá trình xét duyệt\'); </script>';
            header('Location:Qly_goi_cuoc_User.php');
        } else {
            echo "Lỗi cập nhật: " . $conn->error;
        }
    }
}
/////////////////////////////////////////////////
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gia hạn gói cước</title>
    <link rel="stylesheet" href="CSS/dangkigoicuoc1test.css">
</head>

<body>
    <?php
    if ($_SESSION['chonxacnhan']) {
        ?>
        <form method="POST" action="" style="display: flex;
    flex-direction: column;
    align-items: center;
    flex-wrap: wrap;
    justify-content: space-evenly;">
            <div class="containerGoicuoc" style="margin-left: 0%; margin-top: 2%">
                <h2>Chọn thời gian gia hạn</h2>
                <select id="goicuoc" name="goicuoc" required>
                    <option value="" <?php echo !isset($_POST['goicuoc']) ? 'selected' : ''; ?>>--Chọn thời gian gia hạn--
                    </option>
                    <option value="12" <?php echo isset($_POST['goicuoc']) && $_POST['goicuoc'] === '12' ? 'selected' : ''; ?>>Gia hạn 12 tháng</option>
                    <option value="6" <?php echo isset($_POST['goicuoc']) && $_POST['goicuoc'] === '6' ? 'selected' : ''; ?>>
                        Gia hạn 6 tháng</option>
                    <option value="3" <?php echo isset($_POST['goicuoc']) && $_POST['goicuoc'] === '3' ? 'selected' : ''; ?>>
                        Gia hạn 3 tháng</option>
                </select>
            </div>
            <input style="height: 45px; width: 34%" name="Xacnhan" type="submit" value="Xác nhận">
        </form>
        <?php

    }

    ?>
</body>

</html>