<?php 
// mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); 
    require('connection.php');
    if (isset($_POST['type']) && isset($_POST['month_debet_sum']) && isset($_POST['field'])) {
        $shirkat_id = $_POST['shirkatId'];
        $type = $_POST['type'];
        $month_debet_sum = $_POST['month_debet_sum'];
        $field = $_POST['field'];
        $query = "INSERT INTO flattypes (shirkat_id, type, month_debet_sum, field) VALUES ('$shirkat_id', '$type', '$month_debet_sum', '$field')";
        $ins_shrk = mysqli_query($connection, $query); 
        echo 1;
        $connection -> close();
    } else echo json_encode($_POST['msgerr']);
?>
