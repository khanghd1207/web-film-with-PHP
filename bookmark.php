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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="css/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="js/changeTheme.js"></script>

    <title>YÊU THÍCH</title>
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
                            <a class="nav-link" aria-current="page" href="<?php echo (isset($userID)) ? "index.php?us=" . $userID : "index.php"; ?>"><b>Trang
                                    Chủ</b></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo (isset($userID)) ? "films.php?us=" . $userID : "films.php"; ?>"><b>Phim</b></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo (isset($userID)) ? "about.php?us=" . $userID : "about.php"; ?>"><b>Thông Tin</b></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href=<?php echo (isset($userID)) ? "bookmark.php?us=" . $userID : "bookmark.php"; ?> style="color: red"><?php if (isset($userID))
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

    <div class="container" style="margin-top:20px;">
        <div class="row listflim">
            <?php
            echo "<h3 style=\"text-align:center\" id='films'>DANH SÁCH YÊU THÍCH</h3>";
            $sql = "SELECT MaF FROM Favorite WHERE MaUser=?";
            try {
                $stmt = $dbCon->prepare($sql);
                $stmt->execute(array($userID));
            } catch (PDOException $ex) {
                die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
            }
            if ($stmt->rowCount() > 0) {
                while ($row1 = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $Ma = $row1['MaF'];
                    $sql1 = 'SELECT * FROM film WHERE MaF=?';
                    try {
                        $stmt1 = $dbCon->prepare($sql1);
                        $stmt1->execute(array($Ma));
                    } catch (PDOException $ex) {
                        die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
                    }
                    if ($stmt1->rowCount() > 0) {
                        while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                            $preDetails = '';
                            if (isset($pre))
                                if (str_contains($pre, 'MaF')) {
                                    $MaF = $_GET['MaF'];
                                    $pre = str_replace('MaF=' . $MaF, 'MaF=' . $row['MaF'], $pre);
                                } else {
                                    $preDetails = $pre . "&MaF=" . $row['MaF'];
                                }
                            if ($preDetails == '') {
                                $preDetails = "?MaF=" . $row['MaF'];
                            }
                            echo "<div class=\"col-xs-6 col-sm-4 col-md-3 col-lg-2\">";
                            echo "<div class=\"cardFilm\">";
                            echo "<div class=\"cardimg\" style=\"background-image: url(" . $row['Images'] . ")\"></div>";
                            echo "<div class=\"cardinfo\">";
                            echo "<p class=\"texttitle\">" . $row['Names'] . "</p>";
                            $vote = "";
                            for ($i = 1; $i <= 10; $i++) {
                                if ($i > $row['Rating']) {
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
                    } else
                        echo "<b style=\"text-align:center\">Không tìm thấy!</b>";
                }
            } else {
                echo "<b style=\"text-align:center\">Không tìm thấy!</b>";
            }
            ?>
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