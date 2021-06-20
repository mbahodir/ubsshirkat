<?php
  require_once('connection.php');
  $query_payment = "SELECT * FROM payments WHERE id = " . $_POST['payment_id'];
  $select_payment = mysqli_query($connection, $query_payment);
  $paymentrow = mysqli_fetch_assoc($select_payment);
  $payment =
  [
    'oper_day' => date('d.m.Y', strtotime($paymentrow['oper_day'])),
    'debet_sum' => $paymentrow['debet_sum'],
    'payment_sum' => $paymentrow['payment_sum'],
    'description' => $paymentrow['description']
  ];
  echo json_encode($payment);
  $connection -> close();
?>