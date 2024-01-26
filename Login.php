<?php
include_once('db/connect.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Login</title>
    <link rel="stylesheet" href="CSS/Login.css" />
</head>

<body>
    <?php
    if (isset($_POST['login'])) {
        $username = $_POST['username_input'];
        $password = md5($_POST['password_input']);
        if ($password == null || $username == null) {
            echo '<script type ="text/javascript"> alert (\'Nhập đầy đủ thông tin đăng nhập\'); </script>';
        } else {
            // Kiểm tra định dạng email
            if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
                echo '<script type ="text/javascript"> alert (\'Địa chỉ email không hợp lệ\'); </script>';
            } else {
                if (mysqli_connect_errno()) {
                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                    exit();
                }
                if (isset($username) && ($password)) {
                    $query = "SELECT * FROM tai_khoan WHERE Tai_khoan ='$username' AND Mat_khau='$password'";
                    $result = mysqli_query($conn, $query);
                    // Kiểm tra kết quả trả về 
                    if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $role = $row['Role'];
                        if ($role == 1) {
                            session_start();
                            $_SESSION['username'] = $username;
                            header("Location: Admin/duyetdangky.php");
                        }
                        if ($role == 3) {
                            session_start();
                            $_SESSION['username'] = $username;
                            header("Location: NhanVien/Home.php");
                        }
                        if ($role == 0) {
                            session_start();
                            $_SESSION['username'] = $username;
                            header("Location: Home.php");
                        }
                    } else {
                        echo '<script type ="text/javascript"> alert (\'Tên đăng nhập hoặt mật khẩu không đúng\'); </script>';
                    }
                    mysqli_close($conn);
                }
            }
        }
    }
    ?>
    <section>
        <div class="form-box">
            <div class="form-value">
                <form id='login' class='input-group-login' action="login.php" method="POST" role="form"
                    onsubmit="return validateEmail()">
                    <h2>Đăng nhập</h2>
                    <div class="inputbox">
                        <ion-icon name="mail-outline"></ion-icon>
                        <input type="text" name="username_input" id="username_input" required>
                        <label for="">Email</label>
                    </div>
                    <div class="inputbox">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input type="password" name="password_input" id="password_input" required>
                        <label for="">Mật khẩu/Số CCCD</label>
                        <br>
                        <span style="color: white; font-weight: 600" id="togglePassword"
                            onclick="togglePasswordVisibility()">Show password</span>
                    </div>

                    <button name="login" type="submit">Đăng nhập</button>
                </form>
            </div>
        </div>
    </section>

    <script>
        function validateEmail() {
            var emailInput = document.getElementById("username_input").value;
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (emailInput != "") {
                if (!emailRegex.test(emailInput)) {
                    alert("Địa chỉ email không hợp lệ!");
                    return false;
                }
            } else {
                alert("Nhập địa chỉ mail");
                return false;
            }
            return true;
        }

        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password_input");
            var toggleButton = document.getElementById("togglePassword");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleButton.innerText = "Hide password";
            } else {
                passwordInput.type = "password";
                toggleButton.innerText = "Show password";
            }
        }
    </script>
</body>

</html>