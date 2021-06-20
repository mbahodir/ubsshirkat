<?php
    require_once('connection.php');
    $query_consumer = 'SELECT owner FROM consumers WHERE id = ' . $_POST['consumer_id'];
    $select_consumer = mysqli_query($connection, $query_consumer);
    $consumer = mysqli_fetch_assoc($select_consumer);
    echo $consumer['owner'];
?>