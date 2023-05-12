<?php
require('api/dbConnection.php');
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>PHIM</title>
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

    <!--

    VÍ DỤ NÀY MINH HỌA TÍNH NĂNG RESPONSIVE, KÉO RESIZE TRÌNH DUYỆT WEB ĐỂ XEM KẾT QUẢ
    
    GIẢI THÍCH:
    
    - MÀN HÌNH DESKTOP LỚN: 12 CỘT
    - MÀN HÌNH DESKTOP: 6 CỘT
    - MÀN HÌNH MÁY TÍNH BẢNG: 3 CỘT
    - MÀN HÌNH ĐIỆN THOẠI: 2 CỘT

    xs = extra small = màn hình điện thoại
    sm = small = màn hình máy tính bảng
    md = medium = màn hình desktop nhỏ
    lg = larger = màn hình máy tính độ phân giải cao

    col-xs-6 có nghĩa là nếu chạy trên màn hình điện thoại (xs) thì cột này có độ rộng là 6/12 (nữa màn hình ==> 2 cột / dòng)
    col-sm-4 có nghĩa là nếu chạy trên màn hình máy tính bảng (sm) thì cột này có độ rộng là 4/12 (1/3 màn hình ==> có 3 cột/dòng)
    col-md-2 có nghĩa là nếu chạy trên màn hình máy tính nhỏ (md) thì cột này có độ rộng là 2/12 (1/6 màn hình ==> có 6 cột/dòng)
    col-lg-1 có nghĩa là nếu chạy trên màn hình máy tính phân giải cao (lg) thì cột này có độ rộng là 1/12 (1/12 màn hình ==> có 12 cột/dòng)


 -->
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
                            <a class="nav-link" href="<?php echo (isset($userID)) ? "films.php?us=" . $userID : "films.php"; ?>" style="color: red"><b>Phim</b></a>
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

    <!-- buộc toàn bộ dòng và cột phải bỏ trong class text -->
    <div class="container" style="margin-top:20px;" id="films">
        <h1 class="row" style="text-align:center"><b>Phim Mới Nhất</b></h1>
        <form class="filter" action="" method="post">
            <label class="filterKind"> Thể loại</label>
            <select name="type" id="selectType">
                <option value="Chọn thể loại..." selected>
                    <?php
                    require_once('api/dbConnection.php');
                    $sql = 'SELECT * FROM genres'; // NƠI LẤY DATA
                    try {
                        $stmt = $dbCon->prepare($sql);
                        $stmt->execute();
                    } catch (PDOException $ex) {
                        die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
                    }
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        if (isset($_POST['typeFromHome'])) {
                            echo 'asduighaduiyaeduia';
                            echo '<option value="' . $row['MaTL'] . '"selected>' . $row['Genre'] . '</option>';
                        } else
                            echo '<option value="' . $row['MaTL'] . '">' . $row['Genre'] . '</option>';
                    }
                    ?>
            </select>

            <button class="btn-find" type="submit" name="find">Tìm kiếm</button>


        </form>
        <!-- dòng phải là con trực tiếp của text, mang class row -->
        <div class="row listflim">
            <?php
            $check = false;
            if (isset($_POST['find']) || isset($_GET['type'])) {
                $check = true;
                if (!empty($_POST['type']) || !empty($_GET['type'])) {
                    $MaTL = (!empty($_POST['type'])) ? $_POST['type'] : $_GET['type'];
                    $sql1 = 'SELECT * FROM film_genre WHERE MaTL=?'; // NƠI LẤY DATA
                    try {
                        $stmt1 = $dbCon->prepare($sql1);
                        $stmt1->execute(array($MaTL));
                    } catch (PDOException $ex1) {
                        die(json_encode(array('status' => false, 'data' => $ex1->getMessage())));
                    }
                    $sql = 'SELECT Genre FROM Genres WHERE MaTL=?'; // NƠI LẤY DATA
                    try {
                        $stmt = $dbCon->prepare($sql);
                        $stmt->execute(array($MaTL));
                    } catch (PDOException $ex1) {
                        die(json_encode(array('status' => false, 'data' => $ex1->getMessage())));
                    }
                    if ($stmt->rowCount() > 0) {
                        echo "<h3 style='text-align: center;' id='films'>Thể Loại phim: " . $stmt->fetch(PDO::FETCH_ASSOC)['Genre'] . "</h3>";
                    }
                    while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                        $preDetails = '';
                        if (isset($pre))
                            if (isset($userID)) {
                                $preDetails = "?us=" . $userID . "&" . "MaF=" . $row1['MaF'];
                            } else {
                                $preDetails = "?MaF=" . $row1['MaF'];
                            }
                        if ($preDetails == '') {
                            $preDetails = "?MaF=" . $row1['MaF'];
                        }
                        $sql2 = 'SELECT * FROM film WHERE MaF=?'; // NƠI LẤY DATA
                        try {
                            $stmt2 = $dbCon->prepare($sql2);
                            $stmt2->execute(array($row1['MaF']));
                        } catch (PDOException $ex1) {
                            die(json_encode(array('status' => false, 'data' => $ex1->getMessage())));
                        }
                        $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                        echo '
                                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                    <div class="cardFilm">
                                        <div class="cardimg" style="background-image: url(' . $row2['Images'] . ');"></div>
                                        <div class="cardinfo">
                                            <p class="texttitle">' . $row2['Names'] . '</p>
                                            <p class="textbody">Chi tiết</p>
                                            <a href="details.php' . $preDetails . '"><button class="cardbutton">Xem phim</button></a>
                                        </div>
                                    </div>
                                </div>
                            ';
                    }
                }
            }
            if (!$check) {
                $sql3 = 'SELECT * FROM film'; // NƠI LẤY DATA
                try {
                    $stmt3 = $dbCon->prepare($sql3);
                    $stmt3->execute();
                } catch (PDOException $ex1) {
                    die(json_encode(array('status' => false, 'data' => $ex1->getMessage())));
                }
                while ($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)) {
                    $preDetails = '';
                    if (isset($pre))
                        if (isset($userID)) {
                            $preDetails = "?us=" . $userID . "&" . "MaF=" . $row3['MaF'];
                        } else {
                            $preDetails = "?MaF=" . $row3['MaF'];
                        }
                    if ($preDetails == '') {
                        $preDetails = "?MaF=" . $row3['MaF'];
                    }
                    echo '
                            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                <div class="cardFilm">
                                    <div class="cardimg" style="background-image: url(' . $row3['Images'] . ');"></div>
                                    <div class="cardinfo">
                                        <p class="texttitle">' . $row3['Names'] . '</p>
                                        <p class="textbody">Chi tiết</p>
                                        <a href="details.php' . $preDetails . '"><button class="cardbutton">Xem phim</button></a>
                                    </div>
                                </div>
                            </div>
                        ';
                }
            }



            ?>

        </div> <!-- Kết thúc dòng 1 -->

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