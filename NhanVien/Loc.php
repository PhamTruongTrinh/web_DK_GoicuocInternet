<?php
include_once('../db/connect.php');
include_once('Navbar.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thu tiền</title>
    <link rel="stylesheet" href="Home.css">
</head>

<body>
    <div class="head" style="display: flex;
    justify-content: space-evenly;
    flex-direction: row;">
        <form action="" method="POST">
            <input type="submit" name="ShowAll" value="Xem danh sách">
        </form>
    </div>
    <?php
    if (isset($_POST['ShowAll'])) {
        unset($_SESSION['selectedProvince']);
        unset($_SESSION['selectedDistrict']);
        unset($_SESSION['selectedWard']);
        header('Location: Home.php');
    }
    if (isset($_POST['Tim']) || isset($_SESSION['selectedProvince'])) {
        $_SESSION['selectedProvince'] = $_POST['provinceInput'];
        $_SESSION['selectedDistrict'] = $_POST['districtInput'];
        $_SESSION['selectedWard'] = $_POST['wardInput'];
        ?>
        <div class="table-wrapper" style="margin: auto;
    width: 90%;">
            <table style="width: 100%; margin-top: 3%" class="table table-bordered">
                <tr>
                    <th>SDT</th>
                    <th>CCCD</th>
                    <th>Họ và tên</th>
                    <th>Địa chỉ lắp đặt</th>
                    <th>Tổng tiền thanh toán</th>
                    <th>Trạng thái thanh toán</th>
                    <th>Xác nhận thanh toán</th>
                </tr>
                <?php
                // $selectedProvince = $_POST['provinceInput'];
                // $selectedDistrict = $_POST['districtInput'];
                // $selectedWard = $_POST['wardInput'];
            
                $selectedProvince = isset($_SESSION['selectedProvince']) ? $_SESSION['selectedProvince'] : '';
                $selectedDistrict = isset($_SESSION['selectedDistrict']) ? $_SESSION['selectedDistrict'] : '';
                $selectedWard = isset($_SESSION['selectedWard']) ? $_SESSION['selectedWard'] : '';

                // Sử dụng giá trị để truy vấn CSDL và lấy thông tin khách hàng
                $queryGetCustomerInfo = "SELECT * FROM dia_chi WHERE Tinh_TP = '$selectedProvince' AND Huyen_Quan = '$selectedDistrict' AND Xa_Phuong = '$selectedWard'";
                $resultGetCustomerInfo = mysqli_query($conn, $queryGetCustomerInfo);

                // Hiển thị thông tin khách hàng
                while ($rowCustomerInfo = mysqli_fetch_array($resultGetCustomerInfo)) {
                    $queryGetTT = "SELECT * FROM su_dung_dich_vu WHERE Da_xoa = 0 AND SoCCCD = " . $rowCustomerInfo['IDKhachHang'] . " AND IDGoiDichVu = " . $rowCustomerInfo['IDgoicuoc'];
                    $resultGetTT = mysqli_query($conn, $queryGetTT);
                    while ($rowCustomerTT = mysqli_fetch_array($resultGetTT)) {
                        $queryGetTTKH = "SELECT * FROM khach_hang WHERE Da_xoa = 0 AND CCCD = " . $rowCustomerInfo['IDKhachHang'];
                        $resultGetTTKH = mysqli_query($conn, $queryGetTTKH);
                        while ($rowCustomerTTKH = mysqli_fetch_array($resultGetTTKH)) {
                            ?>
                            <tr>
                                <td>
                                    <?php echo $rowCustomerTTKH['SDT']; ?>
                                </td>
                                <td>
                                    <?php echo $rowCustomerInfo['IDKhachHang']; ?>
                                </td>
                                <td>
                                    <?php echo $rowCustomerTTKH['HoTen']; ?>
                                </td>
                                <td>
                                    <?php
                                    $fullAddress = $rowCustomerInfo['SoNha'] . ', ' . $rowCustomerInfo['Xa_Phuong'] . ', ' . $rowCustomerInfo['Huyen_Quan'] . ', ' . $rowCustomerInfo['Tinh_TP'];
                                    echo $fullAddress;
                                    ?>
                                </td>
                                <td>

                                    <?php
                                    $TongTien = $rowCustomerTT['TongTien'];
                                    $thanhToanFormatted = number_format($TongTien, 0, ',', '.');
                                    echo $thanhToanFormatted . "VNĐ"; ?>
                                </td>
                                <td>
                                    <?php
                                    $Thanhtoan = $rowCustomerTT['Thanhtoan'];
                                    if ($Thanhtoan == 1) {
                                        ?>
                                        <p style="color: blue;font-weight: 600;">Đã thanh toán</p>
                                        <?php
                                    } else {
                                        ?>
                                        <p style="color: red;font-weight: 600;">Chưa thanh toán</p>
                                        <?php
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php if ($rowCustomerTT['Thanhtoan'] != 1) {
                                        ?>
                                        <form action="" method="POST">
                                            <input type="hidden" name="SoCCCD" value="<?php echo $rowCustomerInfo['IDKhachHang']; ?>">
                                            <input type="hidden" name="IDGoiDichVu" value="<?php echo $rowCustomerInfo['IDgoicuoc']; ?>">
                                            <input type="hidden" name="provinceInput"
                                                value="<?php echo isset($_SESSION['selectedProvince']) ? $_SESSION['selectedProvince'] : ''; ?>">
                                            <input type="hidden" name="districtInput"
                                                value="<?php echo isset($_SESSION['selectedDistrict']) ? $_SESSION['selectedDistrict'] : ''; ?>">
                                            <input type="hidden" name="wardInput"
                                                value="<?php echo isset($_SESSION['selectedWard']) ? $_SESSION['selectedWard'] : ''; ?>">
                                            <input type="hidden" name="SoCCCD" value="<?php echo $rowCustomerInfo['IDKhachHang']; ?>">
                                            <input type="hidden" name="IDGoiDichVu" value="<?php echo $rowCustomerInfo['IDgoicuoc']; ?>">
                                            <input name="XacNhanTT1" type="submit" value="Xác nhận">
                                        </form>
                                        <?php
                                    }
                                    ?>
                                </td>
                            </tr>

                            <?php

                        }
                    }
                }
                ?>
            </table>
        </div>
        <?php
    } ?>
    <script>
        function confirmPay() {
            return confirm("Xác nhận");
        }
        <?php
        if (isset($_POST['XacNhanTT1'])) {
            echo "bấm xác nhận r";
            $SoCCCD = $_POST['SoCCCD'];
            $IDGoiDichVu = $_POST['IDGoiDichVu'];
            ?>
                < input type = "hidden" name = "provinceInput"
            value = "<?php echo isset($_SESSION['selectedProvince']) ? $_SESSION['selectedProvince'] : ''; ?>" >
                <input type="hidden" name="districtInput"
                    value="<?php echo isset($_SESSION['selectedDistrict']) ? $_SESSION['selectedDistrict'] : ''; ?>">
                    <input type="hidden" name="wardInput"
                        value="<?php echo isset($_SESSION['selectedWard']) ? $_SESSION['selectedWard'] : ''; ?>">
                        <?php
                        // Cập nhật giá trị của cột Thanhtoan thành 1
                        $query_update_thanhtoan = "UPDATE su_dung_dich_vu SET Thanhtoan = 1 WHERE SoCCCD='$SoCCCD' AND IDGoiDichVu = '$IDGoiDichVu'";
                        $result_update_thanhtoan = mysqli_query($conn, $query_update_thanhtoan);

                        if ($result_update_thanhtoan) {
                            echo "location.reload();";
                            echo 'function confirmPay() {
            return confirm("Xác nhận");
        }';
                        } else {
                            echo "Cập nhật thất bại: " . mysqli_error($conn);
                        }
        }
        ?>
                </div>
            </div>
    </div >
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js"
        integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../API.js"> </script>
</body>

</html>