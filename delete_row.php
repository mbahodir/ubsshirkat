<?php 
    require_once('connection.php');
	$query = 'SELECT ' . $_GET['field'] . ' FROM ' . $_GET['table'] . ' WHERE id = ' . $_GET['id'];
    $select = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($select);
    if ($row) {echo $row[$_GET['field']] . ' - ' . $_GET['deleted'];} else {echo mysqli_error($connection);}
    $query = 'DELETE FROM ' . $_GET['table'] . ' WHERE id = ' . $_GET['id'];
    $del = mysqli_query($connection, $query);
    $connection -> close();
?>
