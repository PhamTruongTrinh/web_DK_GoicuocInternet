<?php
include_once('db/connect.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/Navbar.css" />
</head>


<body>
    <nav>
        <?php
        $sql_logo = mysqli_query($conn, "SELECT * FROM image WHERE ID = 3");
        $row = mysqli_fetch_assoc($sql_logo);
        $logo_path = $row['Ten'];

        ?>
        <div class="logo">
            <a href="Home.php"><img src="./img/<?php echo $logo_path; ?>"></a>
        </div>
        <div class="Navbar" style="float: left">
            <ul>
                <li><a href="Home.php">
                        Home
                    </a>
                </li>
                <?php
                $sql_Danhmuc = mysqli_query($conn, 'SELECT * FROM menu WHERE Role = 0 && Da_xoa = 0 && Menu_Cha = 0');
                while ($row_Danhmuc = mysqli_fetch_array($sql_Danhmuc)) { ?>
                    <li><a href="<?php echo $row_Danhmuc['URL']; ?>">
                            <?php echo $row_Danhmuc['Ten_Menu'] ?>
                        </a></li>
                    <?php
                }
                if (isset($_SESSION['username'])) {
                    echo '<li><a href="Qly_goi_cuoc_User.php">Quản lý gói cước</a></li>';
                    echo '<li><a href="Logout.php">Đăng xuất</a></li>';
                } else {
                    echo '<li><a href="Login.php">Đăng nhập</a></li>';
                }
                ?>
            </ul>
        </div>

    </nav>
    <hr>
</body>

</html>