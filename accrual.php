 <?php 
    // mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    require_once('connection.php');
    $oper_day = $_POST['oper_day'];
    $shirkatid = $_POST['shirkatid'];
    $description = $_POST['description'];
    $query = "SELECT * FROM payments p, consumers c
                WHERE c.id = p.consumer_id
                AND c.shirkat_id = '$shirkatid'
                AND p.debet_sum > 0
                AND concat(month(p.oper_day), year(p.oper_day)) = " . date('n', strtotime($oper_day)). date('Y', strtotime($oper_day));
    $accrual_yes = mysqli_query($connection, $query);
    $accrual_yesrowsnum = mysqli_num_rows($accrual_yes);        
    if ($accrual_yesrowsnum == 0) {
            $query = "INSERT INTO payments (consumer_id, oper_day, debet_sum, payment_sum, record_accrual, description) 
                        SELECT c.id, '$oper_day', f.month_debet_sum, 0, 1, '$description'
                        FROM flattypes f, consumers c
                        WHERE f.id = c.flattype_id
                        AND f.month_debet_sum > 0
                        AND c.sign_auto_calc = 'Y'
                        AND c.shirkat_id = '$shirkatid'";
            $accrual = mysqli_query($connection, $query);
            if ($accrual){
                echo 1;
            } else {
                echo mysqli_error($connection);
            }
    } else {
        echo 0;
    }
    $connection -> close();
?>
