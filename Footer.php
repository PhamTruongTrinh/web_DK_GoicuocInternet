<?php
include_once('db/connect.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="CSS/Footer.css">
</head>

<body>
    <br>
    <br>
    <hr>
    <div class="containerFooter">
        <?php
        $sql_logo1 = mysqli_query($conn, "SELECT * FROM image WHERE ID = 3");
        $row1 = mysqli_fetch_assoc($sql_logo1);
        $logo_path1 = $row1['Ten'];

        $sql_lienhe = mysqli_query($conn, "SELECT * FROM image WHERE ID = 5");
        $row2 = mysqli_fetch_assoc($sql_lienhe);
        $logo_lh_path2 = $row2['Ten'];
        ?>
        <div class="containerlogo">
            <div class="logo">
                <br>
                <a href="Home.php"><img src="./img/<?php echo $logo_path1; ?>"></a>
            </div>
            <div class="lienhe">
                <a href="#"><img src="./img/<?php echo $logo_lh_path2; ?>"></a>
            </div>
        </div>
    </div>

</body>

</html>