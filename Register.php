<?php
include_once('db/connect.php');
// đăng kí ok
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Đăng nhập</title>
        <link rel="stylesheet" href="CSS/Login.css" />
    </head>

<body>
    <?php

    if (isset($_POST['Register'])) {
        $username = $_POST['username_input'];
        $password = $_POST['password_input'];
        $repassword = $_POST['repassword_input'];
        $send_password = md5($password);

        if ($password == null || $repassword == null || $username == null) {

            echo '<script type ="text/javascript"> alert (\'Nhập đầy đủ thông tin đăng ký\'); </script>';
        } else {
            if ($password == $repassword) {
                $db = mysqli_connect("$hostname", "$username_", "$password_", "$database");
                if (mysqli_connect_errno()) {
                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                    exit();
                }
                $query = "SELECT * FROM tai_khoan WHERE Tai_Khoan='$username'";
                $result = mysqli_query($db, $query);
                if (mysqli_num_rows($result) > 0) {
                    echo '<script type ="text/javascript"> alert (\'Username đã tồn tại\'); </script>';
                } else {
                    $query = "INSERT INTO tai_khoan (Tai_Khoan, Mat_khau, Role) VALUES ('$username', '$send_password', 0)";
                    mysqli_query($db, $query);
                    header("Location: Login.php");
                }
            }
            // } else {
            //     echo '<script type ="text/javascript"> alert (\'Xác nhận mật khẩu không đúng\'); </script>';
            // }
        }
    }
    ?>
    <section>
        <div class="form-box">
            <div class="form-value">
                <form id='Register' class='input-group-login' action="Register.php" method="POST" role="form"
                    onsubmit="return validateEmail()">
                    <h2>Đăng kí</h2>
                    <div class="inputbox">
                        <ion-icon name="mail-outline"></ion-icon>
                        <input type="Username" name="username_input" id="username_input" required>
                        <label for="">Email</label>
                    </div>
                    <div class="inputbox">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input type="password" name="password_input" id="password_input" required>
                        <label for="">Mật khẩu</label>
                    </div>
                    <div class="inputbox">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input type="password" name="repassword_input" id="repassword_input" required>
                        <label for="">Nhập lại mật khẩu</label>
                    </div>
                    <button name="Register" type="submit">Đăng kí</button>
                    <div class="Login">
                        <p>Đã có tài khoản? <a href="Login.php">Đăng nhập</a></p>
                    </div>
                </form>
            </div>
        </div>
    </section>
</body>
<script>
    function validateEmail() {
        var emailInput = document.getElementById("username_input").value;
        var password = document.getElementById("password_input").value;
        var repassword = document.getElementById("repassword_input").value;
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (password != "" && repassword != "" && emailInput != "") {
            if (!emailRegex.test(emailInput)) {
                alert("Địa chỉ email không hợp lệ!");
                return false;
            } else if (password != repassword) {
                alert("Mật khẩu không khớp");
                return false;
            }
        }
        return true;
    }
</script>

</html>