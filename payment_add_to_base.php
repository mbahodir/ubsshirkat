 <?php 
    // mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    require_once('connection.php');
    $consumer_id = $_POST['consumer_id'];
    $oper_day = $_POST['oper_day'];
    $payment_sum = $_POST['payment_sum'];
    $description = $_POST['description'];
    $query = "INSERT INTO payments (consumer_id, oper_day, debet_sum, payment_sum, description) VALUES ('$consumer_id', '$oper_day', 0, '$payment_sum', '$description')";
    $ins_payment = mysqli_query($connection, $query);
    if ($ins_payment){
        echo $query;
    } else {
        echo mysqli_error($connection);
    }
    $connection -> close();
?>
