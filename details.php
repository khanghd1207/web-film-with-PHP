<?php
require('api/dbConnection.php');
$like = "";
if ($_GET['MaF']) {
    $MaF = $_GET['MaF'];
    $sql = 'SELECT * FROM film WHERE MaF=?'; // NƠI LẤY DATA
    try {
        $stmt = $dbCon->prepare($sql);
        $stmt->execute(array($MaF));
    } catch (PDOException $ex) {
        die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
    }
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row == null) {
        $errSignIn = 'Error!';
    }
    if (isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING'])) {
        $usernames;
        $pre = $_SERVER['QUERY_STRING'];
        if (isset($_GET['us'])) {
            $userID = $_GET['us'];
            $sqlUser = 'SELECT * FROM Users WHERE MaUser=?';
            try {
                $stmt1 = $dbCon->prepare($sqlUser);
                $stmt1->execute(array($userID));
            } catch (Exception $ex) {
                die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
            }
            if ($stmt1->rowCount() > 0) {
                $usernames = $stmt1->fetch(PDO::FETCH_ASSOC)['Username'];
            }
        }
    }
}

// Bookmark
if (isset($_POST['like'])) {
    if ($_POST['like'] != '-1' && isset($userID) && isset($MaF)) {
        $sql2 = 'INSERT INTO favorite (MaUser, MaF) VALUES(?,?)';
        try {
            $stmt1 = $dbCon->prepare($sql2);
            $stmt1->execute(array($userID, $MaF));
        } catch (Exception $ex) {
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
        if ($stmt1->rowCount() > 0) {
            $like = "checked";
        }
    }
    if($_POST['like'] == '-1'&& isset($userID) && isset($MaF)) {
        $sql2 = 'DELETE FROM Favorite WHERE MaUser=? AND MaF=?';
        try {
            $stmt1 = $dbCon->prepare($sql2);
            $stmt1->execute(array($userID, $MaF));
        } catch (Exception $ex) {
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
        if ($stmt1->rowCount() > 0) {
            $like = "";
        }
    }
}
///////////////////////////////////////////////The loai
$sql5 = 'SELECT * FROM film_genre WHERE MaF=?'; // NƠI LẤY DATA
try {
    $stmt5 = $dbCon->prepare($sql5);
    $stmt5->execute(array($MaF));
} catch (PDOException $ex) {
    die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
}
$row5 = $stmt5->fetch(PDO::FETCH_ASSOC);
$sql6 = 'SELECT * FROM genres WHERE MaTL=?'; // NƠI LẤY DATA
try {
    $stmt6 = $dbCon->prepare($sql6);
    $stmt6->execute(array($row5['MaTL']));
} catch (PDOException $ex) {
    die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
}
$row6 = $stmt6->fetch(PDO::FETCH_ASSOC);
///////////////////////////////////////////////////////////
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS -->
    <link rel="stylesheet" href="css/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="js/like.js"></script>
    <script type="text/javascript" src="js/changeTheme.js"></script>
    <link rel="stylesheet" href="css/style.css">
</head>

<body style="background: rgb(248, 249, 250)">
<div class="navbarMenu">
        <nav class="navbar navbar-expand-lg navbar-light bg-light" id="navBar">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?php echo (isset($userID)) ? "index.php?us=" . $userID : "index.php"; ?>"><img id="logo" src="images/logo.png" alt="IMG"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0" id="toCenter">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="<?php echo (isset($userID)) ? "index.php?us=" . $userID : "index.php"; ?>" style="color: red"><b>Trang
                                    Chủ</b></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo (isset($userID)) ? "films.php?us=" . $userID : "films.php"; ?>"><b>Phim</b></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo (isset($userID)) ? "about.php?us=" . $userID : "about.php"; ?>"><b>Thông Tin</b></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href=<?php echo (isset($userID)) ? "bookmark.php?us=" . $userID : "bookmark.php"; ?>><?php if (isset($userID))
                                                                echo "<b>Yêu Thích</b>"; ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login/login.php"><b>Tài khoản</b></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled"><?php if (isset($usernames))
                                                                echo "Xin chào, " . $usernames; ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php"><?php if (isset($usernames))
                                                                        echo "<b>Đăng xuất</b>" ?></a>
                        </li>
                    </ul>

                    <form class="d-flex" action="<?php echo (isset($userID)) ? "search.php?us=" . $userID : "search.php" ?>" method="POST">
                        <input class="form-control me-2" type="search" placeholder="Tìm phim..." aria-label="Search" name="inputSearch">
                        <button class="btn btn-outline-success" type="submit" name="search"><b>Search</b></button>
                        <label class="switch">
                            <input type="checkbox" id="cb">
                            <span class="slider"></span>
                        </label>
                    </form>
                </div>
            </div>
        </nav>
    </div>


    <div class="container" style="margin-top:20px" id="films">

        <div class="row">
            <?php
            if (isset($userID) && isset($MaF)) {
                $sql3 = 'SELECT * FROM Favorite WHERE MaUser=? AND MaF=?';
                try {
                    $stmt1 = $dbCon->prepare($sql3);
                    $stmt1->execute(array($userID, $MaF));
                } catch (Exception $ex) {
                    die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
                }
                if ($stmt1->rowCount() > 0) {
                    $like = "checked";
                }
            }
            else{
                $like = "";
            }
            echo '
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 frameFilm">
                    <video controls style="width:100%; height: auto;">
                        <source src="' . $row['Trailer'] . '" type="video/mp4" />
                    </video>                
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                    <div class="par">
                        <h1 style="marging-bottom: 10px"><b>' . $row['Names'] . '</b></h1>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <img id="starRating" src="images/star.png" alt="IMG" style="width:15px; padding-bottom: 4px;">
                            ' . $row['Rating'] . '/10
                            <span class="ageAble"><b>' . $row['Age'] . '+</b></span>    
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><b>Mô tả: </b>' . $row['Descr'] . '</div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><span><b>Đạo Diễn: </b></span>' . $row['Director'] . '</div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 "><span><b>Diễn Viên: </b></span>' . $row['Actor'] . '</div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><span><b>Thể Loại: </b></span>' . $row6['Genre'] . '</div>
                        <input type="checkbox" id="favorite" name="favorite-checkbox" value="favorite-button" like="' . $row['MaF'] . '"'.$like.'>
                        <label for="favorite" class="container" id="label">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                        <div class="action">
                            <span class="option-1">Thêm vào yêu thích</span>
                            <span class="option-2">Đã thêm vào yêu thích</span>
                        </div>
                        </label>
                    </div>

                </div>
                ';
            ?>
        </div>

        <!--Comment*******************************************************************************************************************************************-->
        <div class="container-comment">
            <h5>Comment</h5>
            <?php
            $preDetails = '';
            if (isset($pre))
                if (isset($userID)) {
                    $preDetails = "?us=" . $userID . "&" . "MaF=" . $MaF;
                } else {
                    $preDetails = "?MaF=" . $MaF;
                }
            if ($preDetails == '') {
                $preDetails = "?MaF=" . $MaF;
            }
            ?>
            <form action="<?php echo 'details.php' . $preDetails . ''; ?>" method="POST">
                <img id="avatarUser" src="images/avatarUser.png" alt="IMG">
                <textarea name='contentComment' id="boxComment" placeholder='Add Your Comment'></textarea>
                <div class="btn" <?php
                                    if (!isset($_GET['us'])) {
                                        echo 'style="display: none;"';
                                    }
                                    ?>>
                    <input class='buttonAdd' id="addComment" type="submit" value='Comment' name=submitComment>
                    <button class='buttonCancel' id='cancelComment'>Cancel</button>
                </div>
            </form>
            <!--Add Comment//////////////////////////////////////////////////////////////////////////////-->
            <?php
            if (isset($_POST['submitComment']) && isset($_GET['us'])) {
                $MaUser = $_GET['us'];
                $content;
                date_default_timezone_set("Asia/Ho_Chi_Minh");
                $time = date('H:i d/m/Y');
                if (!empty($_POST['contentComment'])) {
                    $sqlInsert = 'INSERT INTO Comment (MaUser,MaF,Content,Times) VALUES (?,?,?,?)'; // NƠI LẤY DATA
                    try {
                        $stmt5 = $dbCon->prepare($sqlInsert);
                        $stmt5->execute(array($MaUser, $MaF, $_POST['contentComment'], $time));
                    } catch (PDOException $ex5) {
                        die(json_encode(array('status' => false, 'data' => $ex5->getMessage())));
                    }
                }
            }
            ?>
            <!--Show Comment///////////////////////////////////////////////////////////////////////////////-->
            <?php
            $sql3 = 'SELECT * FROM Comment WHERE MaF=?'; // NƠI LẤY DATA
            try {
                $stmt3 = $dbCon->prepare($sql3);
                $stmt3->execute(array($MaF));
            } catch (PDOException $ex3) {
                die(json_encode(array('status' => false, 'data' => $ex3->getMessage())));
            }
            while ($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)) {
                $sql4 = 'SELECT * FROM users WHERE MaUser=?'; // NƠI LẤY DATA
                try {
                    $stmt4 = $dbCon->prepare($sql4);
                    $stmt4->execute(array($row3['MaUser']));
                } catch (PDOException $ex4) {
                    die(json_encode(array('status' => false, 'data' => $ex4->getMessage())));
                }
                $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
                $name = strtoupper($row4['Username']);
                echo '
                        <div class="showComment">
                            <p class="commentUserName"><b>' . $name . '</b></p>
                            <p class="content">' . $row3['Content'] . '</p>
                            <p class="timeComment">' . $row3['Times'] . '</p>
                        </div>
                        <hr>
                    ';
            }

            ?>
        </div>


        <!--********************************************************************************************8**********************************************-->

        <div class="row listflim">

            <?php
            $sql1 = 'SELECT * FROM film_genre WHERE MaF=?'; // NƠI LẤY DATA
            try {
                $stmt1 = $dbCon->prepare($sql1);
                $stmt1->execute(array($MaF));
            } catch (PDOException $ex1) {
                die(json_encode(array('status' => false, 'data' => $ex1->getMessage())));
            }
            $listF = array();
            while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                $sql2 = 'SELECT * FROM film_genre WHERE MaTL=? AND MaF!=?'; // NƠI LẤY DATA
                try {
                    $stmt2 = $dbCon->prepare($sql2);
                    $stmt2->execute(array($row1['MaTL'], $row1['MaF']));
                } catch (PDOException $ex1) {
                    die(json_encode(array('status' => false, 'data' => $ex1->getMessage())));
                }
                while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                    if (!in_array($row2['MaF'], $listF)) {
                        array_push($listF, $row2['MaF']);
                    }
                }
            }
            for ($i = 0; $i < count($listF); $i++) {
                try {
                    $stmt = $dbCon->prepare($sql);
                    $stmt->execute(array($listF[$i]));
                } catch (PDOException $ex) {
                    die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
                }
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $preDetails = '';
                if (isset($pre))
                    if (isset($userID)) {
                        $preDetails = "?us=" . $userID . "&MaF=" . $row['MaF'];
                    } else {
                        $preDetails = "?MaF=" . $row['MaF'];
                    }
                if ($preDetails == '') {
                    $preDetails = "?MaF=" . $row['MaF'];
                }
                $vote = "";
                for ($j = 1; $j <= 10; $j++) {
                    if ($j > $row['Rating']) {
                        $vote .= "&#9734;";
                    } else
                        $vote .= "&#9733;";
                }
                echo '
                        <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                            <div class="cardFilm">
                                <div class="cardimg" style="background-image: url(' . $row['Images'] . ');"></div>
                                <div class="cardinfo">
                                    <p class="texttitle">' . $row['Names'] . '</p>  
                                    
                                    <p class="textbody">' . $vote . '</p>
                                    <a href="details.php' . $preDetails . '"><button class="cardbutton">Xem phim</button></a>
                                </div>
                            </div>
                        </div>
                    ';
            }
            ?>
        </div>
        <!-- Footer -->
        <footer class="text-center text-lg-start text-muted" id="footer">

            <hr class="borderFooter">
            <!-- Section: Links  -->
            <section class="">
                <div class="container text-center text-md-start mt-5">
                    <!-- Grid row -->
                    <div class="row mt-3">
                        <!-- Grid column -->
                        <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                            <!-- Content -->
                            <h6 class="text-uppercase fw-bold mb-4">
                                <i class="fas fa-gem me-3 text-secondary"></i>DỰ ÁN CUỐI KỲ
                            </h6>
                            <p>
                                Thành viên nhóm
                            </p>
                        </div>
                        <!-- Grid column -->

                        <!-- Grid column -->
                        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                            <!-- Links -->
                            <h6 class="text-uppercase fw-bold mb-4">
                                Products
                            </h6>
                            <p>
                                <a href="" class="text-reset">None</a>
                            </p>
                            <p>
                                <a href="" class="text-reset">None</a>
                            </p>
                            <p>
                                <a href="" class="text-reset">None</a>
                            </p>
                            <p>
                                <a href="" class="text-reset">None</a>
                            </p>
                        </div>
                        <!-- Grid column -->

                        <!-- Grid column -->
                        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                            <!-- Links -->
                            <h6 class="text-uppercase fw-bold mb-4">
                                Useful links
                            </h6>
                            <p>
                                <a href="" class="text-reset">None</a>
                            </p>
                            <p>
                                <a href="" class="text-reset">None</a>
                            </p>
                            <p>
                                <a href="" class="text-reset">None</a>
                            </p>
                            <p>
                                <a href="" class="text-reset">None</a>
                            </p>
                        </div>
                        <!-- Grid column -->

                        <!-- Grid column -->
                        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                            <!-- Links -->
                            <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
                            <p><i class="fas fa-home me-3 text-secondary"></i> Hồ Chí Minh</p>
                            <p>
                                <i class="fas fa-envelope me-3 text-secondary"></i>
                                info@example.com
                            </p>
                            <p><i class="fas fa-phone me-3 text-secondary"></i> + 01 234 567 88</p>
                            <p><i class="fas fa-print me-3 text-secondary"></i> + 01 234 567 89</p>
                        </div>
                        <!-- Grid column -->
                    </div>
                    <!-- Grid row -->
                </div>
            </section>
            <!-- Section: Links  -->
        </footer>
        <!-- Footer -->
</body>

</html>