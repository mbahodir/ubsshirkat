<?php
// mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); 
    session_start();
    require_once('connection.php');
    $user_id = $_SESSION['user_id'];$shirkat_id = $_SESSION['shirkat_id'];
    $query_consumers = "SELECT c.*, (SELECT 
                                        CASE WHEN SUM(debet_sum) - SUM(payment_sum) <> 'NULL' THEN SUM(debet_sum) - SUM(payment_sum)
                                             ELSE 0
                                        END
                                     FROM payments p 
                                     WHERE p.oper_day >= c.calc_start_day AND p.consumer_id = c.id)
                                     AS balance
                        FROM consumers c WHERE c.shirkat_id = " . $shirkat_id;
    $select_consumers = mysqli_query($connection, $query_consumers);
    $consumersrowsnum = mysqli_num_rows($select_consumers);
    if ($consumersrowsnum > 0) {
        $tr = 1;
        while ($tr <= $consumersrowsnum) {
            $consumersrows = mysqli_fetch_assoc($select_consumers);
            $id = ($consumersrows['id']);
            $street = ($consumersrows['street']);
            $house = ($consumersrows['house']);
            $flat = ($consumersrows['flat']);
            $code = ($consumersrows['code']);
            $owner = ($consumersrows['owner']);
            $phone = ($consumersrows['phone']);
            // $email = ($consumersrows['email']);
            $sign_auto_calc = ($consumersrows['sign_auto_calc']);
            $balance = ($consumersrows['balance']);
                $query_flattype = "SELECT * FROM flattypes WHERE id = " . $consumersrows['flattype_id'];
                $select_flattype = mysqli_query($connection, $query_flattype);
                $flattypesrows = mysqli_fetch_assoc($select_flattype);
            $type = $flattypesrows['type'];
            $month_debet_sum = $flattypesrows['month_debet_sum'];
            $consumer = 
            [
                'id' => $id,
                'street' => $street,
                'house' => $house,
                'flat' => $flat,
                'code' => $code,
                'owner' => $owner,
                'phone' => $phone,
                'month_debet_sum' => $month_debet_sum,
                'balance' => $balance,
                'type' => $type
            ];
            $consumers[] = $consumer;
            $tr++;
        }
        $consumers = json_encode($consumers);
        echo $consumers;
    } else echo json_encode('flattype_empty');
    $connection -> close();
?>       