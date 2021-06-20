<?php
    $username = $_POST['username'];
    require_once('connection.php');
    if (isset($username)) {
        $query = "SELECT username
			        FROM users
			        WHERE username = '$username'";
        $select_login = mysqli_query($connection, $query);
        $checklogin = mysqli_num_rows($select_login);
        $connection -> close();
        echo $checklogin;
    }
?>