<?php
	require_once('connection.php');
	$i = 0;
	$query = 'SELECT * FROM payments WHERE consumer_id = ' . $_POST['ConsumersId'];
	$payment_sql = mysqli_query($connection, $query);
	if (mysqli_num_rows($payment_sql) > 0) {
		while ($paymentsrow = mysqli_fetch_assoc($payment_sql))
	        {
				$arr[$i] = array
							('id' => $paymentsrow['id'], 
							 'consumer_id' => $paymentsrow['consumer_id'],
							 'oper_day' => $paymentsrow['oper_day'],
							 'debet_sum' => $paymentsrow['debet_sum'],
							 'payment_sum' => $paymentsrow['payment_sum'],
							 'record_accrual' => $paymentsrow['record_accrual'],
							 // 'saldo' => $paymentsrow['saldo'],
							 'description' => $paymentsrow['description']
							);
				$i++;
	        }
	echo json_encode($arr); 
	} else echo 0;
	$connection -> close();
?>
