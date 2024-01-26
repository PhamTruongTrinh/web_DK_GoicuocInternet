<?php
include_once('../db/connect.php');
include_once('Navbar_admin.php');

// Xử lý thêm mới bài viết
if (isset($_POST['thembaiviet'])) {
    $tenbaiviet = $_POST['tenbaiviet'];
    $noidung = $_POST['noidung'];

    $sql_insert_baivet = mysqli_query($conn, "INSERT INTO baiviet(TenBaiViet, NoiDung) values ('$tenbaiviet','$noidung')");
}

// Xử lý cập nhật bài viết
if (isset($_POST['capnhatbaiviet'])) {
    $id_update = $_POST['id_update'];
    $tenbaiviet = $_POST['tenbaiviet'];
    $noidung = $_POST['noidung'];

    $sql_update_bv = "UPDATE baiviet SET TenBaiViet='$tenbaiviet', NoiDung='$noidung' WHERE ID='$id_update'";
    mysqli_query($conn, $sql_update_bv);
    header('Location: Quanlybaiviet.php');
}

// Xử lý xóa bài viết
if (isset($_GET['xoa'])) {
    $id = $_GET['xoa'];
    $sql_xoa = mysqli_query($conn, "UPDATE baiviet SET Da_xoa = 1 WHERE ID='$id'");
}

// Xử lý tìm kiếm
$showAll = !isset($_GET['find_btn']) || empty($_GET['q']);

if (isset($_GET['find_btn'])) {
    $keyword = $_GET['q'];
    $sql_search = "SELECT * FROM baiviet WHERE Da_xoa = 0 AND TenBaiViet LIKE '%$keyword%'";
    $result_search = mysqli_query($conn, $sql_search);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Quản lý bài viết</title>
    <link href="../bootstrap.css" rel="stylesheet" type="text/css" media="all" />
    <link rel="stylesheet" href="../CSS/Qly_goi_cuoc.css" />
    <link rel="stylesheet" href="../CSS/Navbar_admin.css" />
    <script src="https://cdn.tiny.cloud/1/sdysnk2mdlrd84a5372jcqcncvp7384o9wnlhiiynsfaej8y/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });
    </script>
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



    <?php if (isset($_GET['capnhat']) && isset($_GET['capnhat_id'])) {
        $id_capnhat = $_GET['capnhat_id'];
        $sql_capnhat_baiviet = mysqli_query($conn, "SELECT * FROM baiviet WHERE Da_xoa = 0 AND ID='$id_capnhat'");
        $row_capnhat_baiviet = mysqli_fetch_array($sql_capnhat_baiviet);
        ?>

        <div style="width:80%; margin: auto;">
            <h3>Cập nhật bài viết</h3>
            <form action="" method="POST">
                <label>Tên bài viết</label>
                <input style="width: 100%;" type="text" class="form-control" name="tenbaiviet"
                    value="<?php echo $row_capnhat_baiviet['TenBaiViet']; ?>"><br>
                <input type="hidden" class="form-control" name="id_update"
                    value="<?php echo $row_capnhat_baiviet['ID']; ?>">
                <br>
                <label>Nội dung</label>
                <textarea class="tynymce" name="noidung" id="" cols="20"
                    rows="20"><?php echo $row_capnhat_baiviet['NoiDung']; ?></textarea><br>
                <input style="background-color: #1baf3d;" type="submit" name="capnhatbaiviet" value="Cập nhật"
                    class="btn btn-default">
            </form>
        </div>
    <?php } else {

        ?>
        <div style="width: 85%; margin: auto;">
            <div style="width: 100%">
                <?php if (isset($result_search)) { ?>
                    <div class="col-md-8">
                        <h2>Kết quả tìm kiếm cho "
                            <?php echo $keyword; ?>"
                        </h2>
                        <table style="width: 100%" class="table table-bordered">
                            <tr>
                                <th>Số thứ tự</th>
                                <th style="width: 100px">Tên bài viết</th>
                                <th>Nội dung</th>
                                <th>Quản lý</th>
                            </tr>

                            <?php
                            $i = 0;
                            while ($row_search = mysqli_fetch_array($result_search)) {
                                $i++;
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $i; ?>
                                    </td>
                                    <td>
                                        <?php echo $row_search['TenBaiViet']; ?>
                                    </td>
                                    <td style="max-height: 100px; overflow: hidden; text-overflow: ellipsis;">
                                        <?php echo $row_baiviet['NoiDung']; ?>
                                    </td>
                                    <td><a href="?xoa=<?php echo $row_search['ID']; ?>">Xóa</a> || <a
                                            href="Quanlybaiviet.php?capnhat=capnhat&capnhat_id=<?php echo $row_search['ID']; ?>">Cập
                                            nhật</a></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>

                <?php } else { ?>

                    <div class="col-md-8">
                        <div class="Quanly">
                            <a style="margin-right: 60px; margin-left: 104px;color: #00d900;" href="Quanlybaiviet.php">Tất cả
                                bài viết</a>
                            <a style="    color: #00d900;" href="test_tiny.php"> Thêm bài viết</a>
                            <br><br>
                        </div>
                        <?php
                        if ($showAll) {
                            // Hiển thị tất cả bài viết
                            echo '<h2>Danh sách bài viết</h2>'; ?>
                            <div class="col-md-8">
                                <?php
                                $sql_select_baiviet = mysqli_query($conn, "SELECT * FROM baiviet WHERE Da_xoa = 0 ORDER BY ID ASC");
                                ?>
                                <table style="width: 100%" class="table table-bordered">
                                    <tr>
                                        <th>Số thứ tự</th>
                                        <th style="width: 100px">Tên bài viết</th>
                                        <th>Nội dung</th>
                                        <th>Quản lý</th>
                                    </tr>
                                    <?php
                                    $i = 0;
                                    while ($row_baiviet = mysqli_fetch_array($sql_select_baiviet)) {
                                        $i++;
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo $i; ?>
                                            </td>
                                            <td>
                                                <?php echo $row_baiviet['TenBaiViet']; ?>
                                            </td>
                                            <td style="max-height: 100px; overflow: hidden; text-overflow: ellipsis;">
                                                <?php echo $row_baiviet['NoiDung']; ?>
                                            </td>
                                            <td><a href="javascript:void(0);"
                                                    onclick="confirmDelete(<?php echo $row_baiviet['ID']; ?>)">Xóa</a> || <a
                                                    href="Quanlybaiviet.php?capnhat=capnhat&capnhat_id=<?php echo $row_baiviet['ID']; ?>">Cập
                                                    nhật</a></td>

                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <th>Số thứ tự</th>
                                        <th style="width: 100px">Tên bài viết</th>
                                        <th>Nội dung</th>
                                        <th>Quản lý</th>
                                    </tr>
                                </table>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>

    <?php } ?>

    <script>
        function confirmDelete(id) {
            var result = confirm("Bạn có chắc chắn muốn xóa bài viết này?");
            if (result) {
                window.location.href = 'Quanlybaiviet.php?xoa=' + id;
            }
        }
    </script>

</body>

</html>