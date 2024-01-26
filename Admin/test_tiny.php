<!DOCTYPE html>
<html lang="en">
<!--PHP--------------------------------------------------------->
<?php
include_once('../db/connect.php');
?>

<?php
if (isset($_POST['thembaiviet'])) {
    $tenbaiviet = $_POST['tenbaiviet'];
    $noidung = $_POST['noidung'];

    $sql_insert_baivet = mysqli_query($conn, "INSERT INTO baiviet(TenBaiViet, NoiDung) values ('$tenbaiviet','$noidung')");
    if ($sql_insert_baivet) {
        header('Location: Quanlybaiviet.php');
    } else {
        echo "Có lỗi";
    }
}
?>
<!----------------------------------------------------------->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/btl.css" />
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
    <div class="head">
        <?php
        include_once('Navbar_admin.php');
        ?>
    </div>
    <a style="margin-right: 20px; margin-left: 204px; color: #00d900; font-size: 22px;
    font-weight: 600;
    text-decoration: none;" href="Quanlybaiviet.php">Tất cả bài viết</a>
    <a style="color: #00d900; font-size: 22px;
    font-weight: 600;
    text-decoration: none;" href="test_tiny.php">Thêm bài viết</a>
    </div>
    </div>
    <br><br>
    <form class="form1" action="" method="POST" enctype="multipart/form-data" style="width: 70%; margin: 0 auto;">
        <label>Tên bài viết</label>
        <input style="width: 100%" type="text" class="form-control" name="tenbaiviet" placeholder="Tên bài viết">
        <h1>Nội dung bài viết</h1>
        <textarea style="width: 100%" class="tynymce" name="noidung" id="" cols="20" rows="20"> </textarea>
        <br>
        <input style="background-color: #1baf3d;" type="submit" name="thembaiviet" value="Thêm bài viết"
            class="btn btn-default">
    </form>
</body>


</html>