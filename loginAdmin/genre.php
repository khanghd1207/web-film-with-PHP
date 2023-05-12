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
    <script src="../js/delete.js"></script>
    <link rel="stylesheet" href="css/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>

<div class="navbarMenu" style="height: 100px;">
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
                        <a class="nav-link" href="genre.php"><b>QUẢN LÝ THỂ LOẠI</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled">Xin chào Admin</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
<table cellpadding="10" cellspacing="10" border="0" style="border-collapse: collapse; margin: auto">

    <tr class="control" style="text-align: left; font-weight: bold; font-size: 20px">
        <td colspan="5">
            <h1 >QUẢN LÝ COMMENT</h1>
            <br>
            <a class='add' href="addGenre.php">THÊM THỂ LOẠI TẠI ĐÂY</a>
        </td>
    </tr>
    <tr class="header">
        <td>Tên thể loại</td>
    </tr>
        <?php
/////////Truy suất the loai///////////////////////////////////////////////////
            require_once('../api/dbConnection.php');
            $sql = 'SELECT * FROM genres'; // NƠI LẤY DATA
            try {
                $stmt = $dbCon->prepare($sql);
                $stmt->execute();
            } catch (PDOException $ex) {
                die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
            }
            $total = 0;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $total++;
                echo '
                <tr class="item">
                    <td>'.$row['Genre'].'</td>
                    <td><a href="updateGenre.php?MaTL='.$row['MaTL'].'">Edit</a> | 
                    <a href="" id='.$row["MaTL"].' class="delGenre">Delete</a></td>
                </tr>
                ';
            }

          ?>
    <tr class="control" style="text-align: left; font-weight: bold; font-size: 17px">
        <td colspan="5">
            <p>Số lượng Phim: <?php if (isset($total)) echo $total; ?></p>
        </td>
    </tr>
</table>

<!-- Delete Confirm Modal -->
<!--  -->
<!-- Delete Confirm Modal -->
<!--  -->
<?php
    if(isset($_POST['MaTL'])) {
        $MaTL = $_POST['MaTL'];
        $sql7 = 'SELECT * FROM film_genre WHERE MaTL=?';
        try {
            $stmt7 = $dbCon->prepare($sql7);
            $stmt7->execute(array($MaTL));
        } catch (PDOException $ex) {
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
        $row7 = $stmt7->fetch(PDO::FETCH_ASSOC);
        if (count($row7)==0) {
            $sql3 = "DELETE FROM genres WHERE MaTL=?"; // NƠI LẤY DATA
            try {
                $stmt3 = $dbCon->prepare($sql3);
                $stmt3->execute(array($MaTL));
            } catch (PDOException $ex) {
                die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
            }
        }
        header('Location: genre.php');
    }

?>


</body>
</html>