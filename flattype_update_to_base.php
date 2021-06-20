<?php 
// mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); 
    require('connection.php');
    if (isset($_POST['type']) && isset($_POST['month_debet_sum']) && isset($_POST['field'])) {
        $shirkat_id = $_POST['shirkat_id'];
        $type = $_POST['type'];
        $month_debet_sum = $_POST['month_debet_sum'];
        $field = $_POST['field'];
        $query = " UPDATE flattypes
                    SET type = '$type', month_debet_sum = '$month_debet_sum', field = '$field'
                    WHERE id = " . $_POST['id'];
        $ins_shrk = mysqli_query($connection, $query); 
        echo 1;
        $connection -> close();
    } else echo json_encode($_POST['msgerr']);
?>
