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
<?php

if (isset($_GET['baiviet_id'])) {
    $id_baiviet = $_GET['baiviet_id'];
    $sql_baiviet = mysqli_query($conn, "SELECT * FROM baiviet WHERE ID='$id_baiviet'");
    $row_baiviet = mysqli_fetch_array($sql_baiviet);
    ?>
    <div class="noidung">
        <h1>
            <?php echo $row_baiviet['TenBaiViet']; ?>
        </h1>
        <?php echo $row_baiviet['NoiDung']; ?>
    </div>

    <?php
} else {
    ?>
    <script>
        alert(Lỗi);
    </script>
    <?php
}

$showAll = !isset($_GET['find_btn']) || empty($_GET['q']);

if (isset($_GET['find_btn'])) {
    $keyword = $_GET['q'];
    if ($keyword != "") {
        $sql_search = "SELECT * FROM baiviet WHERE Da_Xoa = 0 AND TenBaiViet LIKE '%$keyword%' OR Da_Xoa = 0 AND Role LIKE '%$keyword%'";
        $result_search = mysqli_query($conn, $sql_search);
    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hỗ trợ</title>
    <link rel="stylesheet" href="./CSS/hotro.css">
</head>

<body>

    <br><br>
    <div style="width: 85%; margin: auto;">
        <div style="width: 100%">
            <?php if (isset($result_search)) { ?>
                <div class="noidung">
                    <h2>Kết quả tìm kiếm cho "
                        <?php echo $keyword; ?>"
                    </h2>
                    <?php
                    $i = 0;
                    while ($row_search = mysqli_fetch_array($result_search)) {
                        $i++;
                        ?>
                        <a href="HoTro.php?baiviet_id=<?php echo $row_search['ID']; ?>">
                            <p>
                                <?php echo $row_search['TenBaiViet'] ?>
                            </p>
                        </a>
                        <?php
                    } ?>
                    <p style="color: red; font-weight: 600;">**Nếu không thể khắc phục vấn đề. Vui lòng liên hệ Hotline:
                        0123456789
                    </p>
                </div>
            </div>
        </div>
        <?php
            }
            if ($showAll) { ?>
        <div class="noidung">
            <h2>Câu hỏi thường gặp</h2>
            <?php
            $sql_select_baiviet = mysqli_query($conn, "SELECT * FROM baiviet WHERE Da_Xoa = 0 ORDER BY ID ASC");
            $i = 0;
            while ($row_baiviet = mysqli_fetch_array($sql_select_baiviet)) {
                $i++;
                ?>
                <a href="HoTro.php?baiviet_id=<?php echo $row_baiviet['ID']; ?>">
                    <p>
                        <?php echo $row_baiviet['TenBaiViet'] ?>
                    </p>
                </a>
                <?php
            } ?>
            <p style="color: red; font-weight: 600;">**Nếu không thể khắc phục vấn đề. Vui lòng liên hệ Hotline:
                0123456789
            </p>
        </div>
    <?php } ?>
    <footer>
        <?php include_once('Footer.php');
        ?>
    </footer>
</body>

</html>