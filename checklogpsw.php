<?php
    // mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); 
    session_start();
    $_SESSION['user_id'] = ''; unset($_SESSION['user_id']);
    $_SESSION['shirkat_id'] = ''; unset($_SESSION['shirkat_id']);
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    require('connection.php');
    $query = "SELECT id FROM users WHERE username = '$username' AND password = '$password'";
    $select_login_password = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($select_login_password);
    $_SESSION['user_id'] = $row['id'];
    $checklogpsw = mysqli_num_rows($select_login_password);
    if ($checklogpsw > 0) {
        $query_shirkat = "SELECT * FROM shirkats WHERE user_id = " . $row['id'];
        $select_shirkat = mysqli_query($connection, $query_shirkat);
        $checkshirkat = mysqli_num_rows($select_shirkat);
        if ($checkshirkat > 0) {
            $row = mysqli_fetch_assoc($select_shirkat);
            $_SESSION['shirkat_id'] = $row['id'];
            $_SESSION['mahalla'] = $row['mahalla'];
            $_SESSION['name_shirkat'] = $row['name'];
            $_SESSION['region_id'] = $row['region_id'];
            $_SESSION['district_id'] = $row['district_id'];
                $query_region = "SELECT * FROM regions WHERE id = " . $_SESSION['region_id'];
                $select_region = mysqli_query($connection, $query_region);
                $regionrow = mysqli_fetch_assoc($select_region);
                $query_district = "SELECT * FROM districts WHERE id = " . $_SESSION['district_id'];
                $select_district = mysqli_query($connection, $query_district);
                $districtrow = mysqli_fetch_assoc($select_district);
            $_SESSION['name_region'] = $regionrow['name'];
            $_SESSION['name_district'] = $districtrow['name'];
                $query_flattype = "SELECT id FROM flattypes WHERE shirkat_id = " . $row['id'];
                $select_flattype = mysqli_query($connection, $query_flattype);
                $checkflattype = mysqli_num_rows($select_flattype);
            if ($checkflattype > 0) {echo 1;} else {echo 2;}
        } else {echo 0;}
    } else echo "loginpswwrong";
    $connection -> close();
?>