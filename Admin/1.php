<?php
include_once('../db/connect.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="../CSS/Navbar_admin.css" /> -->
    <style>
        /* Reset some default styles */
        body,
        ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        /* Style the navigation bar */
        nav {
            background-color: #333;
            color: white;
            text-align: center;
        }

        /* Style the navigation links */
        nav ul {
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
        }

        nav li {
            margin: 0 15px;
            position: relative;
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
        }

        /* Style the dropdown menu */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #333;
            min-width: 160px;
            z-index: 1;
        }

        .dropdown-content a {
            color: white;
            padding: 12px 16px;
            display: block;
            text-decoration: none;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
</head>


<body>
    <nav>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">About</a></li>
            <li class="dropdown">
                <a href="#">Services</a>
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
            <li><a href="#">Contact</a></li>
        </ul>
    </nav>
    <hr>
</body>

</html>