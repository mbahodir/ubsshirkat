<?php
    $login=$_POST['login'];
    require_once('connection.php');
    if (isset($login)) {
        $query = "select login from users where login='$login'";
        $select_login=mysqli_query($connection,$query);
        $checklogin = mysqli_num_rows($select_login);
        echo $checklogin;
   
    }

?>