<?php
include_once('../db/connect.php');
include_once('Navbar_admin.php');
ob_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/Thongke.css">
    <title>Thống kê</title>
</head>

<body>
    <div class="body">
        <div class="Doanhthu">
            <div style="width: 100%">
                <h1>Tình hình doanh thu</h1>
            </div>
            <p>
                <?php
                $sql_DT = "SELECT SUM(TongTien) AS TongTienTong FROM su_dung_dich_vu WHERE DATE(Ngaybatdau) = CURDATE() AND Thanhtoan = 1";
                $result_DT = mysqli_query($conn, $sql_DT);
                $row_DT = mysqli_fetch_assoc($result_DT);
                $tongDoanhThu = $row_DT['TongTienTong'];
                $tongDoanhThuFormatted = number_format($tongDoanhThu, 0, ',', '.');
                echo "Trong hôm nay: " . $tongDoanhThuFormatted . "VNĐ";
                ?>
            </p>
            <p>
                <?php
                $sql_DT = "SELECT SUM(TongTien) AS TongTienTong FROM su_dung_dich_vu WHERE MONTH(Ngaybatdau) = MONTH(NOW()) AND YEAR(Ngaybatdau) = YEAR(NOW()) AND Thanhtoan = 1";
                $result_DT = mysqli_query($conn, $sql_DT);
                $row_DT = mysqli_fetch_assoc($result_DT);
                $tongDoanhThu = $row_DT['TongTienTong'];
                $tongDoanhThuFormatted = number_format($tongDoanhThu, 0, ',', '.');
                echo "Trong tháng này: " . $tongDoanhThuFormatted . "VNĐ";
                ?>
            </p>
            <p>
                <?php
                $sql_DT = "SELECT SUM(TongTien) AS TongTienTong FROM su_dung_dich_vu WHERE QUARTER(Ngaybatdau) = QUARTER(NOW()) AND YEAR(Ngaybatdau) = YEAR(NOW()) AND Thanhtoan = 1";
                $result_DT = mysqli_query($conn, $sql_DT);
                $row_DT = mysqli_fetch_assoc($result_DT);
                $tongDoanhThu = $row_DT['TongTienTong'];

                $tongDoanhThuFormatted = number_format($tongDoanhThu, 0, ',', '.');
                echo "Trong quí này: " . $tongDoanhThuFormatted . "VNĐ";
                ?>
            </p>
            <p>
                <?php
                $sql_DT = "SELECT SUM(TongTien) AS TongTienTong FROM su_dung_dich_vu WHERE YEAR(Ngaybatdau) = YEAR(NOW()) AND Thanhtoan = 1";
                $result_DT = mysqli_query($conn, $sql_DT);
                $row_DT = mysqli_fetch_assoc($result_DT);
                $tongDoanhThu = $row_DT['TongTienTong'];
                $tongDoanhThuFormatted = number_format($tongDoanhThu, 0, ',', '.');
                echo "Trong năm nay: " . $tongDoanhThuFormatted . "VNĐ";
                ?>
            </p>
        </div>
        <div class="Goicuoc">
            <div style="width: 100%">
                <h1>Doanh thu theo gói cước</h1>
            </div>
            <?php
            ?>
            <?php
            // Phần 1: Chọn cột từ bảng goi_dich_vu
            $sqlPart1 = "SELECT gdv.ID, gdv.TenGoiDichVu, gdv.GiaCuoc FROM goi_dich_vu gdv";

            // Phần 2: Kết hợp với bảng su_dung_dich_vu
            $sqlPart2 = "LEFT JOIN su_dung_dich_vu sddv ON gdv.ID = sddv.IDGoiDichVu AND sddv.Thanhtoan = 1";

            // Phần 3: Nhóm theo ID và TenGoiDichVu
            $sqlPart3 = "GROUP BY gdv.ID, gdv.TenGoiDichVu, gdv.GiaCuoc";

            $sql = $sqlPart1 . ' ' . $sqlPart2 . ' ' . $sqlPart3;
            $result = mysqli_query($conn, $sql);

            //Xử lý kết quả
            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $tenGoiDichVu = $row['TenGoiDichVu'];
                        $idGoiDichVu = $row['ID'];

                        // Kiểm tra 'GiaCuoc' có tồn tại trong mảng hay không
                        if (isset($row['GiaCuoc'])) {
                            //Đếm số lần lặp lại của ID trong bảng su_dung_dich_vu
                            $sqlCount = "SELECT COUNT(ID) AS SoLanLap FROM su_dung_dich_vu WHERE IDGoiDichVu = $idGoiDichVu AND Thanhtoan = 1";
                            $resultCount = mysqli_query($conn, $sqlCount);
                            $rowCount = mysqli_fetch_assoc($resultCount);
                            $soLanLap = $rowCount['SoLanLap'];

                            //Tính tổng tiền
                            $tongTien = $soLanLap * $row['GiaCuoc'] * 1000;
                            $tongDoanhThuFormatted = number_format($tongTien, 0, ',', '.');

                            ?>
                            <p>
                                <?php
                                echo "Gói cước: $tenGoiDichVu - Tổng tiền: $tongDoanhThuFormatted VNĐ<br>";
                                ?>
                            </p>
                            <?php
                        } else {
                            echo "Không có giá cuộc cho gói dịch vụ có ID: $idGoiDichVu<br>";
                        }
                    }
                } else {
                    echo "Không có dữ liệu.";
                }
            } else {
                echo "Lỗi truy vấn: " . mysqli_error($conn);
            }
            ?>
        </div>
    </div>

</body>

</html>