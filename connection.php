<?php
 $connection = mysqli_connect('127.0.0.1','root', '','xujmsh');
//$connection = mysqli_connect('127.0.0.1','root', '');
$select_shirkat = mysqli_select_db($connection,'xujmsh');
if ($connection == false) 
{
  echo "База билан боғланмади <br>";
  echo mysqli_connect_error();
  exit;
}

?>