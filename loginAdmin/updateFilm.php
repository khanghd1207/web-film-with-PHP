<?php
//Lay value////////////////////////////////////////////////////
    require('../api/dbConnection.php');
    $MaF = $_GET['MaF'];
    $sql = 'SELECT * FROM film WHERE MaF=?'; // NƠI LẤY DATA
    try {
        $stmt = $dbCon->prepare($sql);
        $stmt->execute(array($MaF));
    } catch (PDOException $ex) {
        die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
    }
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

//Update///////////////////////////////////////////////////////////
    $result;
    if(isset($_POST['submit'])) {
        if ($_POST["Images"]!="" && $_POST["Names"]!="" && $_POST["Descr"]!="" && $_POST["Actor"]!="" && $_POST["Director"]!="" && $_POST["Trailer"]!="" && $_POST["Age"]!="" && $_POST["Rating"]!="") {
            $Images = $_POST['Images'];
            $Names = $_POST['Names'];
            $Descr = $_POST['Descr'];
            $Actor = $_POST['Actor'];
            $Director = $_POST['Director'];
            $Trailer = $_POST['Trailer'];
            $Age = $_POST['Age'];
            $Rating = $_POST['Rating'];
            $sql1 = "UPDATE film SET Names=?, Actor=?, Director=?, Rating=?, Descr=?, Images=?, Trailer=?, Age=? WHERE MaF=?";
            try {
                $stmt1 = $dbCon->prepare($sql1);
                $stmt1->execute(array($Names,$Actor,$Director,$Rating,$Descr,$Images,$Trailer,$Age,$MaF));
            } catch (PDOException $ex) {
                die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
            }
        } else {
            $result = "<div style='color: red;'>Nhập còn thiếu</div>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Sửa Đổi Phim | Quản Trị Website Film</title>
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
                    <img src="../images/team.png" alt="IMG" style="margin-top: 200px;">
                </div>
                <!--=====TIÊU ĐỀ======-->
                <div class="login100-form addFilm">
                    <span class="login100-form-title">
                        <b>SỬA ĐỔI PHIM</b>
                    </span>
                    <!--=====FORM INPUT TÀI KHOẢN VÀ PASSWORD======-->
                    <form action="" method="POST">
                        <div class="wrap-input100 validate-input">
                            Image: 
                            <input class="input100 add" type="text" placeholder="Đường dẩn ảnh" name="Images" 
                            Value='<?php
                                if(isset($row['Images'])){
                                    echo $row['Images'];
                                }
                            ?>'>
                        </div>
                        <div class="wrap-input100 validate-input">
                            Names:
                            <input class="input100 add" type="text" placeholder="Tên" name="Names"
                            Value='<?php
                                if(isset($row['Names'])){
                                    echo $row['Names'];
                                }
                            ?>'>
                        </div>
                        <div class="wrap-input100 validate-input">
                            Description: 
                            <textarea name="Descr" id="description" placeholder="Nhập lại mô tả phim" class="input100 add" cols="30" rows="4"></textarea>
                            
                        </div>
                        <div class="wrap-input100 validate-input">
                            Actor:
                            <input class="input100 add" type="text" placeholder="Diển viên" name="Actor"
                            Value='<?php
                                if(isset($row['Actor'])){
                                    echo $row['Actor'];
                                }
                            ?>'>
                        </div>
                        <div class="wrap-input100 validate-input">
                            Director: 
                            <input class="input100 add" type="text" placeholder="Đạo diển" name="Director"
                            Value='<?php
                                if(isset($row['Director'])){
                                    echo $row['Director'];
                                }
                            ?>'>
                        </div>
                        <div class="wrap-input100 validate-input">
                            Trailer:
                            <input class="input100 add" type="text" placeholder="Đường dẩn Trailer" name="Trailer"
                            Value='<?php
                                if(isset($row['Trailer'])){
                                    echo $row['Trailer'];
                                }
                            ?>'>
                        </div>
                        <div class="wrap-input100 validate-input">
                            Allowed viewing age: 
                            <input class="input100 add" type="text" placeholder="Độ tuổi được xem" name="Age"
                            Value='<?php
                                if(isset($row['Age'])){
                                    echo $row['Age'];
                                }
                            ?>'>
                        </div>
                        <div class="wrap-input100 validate-input">
                            Rating:
                            <input class="input100 add" type="text" placeholder="Đánh giá" name="Rating"
                            Value='<?php
                                if(isset($row['Rating'])){
                                    echo $row['Rating'];
                                }
                            ?>'>
                        </div>
                        <?php if (isset($result)) echo $result; ?>
                        <!--=====ĐĂNG NHẬP======-->
                        <div class="container-login100-form-btn">
                            <input type="submit" value="Sửa đổi" id="submit" name="submit" />
                        </div>
                        <div class="text-left p-t-12">
                            <a class="txt2 register" href="home.php">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- PHP -->
</body>

</html>