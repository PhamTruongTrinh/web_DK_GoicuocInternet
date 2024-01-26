<?php
include_once('../db/connect.php');
include_once('Navbar_admin.php');
?>
<?php


if (isset($_POST['themgoicuoc'])) {
    $tengoicuoc = $_POST['TenGoiDichVu'];
    $hinhanh = $_FILES['hinhanh']['name'];
    $chitiet = $_POST['chitiet'];
    $path = '../img/';

    $hinhanh_tmp = $_FILES['hinhanh']['tmp_name'];
    $sql_insert_product = mysqli_query($conn, "INSERT INTO goi_dich_vu(TenGoiDichVu, HinhAnh, TocDo, Mota, GiaCuoc) values ('$tengoicuoc','$hinhanh','$tocdo','$mota','$giacuoc')");
    move_uploaded_file($hinhanh_tmp, $path . $hinhanh);
} elseif (isset($_POST['capnhatgoicuoc'])) {
    $id_update = $_POST['id_update'];
    $tengoicuoc = $_POST['tengoicuoc'];
    $mota = $_POST['mota'];
    $tocdo = $_POST['tocdo'];
    $giacuoc = $_POST['giacuoc'];
    $hinhanh = $_FILES['hinhanh']['name'];
    $hinhanh_tmp = $_FILES['hinhanh']['tmp_name'];

    $path = '../img/';
    if ($hinhanh == '') {
        $sql_update_image = "UPDATE goi_dich_vu SET TenGoiDichVu='$tengoicuoc',TocDo='$tocdo',Mota='$mota',GiaCuoc='$giacuoc' WHERE ID='$id_update'";
    } else {
        move_uploaded_file($hinhanh_tmp, $path . $hinhanh);
        $sql_update_image = "UPDATE goi_dich_vu SET TenGoiDichVu='$tengoicuoc', HinhAnh='$hinhanh',TocDo='$tocdo',Mota='$mota',GiaCuoc='$giacuoc' WHERE ID='$id_update'";
    }
    mysqli_query($conn, $sql_update_image);
    header('Location: Qly_goi_cuoc.php');
}
?>
<?php
if (isset($_GET['xoa'])) {
    $id = $_GET['xoa']; //da_xoa = 0 chưa xóa status != 2 chưa hết hạn
    $querySelect = "SELECT * FROM su_dung_dich_vu WHERE IDGoiDichVu= '$id' AND Da_xoa = 0 AND status != 2";
    $resultSelect = mysqli_query($conn, $querySelect);
    if ($resultSelect && mysqli_num_rows($resultSelect) > 0) {
        echo '<script type="text/javascript"> alert(\'Gói cước đang được khách hàng sử dụng. Không thể xóa!\'); </script>';
    } else {
        echo '<script>
            function confirmDelete() {
                return confirm("Có chắc chắn xóa không");
            }
          </script>';
        $sql_xoa = mysqli_query($conn, "UPDATE goi_dich_vu SET Da_xoa = 1 WHERE ID='$id'");

        if ($sql_xoa) {
            echo '<script type="text/javascript"> alert(\'Xóa thành công!\'); </script>';
        } else {
            echo '<script type="text/javascript"> alert(\'Xóa không thành công!\'); </script>';
        }
    }
}


// Khai báo biến để kiểm soát hiển thị tất cả hoặc kết quả tìm kiếm
$showAllGoiCuoc = !isset($_GET['find_btn']) || empty($_GET['q']);

