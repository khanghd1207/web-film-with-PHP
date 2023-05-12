<?php
        require('../api/dbConnection.php');
        $result;
        if(isset($_POST['submit'])) {
            if ($_POST["Genre"]!="") {
                $Genre = $_POST['Genre'];
                $sql = "INSERT INTO genres VALUES(null, '$Genre')";
                try {
                    $stmt = $dbCon->prepare($sql);
                    $stmt->execute();
                } catch (PDOException $ex) {
                    die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
                }
            } else {
                $result = "Mời nhập";
            }
        }

    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Thêm THỂ LOẠI |Quản Trị Website Film</title>
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
            <div class="wrap-login100 ">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="../images/team.png" alt="IMG">
                </div>
                <!--=====TIÊU ĐỀ======-->
                <div class="login100-form addFilm">
                    <span class="login100-form-title">
                        <b>THÊM THỂ LOẠI</b>
                    </span>
                    <!--=====FORM INPUT TÀI KHOẢN VÀ PASSWORD======-->
                    <form action="" method="POST">
                        <div class="wrap-input100 validate-input">
                            Tên: 
                            <input class="input100 add" type="text" placeholder="Tên thể loại" name="Genre">
                        </div>
                        <?php if (isset($result)) echo $result; ?>
                        <!--=====ĐĂNG NHẬP======-->
                        <div class="container-login100-form-btn">
                            <input type="submit" value="Thêm" id="submit" name="submit" />
                        </div>
                        <div class="text-left p-t-12">
                            <a class="txt2 register" href="genre.php">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- PHP -->
</body>

</html>