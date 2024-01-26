<?php
include_once('../db/connect.php');
include_once('Navbar_admin.php');

$showAllDangKy = !isset($_GET['find_btn']) || empty($_GET['q']);

if (isset($_GET['duyet']) && isset($_GET['IDGoiDichVu'])) {
    $id = $_GET['duyet'];
    $IDGoiDichVu = $_GET['IDGoiDichVu'];
    $sql_duyet = mysqli_query($conn, "UPDATE su_dung_dich_vu SET status = 1 WHERE SoCCCD='$id' AND IDGoiDichVu = '$IDGoiDichVu'");
}

if (isset($_GET['Xoa'])) {
    $id = $_GET['Xoa'];
    $query_get_idgoi = "SELECT IDGoiDichVu FROM su_dung_dich_vu WHERE SoCCCD='$id'";
    $result_get_idgoi = mysqli_query($conn, $query_get_idgoi);
    $row_get_idgoi = mysqli_fetch_array($result_get_idgoi);

    if ($row_get_idgoi) {
        $IDGoiDichVu = $row_get_idgoi['IDGoiDichVu'];
        $sql_duyet = mysqli_query($conn, "UPDATE su_dung_dich_vu SET Da_xoa = 1 WHERE SoCCCD='$id' AND IDGoiDichVu = '$IDGoiDichVu'");
    } else {
        echo "Không có dữ liệu";
    }
}

