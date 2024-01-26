<?php
include_once('db/connect.php');
include_once('Navbar.php');

if (isset($_GET['XoaIDGoiDichVu']) && isset($_GET['XoaCCCD'])) {
    $Products_id = $_GET['XoaIDGoiDichVu'];
    $SoCCCD = $_GET['XoaCCCD'];
    $sql_details = mysqli_query($conn, "UPDATE su_dung_dich_vu SET Da_xoa = 1 WHERE SoCCCD= $SoCCCD  AND IDGoiDichVu=$Products_id");
    echo '<script type="text/javascript"> alert(\'Hủy thành công\'); </script>';
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý gói cước</title>
    <link rel="stylesheet" href="CSS/Products.css">
    <link rel="stylesheet" href="CSS/Slider1.css">

    <script>
        function confirmDelete() {
            return confirm("Bạn có chắc chắn muốn hủy gói cước này?");
        }
    </script>
</head>

<body>
    <div class="containerParent clearfix">
        <div class="containerParent">
            <?php
            if (isset($_SESSION['username'])) {
                $loggedInUsername = $_SESSION['username'];
                if ($conn->connect_error) {
                    die("Kết nối thất bại: " . $conn->connect_error);
                }

                // Truy vấn SQL để lấy CCCD của khách hàng có Email tương đương với $loggedInUsername
                $sql1 = "SELECT CCCD FROM khach_hang WHERE Email = '$loggedInUsername' AND Da_xoa = 0";
                $result1 = $conn->query($sql1);

                // Kiểm tra và hiển thị kết quả
                if ($result1->num_rows > 0) {
                    // Lấy dòng dữ liệu đầu tiên
                    $row1 = $result1->fetch_assoc();
                    $CCCD_value = $row1['CCCD'];

                    // Truy vấn SQL để lấy giá trị IDGoiDichVu từ bảng su_dung_dich_vu
                    $sql2 = "SELECT IDGoiDichVu, NgayBatDau, NgayKetThuc, status FROM su_dung_dich_vu WHERE SoCCCD = '$CCCD_value' AND Da_xoa = 0";
                    $result2 = $conn->query($sql2);


                    // Kiểm tra và hiển thị kết quả
                    if ($result2->num_rows > 0) {
                        // Duyệt qua tất cả các dòng dữ liệu
                        while ($row2 = $result2->fetch_assoc()) {
                            $IDGoiDichVu_value = $row2['IDGoiDichVu'];
                            $NgayBatDau = $row2['NgayBatDau'];
                            $NgayKetThuc = $row2['NgayKetThuc'];
                            $Tinhtrang = $row2['status'];

                            $sql3 = "SELECT TenGoiDichVu, HinhAnh, TocDo, MoTa, GiaCuoc FROM goi_dich_vu WHERE ID = '$IDGoiDichVu_value' AND Da_xoa = 0";
                            $result3 = $conn->query($sql3);

                            // Kiểm tra và hiển thị kết quả
                            if ($result3->num_rows > 0) {

                                while ($row3 = $result3->fetch_assoc()) {
                                    ?>
                                    <div class="container">
                                        <form method="POST" role="form">
                                            <h1>
                                                <?php echo $row3['TenGoiDichVu'] ?>
                                            </h1>
                                            <div class="img_download">
                                                <img src="./img/<?php echo $row3['HinhAnh'] ?>">

                                            </div>
                                            <div class="speed">
                                                <p>
                                                    <?php echo $row3['TocDo'] ?>
                                                </p>
                                            </div>
                                            <div class="mota" style="font-weight: 600;">
                                                <br>
                                                <p style="font-size: 22px; line-height: 30px;">Ngày bắt đầu:
                                                    <?php echo $NgayBatDau; ?>
                                                </p>
                                                <p style="font-size: 22px; line-height: 30px;">Ngày kết thúc:
                                                    <?php echo $NgayKetThuc; ?>
                                                </p>
                                                <?php
                                                if ($Tinhtrang == 1) {
                                                    ?>
                                                    <p style="color: green; font-size: 22px;">Tình trang:
                                                        <?php echo "Tốt"; ?>
                                                    </p>
                                                    <a href="GiaHan.php?IDGoiDichVu=<?php echo $IDGoiDichVu_value; ?>&CCCD=<?php echo $CCCD_value; ?>&GiaCuoc=<?php echo $row3['GiaCuoc']; ?> &GiaHanThem=true; ?>"
                                                        style="width: 36%; margin-top: 17%; margin-left: 21%;">
                                                        Gia hạn thêm
                                                    </a>
                                                    <?php
                                                } else if ($Tinhtrang == 2) {
                                                    ?>
                                                        <p style="font-size: 22px; color: red;">Tình trạng:
                                                        <?php echo "Đã quá hạn"; ?>
                                                        </p>
                                                        <a href="GiaHan.php?IDGoiDichVu=<?php echo $IDGoiDichVu_value; ?>&CCCD=<?php echo $CCCD_value; ?>&GiaCuoc=<?php echo $row3['GiaCuoc']; ?>"
                                                            style="width: 36%; margin-top: 17%; margin-left: 21%;">
                                                            Gia hạn ngay
                                                        </a>
                                                    <?php
                                                } else if ($Tinhtrang == 0) {
                                                    ?>
                                                            <p style="color:Blue; font-size: 22px;">Tình trang:
                                                        <?php echo "Chưa phê duyệt"; ?>
                                                            <p style="margin-top: 73px;
                                margin-left: -138px;
                                color: #656565;
                                font-size: 14px;
                                width: 126%;">
                                                                Nếu quá trình chờ duyệt mất quá nhiều thời gian.
                                                                Xin vui lòng liên hệ<br> Hotline: 0123456789 để
                                                                được hỗ trợ</p>
                                                            </p>
                                                            <a href="Qly_goi_cuoc_User.php?XoaIDGoiDichVu=<?php echo $IDGoiDichVu_value; ?>&XoaCCCD=<?php echo $CCCD_value; ?>"
                                                                style="width: 36%; margin-top: -35%; margin-left: 21%;" onclick="return confirmDelete()">
                                                                Hủy đăng ký
                                                            </a>

                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </form>

                                    </div>
                                    <?php
                                }

                            } else {
                                echo "<p>Không tìm thấy thông tin gói dịch vụ với IDGoiDichVu $IDGoiDichVu_value</p>";
                            }
                        }
                    } else {
                        echo "<h2>Quý khách chưa đăng kí dịch vụ. Hãy đăng kí gói cước để trãi nghiệm internet tốc độ cao</h2> <br>";
                        ?>
                    </div>
                </div>
                <?php

                include_once('Hot.php');
                    }
                } else {
                    echo "<p>Không tìm thấy khách hàng với Email $loggedInUsername</p>";
                }

            }
            ?>

</body>
<footer style="width : 100%">
    <?php include_once('Footer.php');
    ?>
</footer>

</html>