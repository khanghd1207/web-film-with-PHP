<?php
require_once('../api/dbConnection.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submitForget'])) {
        $errForget;
        $gmailForget;
        if (empty($_POST['gmailFG']) || !isset($_POST['gmailFG'])) {
            $errForget = 'Vui lòng nhập gmail!';
        } else {
            $gmailForget = $_POST['gmailFG'];
            $sqlCheckUsername = 'SELECT * FROM Users WHERE Gmail=?';
            try {
                $stmt1 = $dbCon->prepare($sqlCheckUsername);
                $stmt1->execute(array($gmailForget));
            } catch (PDOException $ex) {
                die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
            }
            if ($stmt1->rowCount() == 0) {
                $errForget = 'Tài khoản gmail chưa đăng ký hoặc không chính xác!';
            } else {
                $_SESSION['gmail'] = $gmailForget;
                header('Location:verifyOTPpwd.php');
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Quên mật khẩu | Website Film</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/login.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://smtpjs.com/v3/smtp.js"></script>
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
                        <b>KHÔI PHỤC MẬT KHẨU</b>
                    </span>
                    <!--=====FORM INPUT EMAIL VÀ OTP======-->
                    <form action="" method="POST">
                        <div class="wrap-input100 validate-input" data-validate="Bạn cần nhập đúng thông tin như: ex@abc.xyz">
                            <input class="input100" type="text" placeholder="Nhập email" name="gmailFG" id="gmailFG" value=<?php if(isset($gmailForget)) echo $gmailForget;?>>
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class='bx bx-mail-send'></i>
                            </span>
                        </div>
                        <?php if (isset($errForget)) echo $errForget; ?>
                        <!--=====XÁC NHẬN======-->
                        <div class="container-login100-form-btn">
                            <input type="submit" value="Nhận OTP" id="submitForget" name="submitForget" />
                        </div>

                        <!--===================-->


                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>