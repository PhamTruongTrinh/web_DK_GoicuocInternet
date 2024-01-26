<?php
include_once('db/connect.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
</head>
<?php
$sql_goicuoc = mysqli_query(
    $conn,
    'SELECT * FROM goi_dich_vu WHERE Da_xoa = 0 ORDER BY SoLuotDK DESC LIMIT 3'
); ?>

<body>
    <div class="sliderhot">
        <div class="slideshot">
            <?php
            while ($row_goicuoc = mysqli_fetch_array($sql_goicuoc)) { ?>
            <div class="containerhot">
                <img style="color: #333;
    text-align: center;
    width: 65px;
    margin-top: -19px;
    float: right;" src="img/hot-icon.gif">
                <h1>
                    <?php echo $row_goicuoc['TenGoiDichVu'] ?>
                </h1>
                <img src="./img/<?php echo $row_goicuoc['HinhAnh'] ?>">
                <span class="speed">
                    <?php echo $row_goicuoc['TocDo'] ?>
                </span>
                <div class="motahot">
                    <hr>
                    <p>
                        <?php echo $row_goicuoc['MoTa'] ?>
                    </p>
                </div>
                <button><a href="PackageDetails.php?Products_id=<?php echo $row_goicuoc['ID']; ?>">Đăng ký
                        ngay</a></button>
            </div>
            <?php
            } ?>
        </div>
    </div>
</body>

</html>