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
        $query3 = "SELECT * FROM su_dung_dich_vu WHERE SoCCCD='$idnumber' AND IDGoiDichVu = '$goidichvuID'";
        $result3 = mysqli_query($conn, $query3);
        if (mysqli_num_rows($result3) > 0) {
            $query = "UPDATE su_dung_dich_vu SET NgayKetThuc = '$ngayMoi', status = 0 WHERE SoCCCD='$idnumber' AND IDGoiDichVu = '$goidichvuID'";
            // $query2 = "INSERT INTO su_dung_dich_vu (SoCCCD, IDGoiDichVu, NgayBatDau, NgayKetThuc,status, Da_xoa) VALUE ('$idnumber', '$goidichvuID', '$ngayHienTai', '$ngayMoi',0,0)";
            mysqli_query($conn, $query);
            echo '<script type="text/javascript"> alert(\'Gia hạn thành công\'); </script>';
            exit();
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
        <h1>Thông tin hóa đơn gia hạn</h1>
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