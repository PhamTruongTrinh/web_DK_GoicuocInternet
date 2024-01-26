<?php
///// 9704 0000 0000 0018
include_once('db/connect.php');
include_once('Navbar.php');

// if (isset($_GET['partnerCode'])) {
//     $tengoiDV = $_SESSION['tengoiDV'];
//     $sql = "SELECT ID FROM goi_dich_vu WHERE TenGoiDichVu = '$tengoiDV'";

//     // Thực hiện truy vấn
//     $result = mysqli_query($conn, $sql);

//     // Kiểm tra và lấy giá trị ID nếu có kết quả
//     if ($result) {
//         $row = mysqli_fetch_assoc($result);
//         if ($row) {
//             $goidichvuID = $row['ID'];
//         }
//     }
//     $fullname = $_SESSION['fullname'];
//     $phone = $_SESSION['phone'];
//     $dob = $_SESSION['dob'];
//     $idnumber = $_SESSION['idnumber'];
//     $matkhau = $_SESSION['matkhau'];
//     $gender = $_SESSION['gender'];
//     $email = $_SESSION['email'];
//     $thoigianDK = $_SESSION['thoigianDK'];
//     $ngayHienTai = $_SESSION['ngayHienTai'];
//     $ngayMoi = $_SESSION['ngayMoi'];
//     $tinh = $_SESSION['provinceInput'];
//     $huyen = $_SESSION['districtInput'];
//     $xa = $_SESSION['wardInput'];
//     $diachi = $_SESSION['Diachi'];
//     $orderId = $_GET['orderId'];
//     $thanhtoan = $_GET['amount'];
//     if (!$conn) {
//         die("Kết nối đến database thất bại: " . mysqli_connect_error());
//     } else {
//         $query3 = "SELECT * FROM su_dung_dich_vu WHERE SoCCCD='$idnumber' ";
//         $result3 = mysqli_query($conn, $query3);
//         if (mysqli_num_rows($result3) > 0) {
//             $query2 = "INSERT INTO su_dung_dich_vu (SoCCCD, IDGoiDichVu, NgayBatDau, NgayKetThuc,status, Da_xoa) VALUE ('$idnumber', '$goidichvuID', '$ngayHienTai', '$ngayMoi',1,0)";
//             mysqli_query($conn, $query2);
//             echo '<script type="text/javascript"> alert(\'ghi dùng dv xong\'); </script>';
//             if ($result5->num_rows > 0) {
//                 $row = $result5->fetch_assoc();
//                 $lastID = $row['ID'];
//                 $_SESSION['IDHD'] = $lastID;
//             }
//             echo '<script type="text/javascript"> alert(\'Đăng kí thành công. Hãy đăng nhập để quản lý gói cước\'); </script>';
//         } else {
//             $query = "INSERT INTO khach_hang (HoTen, CCCD, SDT, GioiTinh, NgaySinh, Email, Da_xoa) VALUES ('$fullname', '$idnumber', '$phone', '$gender', '$dob', '$email', 0)";
//             $query2 = "INSERT INTO su_dung_dich_vu (ID, SoCCCD, IDGoiDichVu, NgayBatDau, NgayKetThuc,status,Thanhtoan, Da_xoa) VALUE ('$orderId','$idnumber', '$goidichvuID', '$ngayHienTai', '$ngayMoi',0,1,0)";
//             $query4 = "INSERT INTO tai_khoan (Tai_khoan,Mat_khau,Role, Da_xoa) VALUES ('$email','$matkhau', 0 ,0)";
//             $queryDiaChi = "INSERT INTO dia_chi (IDKhachHang, IDgoicuoc, Tinh_TP, Huyen_Quan, Xa_Phuong, SoNha, Da_Xoa) VALUES ('$idnumber', '$goidichvuID', '$tinh', '$huyen', '$xa', '$diachi', 0)";

//             mysqli_query($conn, $query);
//             mysqli_query($conn, $query2);
//             mysqli_query($conn, $query4);
//             mysqli_query($conn, $queryDiaChi);
//             echo '<script type="text/javascript"> alert(\'Đăng kí thành công. Hãy đăng nhập để quản lý gói cước\'); </script>';
//         }
//     }
//     // echo 'Fullname: ' . $fullname . '<br>';
//     // echo 'Phone: ' . $phone . '<br>';
//     // echo 'Date of Birth: ' . $dob . '<br>';
//     // echo 'ID Number: ' . $idnumber . '<br>';
//     // echo 'Password: ' . $matkhau . '<br>';
//     // echo 'Gender: ' . $gender . '<br>';
//     // echo 'Email: ' . $email . '<br>';
//     // echo 'Registration Time: ' . $thoigianDK . '<br>';
//     // echo 'Current Date: ' . $ngayHienTai . '<br>';
//     // echo 'New Date: ' . $ngayMoi . '<br>';
//     // echo 'Province: ' . $tinh . '<br>';
//     // echo 'District: ' . $huyen . '<br>';
//     // echo 'Ward: ' . $xa . '<br>';
//     // echo 'Address: ' . $diachi . '<br>';
//     // echo 'Order ID: ' . $orderId . '<br>';
//     // echo 'Payment Amount: ' . $thanhtoan . '<br>';
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="CSS/gioithieu.css">
    <link rel="stylesheet" href="CSS/Slider.css">
</head>

<body>
    <?php

    include_once('Hot.php'); ?>
    <?php
    $sql_gioithieuSP = mysqli_query(
        $conn,
        'SELECT * FROM gioithieu WHERE ID = 1'
    );
    $sql_gioithieuTN = mysqli_query(
        $conn,
        'SELECT * FROM gioithieu WHERE ID = 3'
    );
    $sql_img_gt = mysqli_query(
        $conn,
        'SELECT * FROM image WHERE ID = 4'
    );
    $sql_img_tn = mysqli_query(
        $conn,
        'SELECT * FROM image WHERE ID = 8'
    );

    if ($row_img = mysqli_fetch_array($sql_img_gt)) {
        ?>
        <div class="ContainerGioithieu">
            <div class="thumb">
                <h2>
                    <img src="./img/<?php echo $row_img['Ten']; ?>" alt=" Introduce Image">
                    <span>
                        Giới Thiệu
                    </span>
                </h2>
            </div>
            <div class="gioithieu">
                <?php
                while ($row_gioithieuSP = mysqli_fetch_array($sql_gioithieuSP)) { ?>
                    <?php echo $row_gioithieuSP['GioiThieu'] ?>
                    <?php
                }
                ?>
            </div>
            <div class="thumb">
                <h2>
                    <?php
                    if ($row_img = mysqli_fetch_array($sql_img_tn)) {
                        ?><img src="./img/<?php echo $row_img['Ten']; ?>" alt="Introduce Image">
                        <?php
                    }
                    ?>
                    <span>
                        Tính năng
                    </span>
                </h2>
            </div>
            <div class="gioithieuTN">
                <?php
                while ($row_gioithieuTN = mysqli_fetch_array($sql_gioithieuTN)) { ?>
                    <?php echo $row_gioithieuTN['GioiThieu'] ?>
                    <?php
                }
                ?>
            </div>
        </div>
        <!-- <?php
        // Check if the user is logged in
        if (isset($_SESSION['username'])) {
            $loggedInUsername = $_SESSION['username'];
            echo "<p>Welcome, $loggedInUsername!</p>";
        }
        ?> -->
        <?php
    }
    ?>
    <div class="Gioithieu">

    </div>
    <?php
    include_once('Footer.php');
    ?>
</body>

</html>