// Tìm kiếm
if (isset($_GET['find_btn'])) {
    $keywordDangKy = $_GET['q'];
    $sql_search_dang_ky = "SELECT su_dung_dich_vu.*, khach_hang.HoTen, goi_dich_vu.TenGoiDichVu 
    FROM su_dung_dich_vu 
    JOIN khach_hang ON su_dung_dich_vu.SoCCCD = khach_hang.CCCD
    JOIN goi_dich_vu ON su_dung_dich_vu.IDGoiDichVu = goi_dich_vu.ID
    WHERE su_dung_dich_vu.Da_xoa = 0 
    AND (khach_hang.HoTen LIKE '%$keywordDangKy%' OR su_dung_dich_vu.SoCCCD LIKE '%$keywordDangKy%' OR goi_dich_vu.TenGoiDichVu LIKE '%$keywordDangKy%') 
    ORDER BY su_dung_dich_vu.ID ASC";
    $result_search_dang_ky = mysqli_query($conn, $sql_search_dang_ky);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xét duyệt gói cước</title>
    <link rel="stylesheet" href="../CSS/Qly_goi_cuoc.css">
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
                if ($showAllDangKy) {
                    echo '<h2>Danh sách đăng ký gói cước</h2>';
                    $sql_select_goicuoc = mysqli_query($conn, "SELECT su_dung_dich_vu.*, khach_hang.HoTen FROM su_dung_dich_vu 
                JOIN khach_hang ON su_dung_dich_vu.SoCCCD = khach_hang.CCCD
                WHERE su_dung_dich_vu.Da_xoa = 0 ORDER BY su_dung_dich_vu.ID DESC");
                    ?>
                    <table style="width: 100%" class="table table-bordered">
                        <tr>
                            <th>Số thứ tự</th>
                            <th>Số CCCD</th>
                            <th>Họ và tên</th>
                            <th>Tên gói dịch vụ</th>
                            <th>Ngày bắt đầu</th>
                            <th>Ngày kết thúc</th>
                            <th>Địa chỉ lắp đặt</th>
                            <th>Thanh toán</th>
                            <th>Trạng thái</th>
                            <th>Phê duyệt</th>
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
                                    <?php echo $i ?>
                                </td>
                                <td>
                                    <?php echo $row_goicuoc['SoCCCD'] ?>
                                </td>
                                <td>
                                    <?php echo $row_goicuoc['HoTen']; ?>
                                </td>
                                <td>
                                    <?php
                                    $query3 = "SELECT TenGoiDichVu FROM goi_dich_vu WHERE ID= " . $row_goicuoc['IDGoiDichVu'];
                                    $result3 = mysqli_query($conn, $query3);
                                    $row_result3 = mysqli_fetch_array($result3);
                                    if ($row_result3) {
                                        $tenGoiDichVu = $row_result3['TenGoiDichVu'];
                                        echo $tenGoiDichVu;
                                    } else {
                                        echo "Không có dữ liệu";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php echo $row_goicuoc['NgayBatDau'] ?>
                                </td>
                                <td>
                                    <?php echo $row_goicuoc['NgayKetThuc'] ?>
                                </td>
                                <td>
                                    <?php
                                    $query4 = "SELECT Tinh_TP, Huyen_Quan, Xa_Phuong, SoNha FROM dia_chi WHERE IDgoicuoc = " . $row_goicuoc['IDGoiDichVu'] . " AND IDKhachHang = '" . $row_goicuoc['SoCCCD'] . "'";
                                    $result4 = mysqli_query($conn, $query4);
                                    $row_result4 = mysqli_fetch_array($result4);
                                    if ($row_result4) {
                                        $fullAddress = $row_result4['SoNha'] . ', ' . $row_result4['Xa_Phuong'] . ', ' . $row_result4['Huyen_Quan'] . ', ' . $row_result4['Tinh_TP'];

                                    } else {
                                        echo "Không có dữ liệu";
                                    }
                                    ?>
                                    <?php echo $fullAddress ?>
                                </td>
                                <td>
                                    <?php
                                    $query4 = "SELECT Thanhtoan FROM su_dung_dich_vu WHERE IDGoiDichVu = " . $row_goicuoc['IDGoiDichVu'] . " AND SoCCCD = '" . $row_goicuoc['SoCCCD'] . "'";
                                    $result4 = mysqli_query($conn, $query4);
                                    $row_result4 = mysqli_fetch_array($result4);
                                    if ($row_result4) {
                                        $Thanhtoan = $row_result4['Thanhtoan'];
                                        if ($Thanhtoan == 1) {
                                            echo "Đã thanh toán";
                                        } else {
                                            echo "Chưa thanh toán";
                                        }
                                    } else {
                                        echo "Không có dữ liệu";
                                    }
                                    ?>
                                </td>

                                <td>
                                    <?php if ($row_goicuoc['status'] == 0) {
                                        echo "Chưa phê duyệt"; ?>
                                    <td>
                                        <a
                                            href="?duyet=<?php echo $row_goicuoc['SoCCCD'] ?>&IDGoiDichVu=<?php echo $row_goicuoc['IDGoiDichVu'] ?>">Phê
                                            duyệt
                                            đăng ký</a>
                                    </td>
                                    <?php
                                    } else if ($row_goicuoc['status'] == 1) {
                                        echo "Đã phê duyệt";
                                    } else if ($row_goicuoc['status'] == 2) {
                                        echo "Đã quá hạn";
                                        ?>
                                            <td>
                                                <a
                                                    href="?Xoa=<?php echo $row_goicuoc['SoCCCD'] ?>&IDGoiDichVu=<?php echo $row_goicuoc['IDGoiDichVu'] ?>">Xóa</a>
                                            </td>
                                    <?php
                                    }
                                    ?>
                                </td>

                            </tr>

                            <?php
                        }
                        ?>
                        <tr>
                            <th>Số thứ tự</th>
                            <th>Số CCCD</th>
                            <th>Họ và tên</th>
                            <th>Tên gói dịch vụ</th>
                            <th>Ngày bắt đầu</th>
                            <th>Ngày kết thúc</th>
                            <th>Địa chỉ lắp đặt</th>
                            <th>Thanh toán</th>
                            <th>Trạng thái</th>
                            <th>Phê duyệt</th>
                        </tr>
                    </table>
                    <?php
                } else {
                    echo '<h2>Kết quả tìm kiếm cho "' . $keywordDangKy . '"</h2>';
                    if (isset($result_search_dang_ky)) {
                        echo '<table style="width: 100%" class="table table-bordered">
                    <tr>
                        <th>Số thứ tự</th>
                        <th>Số CCCD</th>
                        <th>Họ và tên</th>
                        <th>Tên gói dịch vụ</th>
                        <th>Ngày bắt đầu</th>
                        <th>Ngày kết thúc</th>
                        <th>Trạng thái</th>
                        <th>Phê duyệt</th>
                    </tr>';
                        $i = 0;
                        while ($row_search_dang_ky = mysqli_fetch_array($result_search_dang_ky)) {
                            $i++;
                            echo '<tr>
        <td>' . $i . '</td>
        <td>' . $row_search_dang_ky['SoCCCD'] . '</td>
        <td>' . $row_search_dang_ky['HoTen'] . '</td>
        <td>' . $row_search_dang_ky['TenGoiDichVu'] . '</td> 
        <td>' . $row_search_dang_ky['NgayBatDau'] . '</td>
        <td>' . $row_search_dang_ky['NgayKetThuc'] . '</td>
        <td>';
                            if ($row_search_dang_ky['status'] == 0) {
                                echo 'Chưa phê duyệt';
                            } else if ($row_search_dang_ky['status'] == 1) {
                                echo 'Đã phê duyệt';
                            } else if ($row_search_dang_ky['status'] == 2) {
                                echo 'Đã quá hạn';
                            }
                            echo '</td>
        <td>';
                            if ($row_search_dang_ky['status'] == 0) {
                                echo '<a href="?duyet=' . $row_search_dang_ky['SoCCCD'] . '">Phê duyệt đăng ký</a>';
                            } else if ($row_search_dang_ky['status'] == 2) {
                                echo '<a href="?Xoa=' . $row_search_dang_ky['SoCCCD'] . '&IDGoiDichVu=' . $row_search_dang_ky['IDGoiDichVu'] . '">Xóa</a>';
                            }
                            echo '</td>
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
</body>

</html>