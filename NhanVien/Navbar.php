<?php
include_once('../db/connect.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/Navbar.css" />
</head>


<body>
    <nav>
        <?php
        $sql_logo = mysqli_query($conn, "SELECT * FROM image WHERE ID = 3");
        $row = mysqli_fetch_assoc($sql_logo);
        $logo_path = $row['Ten'];

        ?>
        <div class="logo">
            <a href="Home.php"><img src="../img/<?php echo $logo_path; ?>"></a>
        </div>
        <div class="Navbar" style="float: left">
            <ul>
                <?php
                if (isset($_SESSION['username'])) {
                    ?>
                    <form action="" method="POST">
                        <input type="submit" name="Dangxuat" value="Đăng xuất">
                    </form>
                    <?php
                }
                if (isset($_POST['Dangxuat'])) {
                    session_unset();
                    header("Location: ../Home.php");
                }
                ?>
            </ul>
        </div>

    </nav>
    <hr>
</body>

</html>