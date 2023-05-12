<?php
require_once('../api/dbConnection.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submitSignUp'])) {
        $errSignUp;
        $userSignUp;
        $gmailSignUp;
        $passSignUp1;
        $passSignUp2;
        if (empty($_POST['userSignUp']) || !isset($_POST['userSignUp'])) {
            $errSignUp = 'Vui lòng nhập tên đăng nhập!';
        } elseif (empty($_POST['gmailSignUp']) || !isset($_POST['gmailSignUp'])) {
            $userSignUp = $_POST['userSignUp'];
            $errSignUp = 'Vui lòng nhập tài khoản gmail!';
        } elseif (!str_contains($_POST['gmailSignUp'], '@gmail.com')) {
            $userSignUp = $_POST['userSignUp'];
            $gmailSignUp = $_POST['gmailSignUp'];
            $errSignUp = 'Tài khoản gmail không hợp lệ!';
        } elseif (empty($_POST['passSignUp1']) || !isset($_POST['passSignUp1'])) {
            $userSignUp = $_POST['userSignUp'];
            $gmailSignUp = $_POST['gmailSignUp'];
            $errSignUp = 'Vui lòng nhập mật khẩu!';
        } elseif (strlen($_POST['passSignUp1']) < 8) {
            $userSignUp = $_POST['userSignUp'];
            $gmailSignUp = $_POST['gmailSignUp'];
            $passSignUp1 = $_POST['passSignUp1'];
            $errSignUp = 'Vui lòng nhập mật khẩu trên 8 ký tự!';
        } elseif (empty($_POST['passSignUp2']) || !isset($_POST['passSignUp2'])) {
            $userSignUp = $_POST['userSignUp'];
            $gmailSignUp = $_POST['gmailSignUp'];
            $passSignUp1 = $_POST['passSignUp1'];
            $errSignUp = 'Vui lòng xác nhận mật khẩu!';
        } elseif ($_POST['passSignUp1'] != $_POST['passSignUp2']) {
            $userSignUp = $_POST['userSignUp'];
            $gmailSignUp = $_POST['gmailSignUp'];
            $passSignUp1 = $_POST['passSignUp1'];
            $passSignUp2 = $_POST['passSignUp2'];
            $errSignUp = 'Mật khẩu không khớp!';
        } else {
            $userSignUp = $_POST['userSignUp'];
            $gmailSignUp = $_POST['gmailSignUp'];
            $passSignUp1 = $_POST['passSignUp1'];
            $passSignUp2 = $_POST['passSignUp2'];
            $sqlCheckUsername = 'SELECT * FROM Users WHERE Username=?';
            try {
                $stmt1 = $dbCon->prepare($sqlCheckUsername);
                $stmt1->execute(array($userSignUp));
            } catch (PDOException $ex) {
                die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
            }
            if ($stmt1->rowCount() == 1) {
                $errSignUp = 'Tên đăng nhập đã tồn tại!';
            } else {
                $sqlCheckGmail = 'SELECT * FROM Users WHERE Gmail=?';
                try {
                    $stmt2 = $dbCon->prepare($sqlCheckGmail);
                    $stmt2->execute(array($gmailSignUp));
                } catch (PDOException $ex) {
                    die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
                }
                if ($stmt2->rowCount() == 1) {
                    $errSignUp = 'Gmail đã tồn tại!';
                } else {
                    $_SESSION['gmail'] = $gmailSignUp;
                    $_SESSION['user'] = $userSignUp;
                    $_SESSION['pass'] = $passSignUp1;
                    header("Location:verifyOTP.php");
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Đăng ký tài khoản | Website Film</title>
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
                <div class="login100-form-register validate-form">
                    <span class="login100-form-title-register">
                        <b>ĐĂNG KÝ</b>
                    </span>
                    <!--=====FORM INPUT TAOJ TÀI KHOẢN VÀ PASSWORD======-->
                    <form action="" method="POST">
                        <div class="wrap-input100 validate-input">
                            <input class="input100" type="text" placeholder="Tên đăng nhập" name="userSignUp" id="userSignUp" value=<?php if (isset($userSignUp)) echo $userSignUp; ?>>
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class='bx bx-user'></i>
                            </span>
                        </div>
                        <div class="wrap-input100 validate-input" data-validate="Bạn cần nhập đúng thông tin như: ex@abc.xyz">
                            <input class="input100" type="text" placeholder="Nhập email" name="gmailSignUp" id="gmailSignUp" value=<?php if (isset($gmailSignUp)) echo $gmailSignUp; ?>>
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class='bx bx-mail-send'></i>
                            </span>
                        </div>
                        <div class="wrap-input100 validate-input">
                            <input autocomplete="off" class="input100" type="password" placeholder="Mật khẩu" name="passSignUp1" id="password-field" value=<?php if (isset($passSignUp1)) echo $passSignUp1; ?>>
                            <span toggle="#password-field"></span>
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class='bx bx-key'></i>
                            </span>
                        </div>
                        <div class="wrap-input100 validate-input">
                            <input autocomplete="off" class="input100" type="password" placeholder="Xác nhận mật khẩu" name="passSignUp2" id="password-field" value=<?php if (isset($passSignUp2)) echo $passSignUp2; ?>>
                            <span toggle="#password-field"></span>
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class='bx bx-key'></i>
                            </span>
                        </div>
                        <?php if (isset($errSignUp)) echo $errSignUp; ?>
                        <!--=====ĐĂNG Ký======-->
                        <div class="container-login100-form-btn">
                            <input type="submit" value="NHẬN OTP" id="submitSignUp" name="submitSignUp" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>