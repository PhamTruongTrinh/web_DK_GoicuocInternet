<?php
include_once('../db/connect.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/Navbar_admin.css" />
</head>


<body>
    <nav>
        <?php
        $sql_logo = mysqli_query($conn, "SELECT * FROM image WHERE ID = 3");
        $row = mysqli_fetch_assoc($sql_logo);
        $logo_path = $row['Ten'];
        ?>
        <div class="logo">
            <a href="duyetdangky.php"><img src="../img/<?php echo $logo_path; ?>"></a>
        </div>
        <div class="Navbar">
            <ul>
                <li class="dropdown">
                    <a style="margin-left: 30px" name="qly">Quản lý</a>
                    <div class="dropdown-content">
                        <?php
                        $sql_Danhmuc = mysqli_query($conn, 'SELECT * FROM menu WHERE Role = 1 AND Da_xoa = 0 AND ID != 19 AND ID != 20');
                        while ($row_Danhmuc = mysqli_fetch_array($sql_Danhmuc)) {
                            ?>
                            <a href="<?php echo $row_Danhmuc['URL']; ?>">
                                <?php echo $row_Danhmuc['Ten_Menu'] ?>
                            </a>
                        <?php }
                        ?>
                    </div>
                </li>
            </ul>
        </div>
        <a style="margin-left: 100px" href="duyetdangky.php">
            Xét duyệt đăng ký
        </a>
        <a style="margin-left: 50px" href="DoanhThu.php">
            Thống kê doanh thu
        </a>
        <?php
        if (isset($_SESSION['username'])) {
            // Nếu người dùng đã đăng nhập, hiển thị nút Đăng xuất
            echo '<li style = "float: left;
    margin-right: 255px;"><a href="../Logout.php">Đăng xuất</a></li>';
        } else {
            // Nếu người dùng chưa đăng nhập, hiển thị nút Đăng nhập
            echo '<li style = "float: left;
    margin-right: 255px;"><a href="../Login.php">Đăng nhập</a></li>';
        } ?>
    </nav>
    <hr>
</body>

</html>