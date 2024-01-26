<?php
include_once('db/connect.php');
include_once('Navbar.php');
?>
<nav class="Nav-search">
    <form class="search" action="#" method="get" style="float: right">
        <input type="search" name="q" placeholder="Nhập từ khóa..."
            value="<?php echo isset($keyword) ? $keyword : ''; ?>">
        <button style="margin-right: 5px; margin-left: 10px; width: 50px; height: 32px;" name="find_btn"
            type="submit">Tìm</button>
    </form>
</nav>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="CSS/Products.css">
    <link rel="stylesheet" href="CSS/Footer.css">
</head>

<?php
// Kiểm tra nếu biểu mẫu tìm kiếm được gửi
$sql_goicuoc = null;
if (isset($_GET['find_btn']) && isset($_GET['q'])) {
    $search_term = $_GET['q'];
    $query = "SELECT * FROM goi_dich_vu WHERE Da_xoa = 0 AND TenGoiDichVu LIKE '%$search_term%' ORDER BY GiaCuoc ASC";
} else {
    $query = "SELECT * FROM goi_dich_vu WHERE Da_xoa = 0 ORDER BY GiaCuoc ASC";
}

$sql_goicuoc = mysqli_query($conn, $query);

if ($sql_goicuoc === false) {
    // Xử lý lỗi khi truy vấn không thành công
    die('Query error: ' . mysqli_error($conn));
}

// Kiểm tra xem có bản ghi nào hay không
if (mysqli_num_rows($sql_goicuoc) > 0) {
    ?>
    <div class="containerParent clearfix">
        <div class="containerParent">
            <?php
            while ($row_goicuoc = mysqli_fetch_array($sql_goicuoc)) {
                ?>
                <div class="container">
                    <h1>
                        <?php echo $row_goicuoc['TenGoiDichVu'] ?>
                    </h1>
                    <div class="img_download">
                        <img src="./img/<?php echo $row_goicuoc['HinhAnh'] ?>">
                    </div>
                    <div class="speed">
                        <p>
                            <?php echo $row_goicuoc['TocDo'] ?>
                        </p>
                    </div>
                    <div class="mota">
                        <?php echo $row_goicuoc['MoTa'] ?>
                    </div>
                    <a href="PackageDetails.php?Products_id=<?php echo $row_goicuoc['ID']; ?>">
                        Đăng ký ngay
                    </a>
                </div>
                <?php
            } ?>
        </div>
    </div>

    <?php
} else {
    // Không có bản ghi, thực hiện xử lý khi không tìm thấy
    header('Location: Products.php');
}

?>

<body>

    <footer>
        <?php include_once('Footer.php'); ?>
    </footer>
</body>

</html>