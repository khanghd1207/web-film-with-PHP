<?php
require('../api/dbConnection.php');
$notice;
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == '1') {
        $notice = 'Đăng ký thành công!';
    }
    if ($_GET['msg'] == '2') {
        $notice = 'Cập nhật mật khẩu thành công!';
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submitSignIn'])) {
        $errSignIn;
        $userSignIn;
        $passSignIn;
        if (empty($_POST['userSignIn']) || !isset($_POST['userSignIn'])) {
            $errSignIn = 'Vui lòng nhập tên đăng nhập!';
        } elseif (empty($_POST['passSignIn']) || !isset($_POST['passSignIn'])) {
            $userSignIn = $_POST['userSignIn'];
            $errSignIn = 'Vui lòng nhập mật khẩu';
        } else {
            $sql = 'SELECT * FROM Users WHERE Username=?'; // NƠI LẤY DATA
            try {
                $stmt = $dbCon->prepare($sql);
                $stmt->execute(array($_POST['userSignIn']));
            } catch (PDOException $ex) {
                die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
            }
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row != null) {
                if ($row['PWD'] == $_POST['passSignIn']) {
                    header('Location: ../index.php?us=' . $row['MaUser']);
                } else {
                    $userSignIn = $_POST['userSignIn'];
                    $passSignIn = $_POST['passSignIn'];
                    $errSignIn = 'Tên đăng nhập hoặc mật khẩu không chính xác!';
                }
            } else {
                $userSignIn = $_POST['userSignIn'];
                $passSignIn = $_POST['passSignIn'];
                $errSignIn = 'Tên đăng nhập hoặc mật khẩu không chính xác!';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Đăng nhập quản trị | Website Film</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/login.css">
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
                        <b>ĐĂNG NHẬP WEB MOVIE</b>
                    </span>
                    <!--=====FORM INPUT TÀI KHOẢN VÀ PASSWORD======-->
                    <form action="login.php" method="POST">
                        <div class="wrap-input100 validate-input">
                            <input class="input100" type="text" placeholder="Tên tài khoản" name="userSignIn" id="username" value=<?php if (isset($userSignIn))
                                                                                                                                        echo $userSignIn; ?>>
                            <!-- <span class="focus-input100"></span> -->
                            <span class="symbol-input100">
                                <i class='bx bx-user'></i>
                            </span>
                        </div>
                        <div class="wrap-input100 validate-input">
                            <input autocomplete="off" class="input100" type="password" placeholder="Mật khẩu" name="passSignIn" id="password-field" value=<?php if (isset($passSignIn))
                                                                                                                                                                echo $passSignIn; ?>>
                            <!-- <span toggle="#password-field"></span>
                            <span class="focus-input100"></span> -->
                            <span class="symbol-input100">
                                <i class='bx bx-key' id="showPassword"></i>
                            </span>
                        </div>
                        <?php if (isset($errSignIn)) echo $errSignIn; ?>
                        <?php if (isset($notice)) echo $notice; ?>
                        <!--=====ĐĂNG NHẬP======-->
                        <div class="container-login100-form-btn">
                            <input type="submit" value="Đăng nhập" id="submitSignIn" name="submitSignIn" />
                        </div>
                        <div class="text-left p-t-12">
                            <a class="txt2 register" href="register.php">Đăng ký</a>
                            <a class="txt2 forget" href="forget.php">Quên mật khẩu?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- PHP -->
</body>

</html>