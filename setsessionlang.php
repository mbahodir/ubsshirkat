<?php
    session_start();
    $_SESSION['langId'] = $_POST['langId'];
    echo $_SESSION['langId'];
?>