// Xử lý tìm kiếm nếu có từ khóa
if (isset($_GET['find_btn'])) {
    $keywordGoiCuoc = $_GET['q'];
    $sql_search_goi_cuoc = "SELECT * FROM goi_dich_vu WHERE Da_xoa = 0 AND (TenGoiDichVu LIKE '%$keywordGoiCuoc%' OR TocDo LIKE '%$keywordGoiCuoc%' OR GiaCuoc LIKE '%$keywordGoiCuoc%') ORDER BY ID ASC";
    $result_search_goi_cuoc = mysqli_query($conn, $sql_search_goi_cuoc);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Quản lý gói cước</title>
    <link href="../bootstrap.css" rel="stylesheet" type="text/css" media="all" />
    <link rel="stylesheet" href="../CSS/Qly_goi_cuoc.css" />
    <link rel="stylesheet" href="../CSS/Navbar_admin.css" />
    <script>
        <script src="https://cdn.tiny.cloud/1/sdysnk2mdlrd84a5372jcqcncvp7384o9wnlhiiynsfaej8y/tinymce/5/tinymce.min.js"
            referrerpolicy="origin" >
    </script>
    <script>
            tinymce.init({
                selector: 'textarea',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    });
    </script>
    <script>
            function previewImage(input) {
            var preview = document.getElementById('preview');
            var file = input.files[0];
            var reader = new FileReader();

            reader.onload = function (e) {
                preview.src = e.target.result;
            };

            if (file) {
                reader.readAsDataURL(file);
            }
        }
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
    <br><br>
    <div>
        <a style="margin-right: 20px; margin-left: 120px; font-size: 22px;
    font-weight: 600;
        color: #00d900;
    text-decoration: none;" href="Qly_goi_cuoc.php">Tất cả gói cước</a>
        <a style="font-size: 22px;
    font-weight: 600;
        color: #00d900;
    text-decoration: none;" href="Qly_goi_cuoc.php?add=true">Thêm gói cước</a>
        <br>
        <br>
    </div>
    <div style="width: 60%; margin: auto;">
        <div style="width: 100%">
            <?php
            if (isset($_GET['add']) == 'true') {
                ?>
                <div style="width:100%">
                    <h3>Thêm mới gói cước</h3>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <label>Tên gói cước</label>
                        <input type="text" class="form-control" name="tengoicuoc"><br>
                        <br>

                        <label>Tốc độ</label>
                        <input type="text" class="form-control" name="tocdo"><br>
                        <br>
                        <label>Giá cước</label>
                        <br>
                        <input style="width: 55%" type="text" class="form-control" name="giacuoc"> .000 VNĐ<br>
                        <br>
                        <label>Hình ảnh</label>
                        <input type="file" class="form-control" name="hinhanh" onchange="previewImage(this)"><br>
                        <img id="preview" src="../img/" height="80" width="80"><br>
                        <br>
                        <label>Mô tả gói dịch vụ</label>
                        <br>
                        <textarea class="tynymce" name="mota" id="" cols="20" rows="20" style="width"> </textarea>
                        <br>
                        </select><br>
                        <input style="background-color: #1baf3d;" type="submit" name="capnhatgoicuoc" value="Thêm"
                            class="btn btn-default">
                    </form>
                </div>
                <?php
            } else {
                if (isset($_GET['capnhat']) == 'capnhat') {
                    $id_capnhat = $_GET['capnhat_id'];
                    $sql_capnhat = mysqli_query($conn, "SELECT * FROM goi_dich_vu WHERE Da_xoa = 0");
                    $row_capnhat = mysqli_fetch_array($sql_capnhat);
                    $id_category_1 = $row_capnhat['ID'];
                    ?>
                    <div style="width:100%">
                        <h3>Cập nhật gói cước</h3>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <label>Tên gói cước</label>
                            <input type="text" class="form-control" name="tengoicuoc"
                                value="<?php echo $row_capnhat['TenGoiDichVu'] ?>"><br>
                            <input type="hidden" class="form-control" name="id_update" value="<?php echo $row_capnhat['ID'] ?>">
                            <br>
                            <label>Hình ảnh</label>
                            <input type="file" class="form-control" name="hinhanh"
                                value="<?php echo $row_capnhat['HinhAnh'] ?>"><br>
                            <img src="../img/<?php echo $row_capnhat['HinhAnh'] ?>" height="80" width="80"><br>
                            <br>
                            <label>Tốc độ</label>
                            <input type="text" class="form-control" name="tocdo"
                                value="<?php echo $row_capnhat['TocDo'] ?>"><br>
                            <br>
                            <label>Giá cước</label>
                            <input style="width: 50px" type="text" class="form-control" name="giacuoc"
                                value="<?php echo $row_capnhat['GiaCuoc'] ?>"> .000 VNĐ<br>
                            <br>
                            <label>Mô tả gói dịch vụ</label>
                            <textarea class="tynymce" name="mota" id="" cols="20"
                                rows="20"><?php echo $row_capnhat['MoTa'] ?> </textarea>
                            <br>
                            </select><br>
                            <input style="background-color: #1baf3d;" type="submit" name="capnhatgoicuoc" value="Cập nhật"
                                class="btn btn-default">
                        </form>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="col-md-8">
                        <?php
                        if ($showAllGoiCuoc) {
                            // Hiển thị tất cả thông tin gói cước
                            echo '<h2>Danh sách gói cước</h2>';
                            $sql_select_goi_cuoc = mysqli_query($conn, "SELECT * FROM goi_dich_vu WHERE Da_xoa = 0 ORDER BY SoLuotDK DESC");
                            ?>
                            <table class="table table-bordered ">
                                <tr>
                                    <th>Mã gói cước</th>
                                    <th>Tên gói cước</th>
                                    <th>Thumbnail</th>
                                    <th>Tốc độ</th>
                                    <th>Chi tiết gói cước</th>
                                    <th>Giá</th>
                                    <th>Số lượt đăng ký</th>
                                    <th>Quản lý</th>
                                </tr>
                                <?php
                                $i = 0;
                                while ($row_goicuoc = mysqli_fetch_array($sql_select_goi_cuoc)) {
                                    $i++;
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $row_goicuoc['ID'] ?>
                                        </td>
                                        <td>
                                            <?php echo $row_goicuoc['TenGoiDichVu'] ?>
                                        </td>
                                        <td>
                                            <img src="../img/<?php echo $row_goicuoc['HinhAnh'] ?>" height="70" width="70">
                                        </td>

                                        <td>
                                            <?php echo $row_goicuoc['TocDo'] ?>
                                        </td>
                                        <td>
                                            <?php echo $row_goicuoc['MoTa'] ?>
                                        </td>
                                        <td>
                                            <?php echo $row_goicuoc['GiaCuoc'] ?>000 VNĐ
                                        </td>
                                        <td>
                                            <?php echo $row_goicuoc['SoLuotDK'] ?>
                                        </td>
                                        <td><a style="" href="?xoa=<?php echo $row_goicuoc['ID'] ?>">Xóa</a> || <a
                                                href="qly_goi_cuoc.php?capnhat=capnhat&capnhat_id=<?php echo $row_goicuoc['ID'] ?>">Cập
                                                nhật</a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <tr>
                                    <th>Mã gói cước</th>
                                    <th>Tên gói cước</th>
                                    <th>Thumbnail</th>
                                    <th>Tốc độ</th>
                                    <th>Chi tiết gói cước</th>
                                    <th>Giá</th>
                                    <th>Số lượt đăng ký</th>
                                    <th>Quản lý</th>
                                </tr>
                            </table>
                            <?php
                        } else {
                            // Hiển thị kết quả tìm kiếm
                            echo '<h2>Kết quả tìm kiếm cho "' . $keywordGoiCuoc . '"</h2>';
                            if (isset($result_search_goi_cuoc)) {
                                echo '<table class="table table-bordered ">
                    <tr>
                        <th>Mã gói cước</th>
                        <th>Tên gói cước</th>
                        <th>Thumbnail</th>
                        <th>Tốc độ</th>
                        <th>Chi tiết gói cước</th>
                        <th>Giá</th>
                        <th>Số lượt đăng ký</th>
                        <th>Quản lý</th>
                    </tr>';

                                $i = 0;
                                while ($row_search_goi_cuoc = mysqli_fetch_array($result_search_goi_cuoc)) {
                                    $i++;
                                    echo '<tr>
                        <td>' . $row_search_goi_cuoc['ID'] . '</td>
                        <td>' . $row_search_goi_cuoc['TenGoiDichVu'] . '</td>
                        <td><img src="../img/' . $row_search_goi_cuoc['HinhAnh'] . '" height="70" width="70"></td>
                        <td>' . $row_search_goi_cuoc['TocDo'] . '</td>
                        <td>' . $row_search_goi_cuoc['MoTa'] . '</td>
                        <td>' . $row_search_goi_cuoc['GiaCuoc'] . '000 VNĐ</td>
                        <td>' . $row_search_goi_cuoc['SoLuotDK'] . '</td>
                        <td><a href="?xoa=' . $row_search_goi_cuoc['ID'] . '">Xóa</a> || <a href="qly_goi_cuoc.php?capnhat=capnhat&capnhat_id=' . $row_search_goi_cuoc['ID'] . '">Cập nhật</a></td>
                      </tr>';
                                }

                                echo '</table>';
                            } else {
                                echo "<p>Không có kết quả nào được tìm thấy.</p>";
                            }
                        }
                        ?>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>

    <script>
            function confirmDelete() {
        return confirm("Bạn có chắc chắn muốn xóa gói cước này?");
    }
    </script>
</body>

</html>