<?php
  require_once('connection.php');
  $query_consumer = "SELECT c.*, (
                      SELECT SUM(debet_sum) - SUM(payment_sum) FROM payments p WHERE p.oper_day >= c.calc_start_day AND p.consumer_id = c.id 
                                 ) 
                     AS balance FROM consumers c WHERE c.shirkat_id = " . $_POST['shirkatId'] . ' AND id = ' . $_POST['consumer_id'];
  $select_consumer = mysqli_query($connection, $query_consumer);
  $consumerrow = mysqli_fetch_assoc($select_consumer);
  $query_flattype = "SELECT * FROM flattypes WHERE id = " . $consumerrow['flattype_id'];
  $select_flattype = mysqli_query($connection, $query_flattype);
  $flattyperow = mysqli_fetch_assoc($select_flattype);
  $consumer =
  [
  	'consumer_id' => $_POST['consumer_id'],
    'owner' => $consumerrow['owner'],
    'street' => $consumerrow['street'],
    'house' => $consumerrow['house'],
    'flat' => $consumerrow['flat'],
    'code' => $consumerrow['code'],
    'phone' => $consumerrow['phone'],
    'email' => $consumerrow['email'],
    'type' => $flattyperow['type'],
    'month_debet_sum' => $flattyperow['month_debet_sum'],
  	'balance' => $consumerrow['balance']
  ];
  echo json_encode($consumer);
  $connection -> close();
?>