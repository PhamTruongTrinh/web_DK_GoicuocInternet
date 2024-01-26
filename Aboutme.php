<?php
include_once('db/connect.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Về chúng tôi</title>
</head>

<body>

    <?php
    include_once('Navbar.php');
    ?>
    <?php
    $sql_gioithieuCty = mysqli_query(
        $conn,
        'SELECT * FROM gioithieu WHERE Ten = "Gioithieucongty"'
    );
    ?>
    <div>
        <?php
        while ($row_gioithieuCty = mysqli_fetch_array($sql_gioithieuCty)) { ?>
            <div style="width: 90%; margin-left: 5%">
                <?php echo $row_gioithieuCty['GioiThieu'] ?>
            </div>
            <?php
        } ?>
    </div>
    <footer style="margin-top: 20%">
        <?php include_once('Footer.php');
        ?>
    </footer>
</body>

</html>