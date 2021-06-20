 <?php 
    // mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    require_once('connection.php');
    $payment_id = $_POST['payment_id'];
    $debet_sum = $_POST['debet_sum'];
    $payment_sum = $_POST['payment_sum'];
    (isset($_POST['description'])) ? $description = $_POST['description'] : $description = '';
    $query = "UPDATE payments
                    SET debet_sum = '$debet_sum', payment_sum = '$payment_sum', description = '$description'
                    WHERE id = " . $payment_id;
    $upd_payment = mysqli_query($connection, $query);
    $query = "INSERT INTO payment_history (payment_id, consumer_id, oper_day, upd_day, debet_sum, payment_sum, description, state)
                    SELECT id, consumer_id, oper_day, now(), debet_sum, payment_sum, description, 'UPD'
                        FROM payments
                        WHERE id = " . $payment_id;
    $ins_payment_history = mysqli_query($connection, $query);
    if ($ins_payment_history){
        echo 1;
    } else {
        echo mysqli_error($connection);
    }
    $connection -> close();
?>
