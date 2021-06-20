<?php
  require_once('connection.php');
  $query_consumer = "SELECT * FROM consumers WHERE id = " . $_POST['cons_id'];
  $select_consumer = mysqli_query($connection, $query_consumer);
  $consumerrow = mysqli_fetch_assoc($select_consumer);
  $query_flattype = "SELECT * FROM flattypes WHERE id = " . $consumerrow['flattype_id'];
  $select_flattype = mysqli_query($connection, $query_flattype);
  $flattyperow = mysqli_fetch_assoc($select_flattype);
  $consumer = [
    'owner' => $consumerrow['owner'],
    'street' => $consumerrow['street'],
    'house' => $consumerrow['house'],
    'flat' => $consumerrow['flat'],
    'phone' => $consumerrow['phone'],
    'email' => $consumerrow['email'],
    'type' => $flattyperow['type']
  ];
  echo json_encode($consumer);
  $connection -> close();
?>