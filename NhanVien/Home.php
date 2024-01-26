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
            <div class="chonTinh">
                <label for="province">Tỉnh/Thành phố</label>
                <select name="province" id="province">
                </select>
                <input type="hidden" id="provinceInput" name="provinceInput" readonly>
                <label for="district">Quận/Huyện</label>
                <select name="district" id="district">
                    <option value="">chọn quận</option>
                </select>
                <input type="hidden" id="districtInput" name="districtInput" readonly>
                <label for="ward">Xã/Phường</label>
                <select name="ward" id="ward">
                    <option value="">chọn phường</option>
                </select>
                <input type="hidden" id="wardInput" name="wardInput" readonly>
                <input type="submit" name="Tim" value="Tìm">
            </div>
        </form>
        <form action="" method="POST">
            <input type="submit" name="ShowAll" value="Xem danh sách">
        </form>
    </div>
    <?php
    $_SESSION['payment_confirmed'] = true;
    if (isset($_POST['ShowAll'])) {
        unset($_SESSION['selectedProvince']);
        unset($_SESSION['selectedDistrict']);
        unset($_SESSION['selectedWard']);
        header('Location: Home.php');
    }

    if (isset($_POST['XacNhanTT'])) {
        $SoCCCD = $_POST['SoCCCD'];
        $IDGoiDichVu = $_POST['IDGoiDichVu'];
        // Cập nhật Thanhtoan thành 1
        $query_update_thanhtoan = "UPDATE su_dung_dich_vu SET Thanhtoan = 1 WHERE SoCCCD='$SoCCCD' AND IDGoiDichVu = '$IDGoiDichVu'";
        $result_update_thanhtoan = mysqli_query($conn, $query_update_thanhtoan);
        if (isset($_SESSION['payment_confirmed']) && $_SESSION['payment_confirmed']) {
            // Đặt lại giá trị session để ngăn chặn hiển thị thông báo lại
            $_SESSION['payment_confirmed'] = false;
        } else {
            echo "Cập nhật thất bại: " . mysqli_error($conn);
        }
    }
    if (isset($_POST['Tim']) || isset($_POST['provinceInput']) || isset($_POST['XacNhanTT1'])) {
        if (isset($_POST['provinceInput'])) {
            $_SESSION['selectedProvince'] = $_POST['provinceInput'];
        }

        if (isset($_POST['districtInput'])) {
            $_SESSION['selectedDistrict'] = $_POST['districtInput'];
        }

        if (isset($_POST['wardInput'])) {
            $_SESSION['selectedWard'] = $_POST['wardInput'];
        }

        if (isset($_POST['XacNhanTT1'])) {
            $SoCCCD = $_POST['SoCCCD'];
            $IDGoiDichVu = $_POST['IDGoiDichVu'];
            // Cập nhật Thanhtoan thành 1
            $query_update_thanhtoan = "UPDATE su_dung_dich_vu SET Thanhtoan = 1 WHERE SoCCCD='$SoCCCD' AND IDGoiDichVu = '$IDGoiDichVu'";
            $result_update_thanhtoan = mysqli_query($conn, $query_update_thanhtoan);

            if (isset($_SESSION['payment_confirmed']) && $_SESSION['payment_confirmed']) {
                // Đặt lại giá trị session để ngăn chặn hiển thị thông báo lại
                $_SESSION['payment_confirmed'] = false;
            } else {
                echo "Cập nhật thất bại: " . mysqli_error($conn);
            }
        }
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
                                            <input name="XacNhanTT1" type="submit" value="Xác nhận"
                                                onclick="return confirm('Xác nhận thanh toán?');">
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
    } else {
        ?>
        <div style="width: 85%; margin: auto;">
            <div style="width: 100%">
                <div class="col-md-8">
                    <?php
                    echo '<h2>Danh sách thu phí</h2>';
                    $sql_select_goicuoc = mysqli_query($conn, "SELECT su_dung_dich_vu.*, khach_hang.HoTen FROM su_dung_dich_vu 
                JOIN khach_hang ON su_dung_dich_vu.SoCCCD = khach_hang.CCCD
                WHERE su_dung_dich_vu.Da_xoa = 0 ORDER BY su_dung_dich_vu.ID DESC");
                    ?>
                    <div class="table-wrapper">
                        <table style="width: 100%" class="table table-bordered">
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
                            $i = 0;
                            while ($row_goicuoc = mysqli_fetch_array($sql_select_goicuoc)) {
                                $i++;
                                // Cập nhật trạng thái gói cước dựa trên ngày kết thúc
                                $currentDate = date("Y-m-d");
                                $queryUpdateStatus = "UPDATE su_dung_dich_vu SET status = 2 WHERE NgayKetThuc < '$currentDate' AND SoCCCD = '" . $row_goicuoc['SoCCCD'] . "' AND IDGoiDichVu = " . $row_goicuoc['IDGoiDichVu'];
                                mysqli_query($conn, $queryUpdateStatus);
                                ?>
                                <tr>
                                    <td>
                                        <?php
                                        $getid = $row_goicuoc['SoCCCD'];
                                        $query_get_SDT = "SELECT SDT FROM khach_hang WHERE CCCD='$getid'";
                                        $result_get_SDT = mysqli_query($conn, $query_get_SDT);
                                        $row_get_SDT = mysqli_fetch_array($result_get_SDT);
                                        echo $row_get_SDT['SDT'] ?>
                                    </td>
                                    <td> <!-- Hiển thị số CCCD -->
                                        <?php echo $row_goicuoc['SoCCCD']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row_goicuoc['HoTen']; ?>
                                    </td>

                                    <td>
                                        <?php
                                        $query3 = "SELECT Tinh_TP, Huyen_Quan, Xa_Phuong, SoNha FROM dia_chi WHERE Da_xoa = 0 AND IDgoicuoc = " . $row_goicuoc['IDGoiDichVu'] . " AND IDKhachHang = '" . $row_goicuoc['SoCCCD'] . "'";
                                        $result3 = mysqli_query($conn, $query3);
                                        $row_result3 = mysqli_fetch_array($result3);
                                        if ($row_result3) {
                                            $fullAddress = $row_result3['SoNha'] . ', ' . $row_result3['Xa_Phuong'] . ', ' . $row_result3['Huyen_Quan'] . ', ' . $row_result3['Tinh_TP'];

                                        } else {
                                            echo "Không có dữ liệu";
                                        }
                                        ?>
                                        <?php echo $fullAddress ?>
                                    </td>
                                    <td>
                                        <?php
                                        $query3 = "SELECT TongTien FROM Su_dung_dich_vu WHERE IDGoiDichVu= " . $row_goicuoc['IDGoiDichVu'] . " AND SoCCCD = '$getid'";
                                        $result3 = mysqli_query($conn, $query3);
                                        $row_result3 = mysqli_fetch_array($result3);

                                        if ($row_result3) {
                                            $TongTien = $row_result3['TongTien'];
                                            $thanhToanFormatted = number_format($TongTien, 0, ',', '.');
                                            echo $thanhToanFormatted . "VNĐ";
                                        } else {
                                            echo "Không có dữ liệu";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $query4 = "SELECT Thanhtoan FROM su_dung_dich_vu WHERE IDGoiDichVu = " . $row_goicuoc['IDGoiDichVu'] . " AND SoCCCD = '$getid'";
                                        $result4 = mysqli_query($conn, $query4);
                                        $row_result4 = mysqli_fetch_array($result4);
                                        if ($row_result4) {
                                            $Thanhtoan = $row_result4['Thanhtoan'];
                                            if ($Thanhtoan == 1) {
                                                ?>
                                                <p style="color: blue;font-weight: 600;">Đã thanh toán</p>
                                                <?php
                                            } else {
                                                ?>
                                                <p style="color: red;font-weight: 600;">Chưa thanh toán</p>
                                                <?php

                                            }
                                        } else {
                                            echo "Không có dữ liệu";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php if ($row_result4['Thanhtoan'] != 1) {
                                            ?>
                                            <form action="" method="POST" onsubmit="return confirmPay();">
                                                <input type="hidden" name="SoCCCD" value="<?php echo $row_goicuoc['SoCCCD']; ?>">
                                                <input type="hidden" name="IDGoiDichVu"
                                                    value="<?php echo $row_goicuoc['IDGoiDichVu']; ?>">
                                                <input name="XacNhanTT" type="submit" value="Xác nhận"
                                                    onclick="return confirm('Xác nhận thanh toán?');">
                                            </form>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                </tr>

                                <?php
                            }
                            ?>
                            <tr>
                                <th>SDT</th>
                                <th>CCCD</th>
                                <th>Họ và tên</th>
                                <th>Địa chỉ lắp đặt</th>
                                <th>Tổng tiền thanh toán</th>
                                <th>Trạng thái thanh toán</th>
                                <th>Xác nhận thanh toán</th>
                            </tr>
                        </table>
                    </div>
                    <?php
    }
    ?>

            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js"
        integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../API.js"> </script>
</body>

</html>