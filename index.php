<?php
require('api/dbConnection.php');
if (isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING'])) {
    $usernames;
    if (isset($_GET['us'])) {
        $pre = "?us=" . $_GET['us'];
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>TRANG CHỦ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS -->
    <link rel="stylesheet" href="css/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="js/changeTheme.js"></script>
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


    <h1 class="row" style="text-align:center" id="THphim"><b>Phim sắp ra mắt</b></h1>
    <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner" role="listbox" style="height:700px; text-align:-webkit-center;">
            <div class="carousel-item active">
                <img class="d-block img-fluid" src="./images/landscape.png" alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block img-fluid" src="./images/avatar.png" alt="Second slide">
            </div>
            <div class="carousel-item">
                <img class="d-block img-fluid" src="./images/midway.png" alt="Third slide">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </a>
    </div>
    <div class="container" style="margin-top:20px;">
        <div class="row listflim">

            <!-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> -->
            <?php
            // top 3 the loai so luong nhieu nhat
            $sqlFilm_Genre = 'SELECT MaTL FROM Film_Genre GROUP BY MaTL ORDER BY count(MaTL) DESC LIMIT 3';
            try {
                $stmt = $dbCon->prepare($sqlFilm_Genre);
                $stmt->execute();
            } catch (PDOException $ex) {
                die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
            }
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $sqlFilm = 'SELECT MaF FROM Film_Genre WHERE MaTL=? LIMIT 6';
                try {
                    $stmt1 = $dbCon->prepare($sqlFilm);
                    $stmt1->execute(array($row['MaTL']));
                } catch (PDOException $ex) {
                    die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
                }
                $sqlGenre = 'SELECT Genre FROM Genres WHERE MaTL=?';
                try {
                    $stmt0 = $dbCon->prepare($sqlGenre);
                    $stmt0->execute(array($row['MaTL']));
                } catch (PDOException $ex) {
                    die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
                }
                $pre = (isset($userID)) ? "?us=" . $userID."&type=".$row['MaTL'] : "?type=".$row['MaTL'];
                $rowName = $stmt0->fetch(PDO::FETCH_ASSOC);
                echo "<div class=\"detailsHome\" style='margin-top:20px'>";
                echo "<span>" . $rowName['Genre'] . "</span>";
                echo "<a href=\"films.php" . $pre . "\" class=\"watchmore\"><p>Xem thêm</p></a></>";

                echo "</div>";
                echo "<div class=\"row\">";
                while ($row1 = $stmt1->fetch(\PDO::FETCH_ASSOC)) {
                    $sqlFilm1 = 'SELECT * FROM Film WHERE MaF=?';
                    try {
                        $stmt2 = $dbCon->prepare($sqlFilm1);
                        $stmt2->execute(array($row1['MaF']));
                    } catch (PDOException $ex) {
                        die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
                    }

                    while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                        $preDetails = '';
                        if (isset($pre))
                            if (str_contains($pre, 'MaF')) {
                                $MaF = $_GET['MaF'];
                                $pre = str_replace('MaF=' . $MaF, 'MaF=' . $row2['MaF'], $pre);
                            } else {
                                $preDetails = $pre . "&MaF=" . $row2['MaF'];
                            }
                        if ($preDetails == '') {
                            $preDetails = "?MaF=" . $row2['MaF'];
                        }
                        echo "<div class=\"col-xs-6 col-sm-4 col-md-3 col-lg-2\">";
                        echo "<div class=\"cardFilm\">";
                        echo "<div class=\"cardimg\" style=\"background-image: url(" . $row2['Images'] . ")\"></div>";
                        echo "<div class=\"cardinfo\">";
                        echo "<p class=\"texttitle\">" . $row2['Names'] . "</p>";
                        $vote = "";
                        for ($i = 1; $i <= 10; $i++) {
                            if ($i > $row2['Rating']) {
                                $vote .= "&#9734;";
                            } else
                                $vote .= "&#9733;";
                        }
                        echo "<p class=\"textbody\">$vote</p>";
                        echo "<a href=\"details.php" . $preDetails . "\"><button class=\"cardbutton\">Xem phim</button></a>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    }
                }
                echo "</div>";
                echo "<div></div>";
            }
            ?>

        </div>

        <!-- </div> -->
    </div>

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