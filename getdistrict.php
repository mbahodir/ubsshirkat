<?php
	require_once('connection.php');
	$i = 0;
	$district_sql = mysqli_query($connection, 'SELECT * FROM districts WHERE region_id = ' . $_POST['region_id']);
	while ($r3 = mysqli_fetch_assoc($district_sql))
        {
            $arr[$i] = array('id' => $r3['id'], 'name' => $r3['name']);
            $i++;
        }
	echo json_encode($arr);
	$connection -> close();
?>
