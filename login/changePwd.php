<?php
require_once('../api/dbConnection.php');
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['changePwd'])) {
        $errChange;
        $password1;
        $password2;
        if (!isset($_POST['password1']) || empty($_POST['password1'])) {
            $errChange = 'Vui lòng nhập mật khẩu!';
        } 
        elseif(strlen($_POST['password1']) < 8){
            $password1 = $_POST['password1'];
            $errChange = 'Vui lòng nhập mật khẩu trên 8 ký tự!';
        }
        elseif (!isset($_POST['password2']) || empty($_POST['password2'])) {
            $password1 = $_POST['password1'];
            $errChange = 'Vui lòng xác nhận mật khẩu!';
        } else {
            $password1 = $_POST['password1'];
            $password2 = $_POST['password2'];
            if (isset($_SESSION['gmail'])) {
                if ($password1 == $password2) {
                    $gmail = $_SESSION['gmail'];
                    $sql = 'UPDATE Users SET PWD=? WHERE Gmail=?';
                    try {
                        $stmt = $dbCon->prepare($sql);
                        $stmt->execute(array($password1, $gmail));
                    } catch (PDOException $ex) {
                        die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
                    }
                    if ($stmt->rowCount() > 0) {
                        header('Location:login.php?msg='.'2');
                    } else {
                        $errChange = 'Mật khẩu mới trùng với mật khẩu cũ!';
                    }
                } else {
                    $errChange = 'Mật không không khớp!';
                }
            }
        }
    }
    unset($_SESSION['gmail']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Tạo mới mật khẩu | Website Film</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/login.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                <a href="../index.php"><img src="../images/team.png" alt="IMG"></a>
                </div>
                <!--=====TIÊU ĐỀ======-->
                <div class="login100-form validate-form">
                    <span class="login100-form-title">
                        <b>TẠO MỚI MẬT KHẨU</b>
                    </span>
                    <!--=====FORM INPUT MẬT KHẨU MỚI VÀ XÁC NHẬN MẬT KHẨU======-->
                    <form action="" method="POST">
                        <div class="wrap-input100 validate-input">
                            <input autocomplete="off" class="input100" type="password" placeholder="Mật khẩu mới" name="password1" id="password-field" value=<?php if (isset($password1))
                                echo $password1;?>>
                            <span toggle="#password-field"></span>
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class='bx bx-key'></i>
                            </span>
                        </div>
                        <div class="wrap-input100 validate-input">
                            <input autocomplete="off" class="input100" type="password" placeholder="Xác nhận mật khẩu" name="password2" id="password-field" value=<?php if (isset($password1))
                                echo $password1;?>>
                            <span toggle="#password-field"></span>
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class='bx bx-key'></i>
                            </span>
                        </div>
                        <?php if (isset($errChange)) echo $errChange; ?>
                        <!--=====XÁC NHẬN ĐỔI HOÀN THÀNH ĐỔI MẬT KHẨU======-->
                        <div class="container-login100-form-btn">
                            <input type="submit" value="Xác nhận" id="changePwd" name="changePwd" />
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>