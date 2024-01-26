<?php
include_once('db/connect.php');
include_once('Navbar.php');
ob_start();
if (isset($_GET['Products_id'])) {
    $Products_id = $_GET['Products_id'];
    $sql_details = mysqli_query($conn, "SELECT * FROM goi_dich_vu WHERE ID = $Products_id");
    $row_details = mysqli_fetch_array($sql_details);
    $_SESSION['showDC'] = false;
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Package Details</title>
        <link rel="stylesheet" href="CSS/dangkigoicuoc1test.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>

    <body>
        <div class="card">
            <h1>
                Gói cước
                <?php echo $row_details['TenGoiDichVu'];
                $_SESSION['tengoiDV'] = $row_details['TenGoiDichVu'];
                ?>
            </h1>
            <div class="speed">
                Tốc độ:
                <?php echo $row_details['TocDo']; ?>
            </div>
            <div class="mota">
                <h3>Với các ưu điểm</h3>
                <?php echo $row_details['MoTa']; ?>
            </div>
            <div class="price">
                Chỉ với:
                <?php $getGia = $row_details['GiaCuoc'];
                    $thanhToanFormatted = number_format($getGia, 0, ',', '.');
                    echo $thanhToanFormatted . ".000VNĐ/Tháng"; ?>
                <?php
                $_SESSION['giacuoc'] = $row_details['GiaCuoc'];
                ?>
            </div>
        </div>
        <br>
        <br>
        <form id='Dangki' action="" method="POST" role="form">
            <div class="container">
                <h1>Thông tin khách hàng</h1>
                <!-- Số CMND/CCCD -->
                    <label for="idnumber">Số CMND/CCCD</label>
                    <input type="text" id="idnumber" name="idnumber" value="<?php if (isset($_POST['idnumber']))
                            echo $_POST['idnumber'];?>" required>
                    <!-- Họ tên -->
                    <label for="fullname">Họ tên</label>
                    <input type="text" id="fullname" name="fullname" value="<?php if(isset($_POST['fullname'])) echo $_POST['fullname'];?>" required>
                
                    <!-- Ngày sinh -->
                    <label for="dob">Ngày sinh</label>
                    <input type="date" id="dob" name="dob" value="<?php if (isset($_POST['dob']))
                            echo $_POST['dob']; ?>" required>
                
                    <!-- Số điện thoại -->
                    <label for="phone">Số điện thoại</label>
                    <input type="tel" id="phone" name="phone" value="<?php if (isset($_POST['phone']))
                            echo $_POST['phone'];?>" required>
                
                    <!-- Địa chỉ email -->
                    <label for="email">Địa chỉ email:</label>
                    <input type="email" id="email" name="email" value="<?php if (isset($_POST['email']))
                            echo $_POST['email'];?>" required>
                
                    <!-- Giới tính -->
                    <label for="gender">Giới tính</label>
                    <select id="gender" name="gender" required>
                        <option value="" <?php echo !isset($_POST['gender']) ? 'selected' : ''; ?>>--Chọn giới tính--</option>
                        <option value="Nam" <?php echo isset($_POST['gender']) && $_POST['gender'] === 'Nam' ? 'selected' : ''; ?>>Nam
                        </option>
                        <option value="Nữ" <?php echo isset($_POST['gender']) && $_POST['gender'] === 'Nữ' ? 'selected' : ''; ?>>Nữ</option>
                    </select>

                </div>
                <div class="chonTinh">
                    <h1>Địa chỉ lắp đặt</h1>
                    <label for="province">Tỉnh/Thành phố</label>
                    <select name="province" id="province" required>
                    </select>
                    <!-- Thêm thẻ input cho Tỉnh/Thành phố -->
                    <input type="hidden" id="provinceInput" name="provinceInput" readonly>
                    <label for="district">Quận/Huyện</label>
                    <select name="district" id="district" required>
                        <option value="">chọn quận</option>
                    </select>
                    <!-- Thêm thẻ input cho Quận/Huyện -->
                    <input type="hidden" id="districtInput" name="districtInput" readonly>
                    <label for="ward">Xã/Phường</label>
                    <select name="ward" id="ward" required>
                        <option value="">chọn phường</option>
                    </select>
                    <!-- Thêm thẻ input cho Xã/Phường -->
                    <input type="hidden" id="wardInput" name="wardInput" readonly>
                    <label for="Diachi">Địa chỉ/Số nhà:</label>
                    <input style="font-size: 18px;font-weight: 600;" type="text" id="Diachi" name="Diachi" required>
                </div>
                <div class="containerGoicuoc">
                    <label for="goicuoc">Chọn thời gian đăng kí</label>
                    <select id="goicuoc" name="goicuoc" required>
                        <option value="" <?php echo !isset($_POST['goicuoc']) ? 'selected' : ''; ?>>--Chọn gói cước
                        internet--</option>
                    <option value="12" <?php echo isset($_POST['goicuoc']) && $_POST['goicuoc'] === '12' ? 'selected' : ''; ?>>Trả
                        trước 12 tháng sử dụng 14 tháng</option>
                    <option value="6" <?php echo isset($_POST['goicuoc']) && $_POST['goicuoc'] === '6' ? 'selected' : ''; ?>>
                        Trả trước
                        6 tháng sử dụng 7 tháng</option>
                    <option value="3" <?php echo isset($_POST['goicuoc']) && $_POST['goicuoc'] === '3' ? 'selected' : ''; ?>>
                        Trả trước
                        3 tháng sử dụng 3 tháng</option>
                </select>
            </div>
            <div class="Thanhtoan">
                <h1>Phương thức thanh toán</h1>
                <input style="width: 48%; float:left; margin-top: 3%; height: 50px;" name="Thanhtoan" type="submit"
                value="Thanh toán tại nhà" onclick="return confirmPay()">

                <input style="width: 48%; float:right; margin-top: 3%; height: 50px;" type="submit" name="momo"
                value="Thanh toán momo" class="btn btn-danger" onclick="return confirmPay()">

            </div>
        </form>
        <div id='bottom'>
            <?php
                if (isset($_POST['Thanhtoan'])) {
                    $tinh = $_POST['provinceInput'];
                    $huyen = $_POST['districtInput'];
                    $xa = $_POST['wardInput'];
                    $diachi = $_POST['Diachi'];
                    $_SESSION['Checktt'] = true;

                    $_SESSION['provinceInput'] = $tinh;
                    $_SESSION['districtInput'] = $huyen;
                    $_SESSION['wardInput'] = $xa;
                    $_SESSION['Diachi'] = $diachi;

                    ////////////////////////////////
                    $fullname = $_POST['fullname'];
                    $phone = $_POST['phone'];
                    $dob = $_POST['dob'];
                    $idnumber = $_POST['idnumber'];
                    $matkhau = md5($_POST['idnumber']);
                    $gender = $_POST['gender'];
                    $email = $_POST['email'];
                    $thoigianDK = $_POST['goicuoc'];
                    $thoigianTT = $thoigianDK;
                    if ($thoigianDK == 12) {
                        $thoigianDK += 2;
                    } elseif ($thoigianDK == 6) {
                        $thoigianDK += 1;
                    }
                    $ngayHienTai = date("Y-m-d");
                    $ngayMoiTimestamp = strtotime($ngayHienTai . "+$thoigianDK month");
                    $ngayMoi = date("Y-m-d", $ngayMoiTimestamp);
                    $thanhtoan = (($getGia * 1000) * $thoigianTT);

                    //lưu session thực hiện query dưới
                    $_SESSION['fullname'] = $fullname;
                    $_SESSION['phone'] = $phone;
                    $_SESSION['dob'] = $dob;
                    $_SESSION['idnumber'] = $idnumber;
                    $_SESSION['matkhau'] = $matkhau;
                    $_SESSION['gender'] = $gender;
                    $_SESSION['email'] = $email;
                    $_SESSION['thoigianDK'] = $thoigianDK;
                    $_SESSION['ngayHienTai'] = $ngayHienTai;
                    $_SESSION['ngayMoi'] = $ngayMoi;
                    $_SESSION['thanhtoan'] = $thanhtoan;

                    $query0 = "SELECT * FROM su_dung_dich_vu WHERE SoCCCD='$idnumber' && IDGoiDichVu = $Products_id";
                    $result0 = mysqli_query($conn, $query0);
                    $query3 = "SELECT * FROM su_dung_dich_vu WHERE SoCCCD='$idnumber'";
                    $result3 = mysqli_query($conn, $query3);
                    // check thông tin nhập vs tt trong DB
                    $sql_check = mysqli_query($conn, "SELECT * FROM khach_hang WHERE CCCD = '$idnumber' AND Da_xoa = 0");
                    //check email đã đc sử dụng
                    $sql = "SELECT * FROM khach_hang WHERE Email = '$email' AND CCCD != '$idnumber' AND Da_xoa = 0";
                    $result5 = mysqli_query($conn, $sql);

                    // kiểm tra tuổi
                    $ngaySinhTimestamp = strtotime($dob);
                    $tuoi = floor((time() - $ngaySinhTimestamp) / 31556926); // Số giây trong một năm
                    if (
                        empty($fullname) || empty($phone) || empty($dob) ||
                        empty($idnumber) || empty($matkhau) || empty($email)
                        || empty($thoigianDK) || empty($gender)
                    ) {
                        echo '<script type="text/javascript"> alert(\'Vui lòng điền đầy đủ thông tin\'); </script>';

                    } else if (!preg_match('/^[0-9]{10}$/', $phone)) {
                        echo '<script type="text/javascript"> alert(\'Số điện thoại phải có đúng 10 số. Vui lòng kiểm tra lại\'); </script>';


                    } else if (!preg_match('/^[0-9]{12}$/', $idnumber)) {
                        echo '<script type="text/javascript"> alert(\'CCCD phải có đúng 12 số. Vui lòng kiểm tra lại\'); </script>';


                    } else if (preg_match('/[0-9]/', $fullname)) {
                        echo '<script type="text/javascript"> alert(\'Họ tên không được chứa số. Vui lòng kiểm tra lại\'); </script>';


                    } else if ($tuoi < 18) {
                        echo '<script type="text/javascript"> alert(\'Bạn phải đủ 18 tuổi để đăng ký! Vui lòng kiểm tra lại ngày sinh\'); </script>';

                        // DL CHUẨN FOMAT
                    } else if (mysqli_num_rows($result5) > 0) {
                        //chech trung ok
                        echo '<script type="text/javascript"> alert(\'Email ' . $email . ' đã được đăng kí vui lòng kiểm tra lại\'); </script>';

                    } else if ($sql_check != null) { //OK
                        // nếu có sẵn thông tin khách hàng trong bảng
                        //  dựa vào CCCD tìm các thông tin khác xem khách hàng nhập có đúng không
                        //      nếu đúng cho đăng kí mới
                        while ($row_check = mysqli_fetch_array($sql_check)) {
                            if ($row_check['HoTen'] != $fullname || $row_check['SDT'] != $phone || $row_check['GioiTinh'] != $gender || $row_check['NgaySinh'] != $dob || $row_check['Email'] != $email) {
                                echo '<script type="text/javascript"> alert(\'Thông tin không trùng khớp với thông tin đã đăng kí với CCCD số:' . $idnumber . ' vui lòng kiểm tra lại các thông tin \'); </script>';
                                $_SESSION['Checktt'] = false;
                            }
                        }
                        if (mysqli_num_rows($result0) > 0) {
                            // khách hàng đăng kí lại gói đang sử dụng ==> báo lỗi
                            //      không cho đăng kí lại gói đang dùng                           
                            echo '<script type="text/javascript"> alert(\'Quý khách có số căn cước ' . $idnumber . ' đã đăng ký gói dịch vụ này.\n Nếu muốn thêm thời gian sử dụng vui lòng chọn gia hạn gói cước\'); </script>';
                        }
                        else{
                            if($_SESSION['Checktt'] == true){
                        $fullname = $_SESSION['fullname'];
                        $phone = $_SESSION['phone'];
                        $dob = $_SESSION['dob'];
                        $idnumber = $_SESSION['idnumber'];
                        $matkhau = $_SESSION['matkhau'];
                        $gender = $_SESSION['gender'];
                        $email = $_SESSION['email'];
                        $thoigianDK = $_SESSION['thoigianDK'];
                        $ngayHienTai = $_SESSION['ngayHienTai'];
                        $ngayMoi = $_SESSION['ngayMoi'];
                        $tinh = $_SESSION['provinceInput'];
                        $huyen = $_SESSION['districtInput'];
                        $xa = $_SESSION['wardInput'];
                        $diachi = $_SESSION['Diachi'];
                        $thanhtoan = $_SESSION['thanhtoan'];
                        if (!$conn) {

                            die("Kết nối đến database thất bại: " . mysqli_connect_error());
                        } else {
                            $query3 = "SELECT * FROM su_dung_dich_vu WHERE SoCCCD='$idnumber' ";
                            $result3 = mysqli_query($conn, $query3);
                            if (mysqli_num_rows($result3) > 0) {
                                $query2 = "INSERT INTO su_dung_dich_vu (SoCCCD, IDGoiDichVu, NgayBatDau, NgayKetThuc,TongTien,status, Da_xoa) VALUE ('$idnumber', '$Products_id', '$ngayHienTai', '$ngayMoi','$thanhtoan',0,0)";
                                mysqli_query($conn, $query2);
                                $queryDiaChi = "INSERT INTO dia_chi (IDKhachHang, IDgoicuoc, Tinh_TP, Huyen_Quan, Xa_Phuong, SoNha, Da_Xoa) VALUES ('$idnumber', '$Products_id', '$tinh', '$huyen', '$xa', '$diachi', 0)";
                                mysqli_query($conn, $queryDiaChi);
                                if ($result5->num_rows > 0) {
                                    $row = $result5->fetch_assoc();
                                    $lastID = $row['ID'];
                                    $_SESSION['IDHD'] = $lastID;
                                }
                                    $querySelect = "SELECT SoLuotDK FROM goi_dich_vu WHERE ID = $Products_id";
                                    $resultDK = mysqli_query($conn, $querySelect);
                                    if ($resultDK) {
                                        $row = mysqli_fetch_assoc($resultDK);
                                        $soLuotDKCu = $row['SoLuotDK'];

                                        // Cộng 1 và cập nhật lại vào cơ sở dữ liệu
                                        $soLuotDKMoi = $soLuotDKCu + 1;

                                        $queryUpdate = "UPDATE goi_dich_vu SET SoLuotDK = $soLuotDKMoi WHERE ID = $Products_id";
                                        $resultUpdate = mysqli_query($conn, $queryUpdate);
                                    }
                                echo '<script type="text/javascript"> alert(\'Đăng kí thành công. Hãy đăng nhập để quản lý gói cước\'); </script>';
                            } else {
                                $query = "INSERT INTO khach_hang (HoTen, CCCD, SDT, GioiTinh, NgaySinh, Email, Da_xoa) VALUES ('$fullname', '$idnumber', '$phone', '$gender', '$dob', '$email', 0)";
                                $query2 = "INSERT INTO su_dung_dich_vu (SoCCCD, IDGoiDichVu, NgayBatDau, NgayKetThuc,TongTien,status, Da_xoa) VALUE ('$idnumber', '$Products_id', '$ngayHienTai', '$ngayMoi','$thanhtoan',0,0)";
                                $query4 = "INSERT INTO tai_khoan (Tai_khoan,Mat_khau,Role, Da_xoa) VALUES ('$email','$matkhau', 0 ,0)";
                                $queryDiaChi = "INSERT INTO dia_chi (IDKhachHang, IDgoicuoc, Tinh_TP, Huyen_Quan, Xa_Phuong, SoNha, Da_Xoa) VALUES ('$idnumber', '$Products_id', '$tinh', '$huyen', '$xa', '$diachi', 0)";
                                $querySelect = "SELECT SoLuotDK FROM goi_dich_vu WHERE ID = $Products_id";
                                $resultDK = mysqli_query($conn, $querySelect);
                                if ($resultDK) {
                                    $row = mysqli_fetch_assoc($resultDK);
                                    $soLuotDKCu = $row['SoLuotDK'];

                                    // Cộng 1 và cập nhật lại vào cơ sở dữ liệu
                                    $soLuotDKMoi = $soLuotDKCu + 1;

                                    $queryUpdate = "UPDATE goi_dich_vu SET SoLuotDK = $soLuotDKMoi WHERE ID = $Products_id";
                                    $resultUpdate = mysqli_query($conn, $queryUpdate);
                                }
                                mysqli_query($conn, $query);
                                mysqli_query($conn, $query2);
                                mysqli_query($conn, $query4);
                                mysqli_query($conn, $queryDiaChi);
                                echo '<script type="text/javascript"> alert(\'Đăng kí thành công. Hãy đăng nhập để quản lý gói cước\'); </script>';
                            }
                        }
                    }
                }
            }
        }

////////////////MOMO////////////////////////////////////////////
                if (isset($_POST['momo'])) {
                    $_SESSION['Checkttmomo'] = true;
                    $tinh = $_POST['provinceInput'];
                    $huyen = $_POST['districtInput'];
                    $xa = $_POST['wardInput'];
                    $diachi = $_POST['Diachi'];

                    $_SESSION['provinceInput'] = $tinh;
                    $_SESSION['districtInput'] = $huyen;
                    $_SESSION['wardInput'] = $xa;
                    $_SESSION['Diachi'] = $diachi;

                    ////////////////////////////////
                    $fullname = $_POST['fullname'];
                    $phone = $_POST['phone'];
                    $dob = $_POST['dob'];
                    $idnumber = $_POST['idnumber'];
                    $matkhau = md5($_POST['idnumber']);
                    $gender = $_POST['gender'];
                    $email = $_POST['email'];
                    $thoigianDK = $_POST['goicuoc'];
                    $thoigianTT = $thoigianDK;
                    if ($thoigianDK == 12) {
                        $thoigianDK += 2;
                    } elseif ($thoigianDK == 6) {
                        $thoigianDK += 1;
                    }
                    $ngayHienTai = date("Y-m-d");
                    $ngayMoiTimestamp = strtotime($ngayHienTai . "+$thoigianDK month");
                    $ngayMoi = date("Y-m-d", $ngayMoiTimestamp);
                    $thanhtoan = (($getGia * 1000) * $thoigianTT);

                    //lưu session thực hiện query dưới
                    $_SESSION['fullname'] = $fullname;
                    $_SESSION['phone'] = $phone;
                    $_SESSION['dob'] = $dob;
                    $_SESSION['idnumber'] = $idnumber;
                    $_SESSION['matkhau'] = $matkhau;
                    $_SESSION['gender'] = $gender;
                    $_SESSION['email'] = $email;
                    $_SESSION['thoigianDK'] = $thoigianDK;
                    $_SESSION['ngayHienTai'] = $ngayHienTai;
                    $_SESSION['ngayMoi'] = $ngayMoi;
                    $_SESSION['thanhtoan'] = $thanhtoan;

                    $query0 = "SELECT * FROM su_dung_dich_vu WHERE SoCCCD='$idnumber' && IDGoiDichVu = $Products_id";
                    $result0 = mysqli_query($conn, $query0);
                    $query3 = "SELECT * FROM su_dung_dich_vu WHERE SoCCCD='$idnumber'";
                    $result3 = mysqli_query($conn, $query3);
                    // check thông tin nhập vs tt trong DB
                    $sql_check = mysqli_query($conn, "SELECT * FROM khach_hang WHERE CCCD = '$idnumber' AND Da_xoa = 0");
                    //check email đã đc sử dụng
                    $sql = "SELECT * FROM khach_hang WHERE Email = '$email' AND CCCD != '$idnumber' AND Da_xoa = 0";
                    $result5 = mysqli_query($conn, $sql);

                    // Thêm kiểm tra tuổi
                    $ngaySinhTimestamp = strtotime($dob);
                    $tuoi = floor((time() - $ngaySinhTimestamp) / 31556926); // Số giây trong một năm
                    if (
                        empty($fullname) || empty($phone) || empty($dob) ||
                        empty($idnumber) || empty($matkhau) || empty($email)
                        || empty($thoigianDK) || empty($gender)
                    ) {
                        echo '<script type="text/javascript"> alert(\'Vui lòng điền đầy đủ thông tin\'); </script>';

                    } else if (!preg_match('/^[0-9]{10}$/', $phone)) {
                        echo '<script type="text/javascript"> alert(\'Số điện thoại phải có đúng 10 số\'); </script>';


                    } else if (!preg_match('/^[0-9]{12}$/', $idnumber)) {
                        echo '<script type="text/javascript"> alert(\'CCCD phải có đúng 12 số\'); </script>';


                    } else if (preg_match('/[0-9]/', $fullname)) {
                        echo '<script type="text/javascript"> alert(\'Họ tên không được chứa số\'); </script>';


                    } else if ($tuoi < 18) {
                        echo '<script type="text/javascript"> alert(\'Bạn phải đủ 18 tuổi để đăng ký! Hãy kiểm tra lại ngày sinh\'); </script>';

                        // DL CHUẨN FOMAT
                    } else if (mysqli_num_rows($result5) > 0) {
                        //chech trung ok
                        echo '<script type="text/javascript"> alert(\'Email ' . $email . ' đã được đăng kí vui lòng kiểm tra lại\'); </script>';

                    } else if ($sql_check != null) { //OK
                        // nếu có sẵn thông tin khách hàng trong bảng
                        //  dựa vào CCCD tìm các thông tin khác xem khách hàng nhập có đúng không
                        //      nếu đúng cho đăng kí mới
                        while ($row_check = mysqli_fetch_array($sql_check)) {
                            if ($row_check['HoTen'] != $fullname || $row_check['SDT'] != $phone || $row_check['GioiTinh'] != $gender || $row_check['NgaySinh'] != $dob || $row_check['Email'] != $email) {
                                echo '<script type="text/javascript"> alert(\'Thông tin không trùng khớp với thông tin đã đăng kí với CCCD số:' . $idnumber . ' vui lòng kiểm tra lại các thông tin \'); </script>';
                                $_SESSION['Checkttmomo'] = false;
                            }
                        }
                        if (mysqli_num_rows($result0) > 0) {
                            // khách hàng đăng kí lại gói đang sử dụng ==> báo lỗi
                            //      không cho đăng kí lại gói đang dùng                           
                            echo '<script type="text/javascript"> alert(\'Quý khách có số căn cước ' . $idnumber . ' đã đăng ký gói dịch vụ này\n Nếu muốn gia hạn vui lòng chọn "Gia hạn gói cước" \'); </script>';
                        } else {
                            if($_SESSION['Checkttmomo'] == true){
                                $fullname = $_SESSION['fullname'];
                                $phone = $_SESSION['phone'];
                                $dob = $_SESSION['dob'];
                                $idnumber = $_SESSION['idnumber'];
                                $matkhau = $_SESSION['matkhau'];
                                $gender = $_SESSION['gender'];
                                $email = $_SESSION['email'];
                                $thoigianDK = $_SESSION['thoigianDK'];
                                $ngayHienTai = $_SESSION['ngayHienTai'];
                                $ngayMoi = $_SESSION['ngayMoi'];
                                $tinh = $_SESSION['provinceInput'];
                                $huyen = $_SESSION['districtInput'];
                                $xa = $_SESSION['wardInput'];
                                $diachi = $_SESSION['Diachi'];
                                $thanhtoan = $_SESSION['thanhtoan'];
                                header('Location: testmomo.php');
                            }
                        }
                    }
                }
            ?>
        </div>

        <footer>
            <?php include_once('Footer.php'); ?>
        </footer>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
            integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js"
            integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="API.js"></script>

        <script>
    function confirmPay() {
        return confirm("Xác nhận thanh toán");
    }
</script>
    </body>
    <?php
}
?>

</html>