<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ADMIN</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/loginAdmin.css">
    <script src="../js/delete.js"></script>

    <link rel="stylesheet" href="../css/loginAdmin.css">
    <script src="../js/deleteFilm.js"></script>
    <link rel="stylesheet" href="css/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</head>
<body style="background: rgb(248, 249, 250)">

<div class="navbarMenu" style="height: 100px; font-size: 20px;">
    <nav class="navbar navbar-expand-lg navbar-light bg-light" id="navBar">
        <div class="container-fluid">
            <a class="navbar-brand" href="home.php"><img id="logo" src="../images/logo.png" alt="IMG" style="width: 100px;"></a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0" id="toCenter">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="home.php"><b>QUẢN LÝ PHIM</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="user.php"><b>QUẢN LÝ ACCOUNT</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="comment.php"><b>QUẢN LÝ COMMENT</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled">Xin chào Admin</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
<table cellpadding="10" cellspacing="10" border="0" style="border-collapse: collapse; margin: auto;font-size: 20px">
<h1 style="text-align: center">QUẢN LÝ COMMENT</h1>
    <tr class="control" style="text-align: left; font-weight: bold;">
    </tr>
    <tr class="header">
        <td>ID Người comment</td>
        <td>Tên người comment</td>
        <td>Tên phim</td>
        <td>Nội dung</td>
        <td>Thời gian</td>
    </tr>
        <?php
/////////Truy suất comment///////////////////////////////////////////////////
            require_once('../api/dbConnection.php');
            $sql = 'SELECT * FROM comment'; // NƠI LẤY DATA
            try {
                $stmt = $dbCon->prepare($sql);
                $stmt->execute();
            } catch (PDOException $ex) {
                die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
            }
            $total = 0;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $total++;
////////Truy suất tên người comment/////////////////////////////////////////
                $sql1 = 'SELECT * FROM users WHERE MaUser=?'; // NƠI LẤY DATA
                try {
                    $stmt1 = $dbCon->prepare($sql1);
                    $stmt1->execute(array($row['MaUser']));
                } catch (PDOException $ex) {
                    die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
                }
                $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);

////////Truy suất tên phim dượcd comment/////////////////////////////////////////
                $sql2 = 'SELECT * FROM film WHERE MaF=?'; // NƠI LẤY DATA
                try {
                    $stmt2 = $dbCon->prepare($sql2);
                    $stmt2->execute(array($row['MaF']));
                } catch (PDOException $ex) {
                    die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
                }
                $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                echo '
                <tr class="item">
                    <td>'.$row['MaUser'].'</td>
                    <td>'.$row1['Username'].'</td>
                    <td>'.$row2['Names'].'</td>
                    <td>'.$row['Content'].'</td>
                    <td>'.$row['Times'].'</td>
                    <td><a href="" id='.$row["MaBL"].' class="delComment">Delete</a></td>
                </tr>
                ';
            }

          ?>
    <tr class="control" style="text-align: left; font-weight: bold; font-size: 17px">
        <td colspan="5">
            <p>Số lượng bình luận: <?php if (isset($total)) echo $total; ?></p>
        </td>
    </tr>
</table>


<!-- Delete Confirm Modal -->
<!--  -->
<?php
    if(isset($_POST['MaBL'])) {
        $MaBL = $_POST['MaBL'];
        $sql3 = "DELETE FROM comment WHERE MaBL=?"; // NƠI LẤY DATA
        try {
            $stmt3 = $dbCon->prepare($sql3);
            $stmt3->execute(array($MaBL));
        } catch (PDOException $ex) {
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
        header('Location: comment.php');
    }
?>


</body>
</html>