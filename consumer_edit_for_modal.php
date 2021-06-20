<?php
  require_once('connection.php');
  
  $query_consumer = "SELECT * FROM consumers WHERE id = " . $_POST['cons_id'];
  $select_consumer = mysqli_query($connection, $query_consumer);
  $consumerrow = mysqli_fetch_assoc($select_consumer);

  $query_flattype = "SELECT * FROM flattypes WHERE id = " . $consumerrow['flattype_id'];
  $select_flattype = mysqli_query($connection, $query_flattype);
  $flattyperow = mysqli_fetch_assoc($select_flattype);
  $flat_id = $flattyperow['id'];
  $type = $flattyperow['type'];

  $query_flattype = "SELECT * FROM flattypes WHERE shirkat_id = " . $consumerrow['shirkat_id'];
  $select_flattype = mysqli_query($connection, $query_flattype);
    while ($flattyperow = mysqli_fetch_assoc($select_flattype))
      {$flattypes[] = ['id' => $flattyperow['id'], 'type' => $flattyperow['type']];}
  $consumer = [
    'owner' => $consumerrow['owner'],
    'street' => $consumerrow['street'],
    'house' => $consumerrow['house'],
    'flat' => $consumerrow['flat'],
    'phone' => $consumerrow['phone'],
    'email' => $consumerrow['email'],
    'flat_id' => $flat_id,
    'type' => $type,
    'flattypes' => $flattypes,
    'sign_auto_calc' => $consumerrow['sign_auto_calc'],
    'calc_start_day' => $consumerrow['calc_start_day']
  ];
  echo json_encode($consumer);
  $connection -> close();
?>