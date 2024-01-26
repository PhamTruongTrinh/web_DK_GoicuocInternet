<?php
//////////f5 mất hết
///     9704 0000 0000 0018
include_once('db/connect.php');
include_once('Navbar.php');

if (isset($_GET['partnerCode'])) {
    $tengoiDV = $_SESSION['tengoiDV'];
    $sql = "SELECT ID FROM goi_dich_vu WHERE TenGoiDichVu = '$tengoiDV'";

    // Thực hiện truy vấn
    $result = mysqli_query($conn, $sql);

    // Kiểm tra và lấy giá trị ID nếu có kết quả
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        if ($row) {
            $goidichvuID = $row['ID'];
            $_SESSION['goidichvuID'] = $goidichvuID;
        }
    }

    $fullname = $_SESSION['fullname'];
    $phone = $_SESSION['phone'];
    $dob = $_SESSION['dob'];
    $idnumber = $_SESSION['idnumber'];
    $matkhau = $_SESSION['matkhau'];
    $gender = $_SESSION['gender'];
    $email = $_SESSION['email'];
    $thoigianDK = $_SESSION['thoigianDK'];
    $giacuoc = $_SESSION['giacuoc'];
    $ngayHienTai = $_SESSION['ngayHienTai'];
    $ngayMoi = $_SESSION['ngayMoi'];
    $tinh = $_SESSION['provinceInput'];
    $huyen = $_SESSION['districtInput'];
    $xa = $_SESSION['wardInput'];
    $diachi = $_SESSION['Diachi'];
    $orderId = $_GET['orderId'];
    $thanhtoan = $_GET['amount'];
    if (!$conn) {
        die("Kết nối đến database thất bại: " . mysqli_connect_error());
    } else {
        $query3 = "SELECT * FROM su_dung_dich_vu WHERE SoCCCD='$idnumber'";
        $result3 = mysqli_query($conn, $query3);
        if (mysqli_num_rows($result3) > 0) {
            $query2 = "INSERT INTO su_dung_dich_vu (ID, SoCCCD, IDGoiDichVu, NgayBatDau, NgayKetThuc,TongTien,status,Thanhtoan, Da_xoa) VALUE ('$orderId','$idnumber', '$goidichvuID', '$ngayHienTai', '$ngayMoi','$thanhtoan',0,1,0)";
            mysqli_query($conn, $query2);
            $goidichvuID = $_SESSION['goidichvuID'];

            $querySelect = "SELECT SoLuotDK FROM goi_dich_vu WHERE ID = $goidichvuID";
            $resultDK = mysqli_query($conn, $querySelect);
            if ($resultDK) {
                $row = mysqli_fetch_assoc($resultDK);
                $soLuotDKCu = $row['SoLuotDK'];

                // Cộng 1 và cập nhật lại vào cơ sở dữ liệu
                $soLuotDKMoi = $soLuotDKCu + 1;

                $queryUpdate = "UPDATE goi_dich_vu SET SoLuotDK = $soLuotDKMoi WHERE ID = $goidichvuID";
                $resultUpdate = mysqli_query($conn, $queryUpdate);
            }
            echo '<script type="text/javascript"> alert(\'Đăng kí thành công. Vui lòng đăng nhập để quản lý gói cước\'); </script>';
        } else {
            $query = "INSERT INTO khach_hang (HoTen, CCCD, SDT, GioiTinh, NgaySinh, Email, Da_xoa) VALUES ('$fullname', '$idnumber', '$phone', '$gender', '$dob', '$email', 0)";
            $query2 = "INSERT INTO su_dung_dich_vu (ID, SoCCCD, IDGoiDichVu, NgayBatDau, NgayKetThuc,TongTien,status,Thanhtoan, Da_xoa) VALUE ('$orderId','$idnumber', '$goidichvuID', '$ngayHienTai', '$ngayMoi','$thanhtoan',0,1,0)";
            $query4 = "INSERT INTO tai_khoan (Tai_khoan,Mat_khau,Role, Da_xoa) VALUES ('$email','$matkhau', 0 ,0)";
            $queryDiaChi = "INSERT INTO dia_chi (IDKhachHang, IDgoicuoc, Tinh_TP, Huyen_Quan, Xa_Phuong, SoNha, Da_Xoa) VALUES ('$idnumber', '$goidichvuID', '$tinh', '$huyen', '$xa', '$diachi', 0)";

            mysqli_query($conn, $query);
            mysqli_query($conn, $query2);
            mysqli_query($conn, $query4);
            mysqli_query($conn, $queryDiaChi);
            $goidichvuID = $_SESSION['goidichvuID'];

            $querySelect = "SELECT SoLuotDK FROM goi_dich_vu WHERE ID = $goidichvuID";
            $resultDK = mysqli_query($conn, $querySelect);
            if ($resultDK) {
                $row = mysqli_fetch_assoc($resultDK);
                $soLuotDKCu = $row['SoLuotDK'];

                // Cộng 1 và cập nhật lại vào cơ sở dữ liệu
                $soLuotDKMoi = $soLuotDKCu + 1;

                $queryUpdate = "UPDATE goi_dich_vu SET SoLuotDK = $soLuotDKMoi WHERE ID = $goidichvuID";
                $resultUpdate = mysqli_query($conn, $queryUpdate);
            }

            echo '<script type="text/javascript"> alert(\'Đăng kí thành công. Vui lòng đăng nhập để quản lý gói cước\'); </script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Checkout</title>
    <link rel="stylesheet" href="./CSS/checkout.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
</head>

<body>
    <div class="hoadon">
        <h1>Thông tin hóa đơn</h1>
        <div class="checkout_container">
            <div class="checkout_info">
                <p><strong>Mã đơn đăng kí:</strong>
                    <?php echo $orderId; ?>
                </p>
                <p><strong>Họ tên khách hàng:</strong>
                    <?php echo $fullname; ?>
                </p>
                <p><strong>Số CCCD:</strong>
                    <?php echo $idnumber; ?>
                </p>
                <p><strong>Số điện thoại:</strong>
                    <?php echo $phone; ?>
                </p>
                <p><strong>Ngày sinh:</strong>
                    <?php echo $dob; ?>
                </p>
                <p><strong>Giới tính:</strong>
                    <?php echo $gender; ?>
                </p>
                <p><strong>Email:</strong>
                    <?php echo $email; ?>
                </p>
            </div>
            <div class="checkout_info" style="margin-top: -5%">
                <div id="qrcode" style="width: 100px; height: 100px; background-color: aqua;"></div>
                <p><strong>Tên gói dịch vụ:</strong>
                    <?php echo $tengoiDV; ?>
                </p>
                <p><strong>Giá cước:</strong>
                    <?php echo $giacuoc . ".000VNĐ/tháng"; ?>
                </p>
                <p><strong>Thời gian đăng ký:</strong>
                    <?php echo $thoigianDK; ?> tháng
                </p>
                <p><strong>Ngày bắt đầu:</strong>
                    <?php echo $ngayHienTai; ?>
                </p>
                <p><strong>Ngày hết hạn:</strong>
                    <?php echo $ngayMoi; ?>
                </p>
                <p><strong>Thành tiền:</strong>
                    <?php
                    $thanhToanFormatted = number_format($thanhtoan, 0, ',', '.');
                    echo $thanhToanFormatted . "VNĐ"; ?>
                </p>
            </div>
        </div>
    </div>
    <!-- <button onclick="generatePDF()">Tải PDF</button> -->

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            generateAutoQR();
        });

        function generateAutoQR() {
            let madonhang = "<?php echo $orderId; ?>";
            let idnumber = "<?php echo $idnumber; ?>";

            let qrContent =
                `IDHD: ${madonhang}\nIDKH: ${idnumber}`;
            window.html2canvas = window.html2canvas.html2canvas;
            // Tạo mã QR sử dụng thư viện qrcodejs
            var qrcode = new QRCode(document.getElementById('qrcode'), {
                text: qrContent,
                width: 100,
                height: 100,
                colorDark: '#000000',
                colorLight: '#ffffff',
            });
        }
    </script>
    <script>
        function generatePDF() {
            window.jsPDF = window.jspdf.jsPDF;
            const pdf = new jsPDF();
            const element = document.querySelector('.hoadon');
            pdf.html(element, {
                callback: function (pdf) {
                    pdf.save('hoadon.pdf');
                },
            });
        }
    </script>
</body>

</html>