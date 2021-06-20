<?php
    $password=$_POST['password'];
    require_once('connection.php');
    if (isset($password)) {
        $query = "select psw from users where psw='$password'";
        $select_password=mysqli_query($connection,$query);
        $checkpsw = mysqli_num_rows($select_password);
        echo $checkpsw;
        
    }

?>