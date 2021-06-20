<?php
  require_once('connection.php');
  $query_payment = "SELECT * FROM payment_history WHERE consumer_id = " . $_POST['cons_id'] . " AND payment_id = " . $_POST['payment_id'];
  $select_payments = mysqli_query($connection, $query_payment);
  $paymentsrowsnum = mysqli_num_rows($select_payments);
  $tr = 1;
  while ($tr <= $paymentsrowsnum) {
    $paymentsrows = mysqli_fetch_assoc($select_payments);
    $payment =
    [
      'oper_day' => date('d.m.Y', strtotime($paymentsrows['oper_day'])),
      'debet_sum' => $paymentsrows['debet_sum'],
      'payment_sum' => $paymentsrows['payment_sum'],
      'description' => $paymentsrows['description'],
      'upd_day' => date('d.m.Y', strtotime($paymentsrows['upd_day']))
    ];
    $payments[] = $payment;
    $tr++;
  }
  echo json_encode($payments);
  $connection -> close();
?>