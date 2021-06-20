 <?php
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    require_once('connection.php');
    $consumer_id = $_POST['cons_id'];
    $owner = $_POST['owner'];
    $street = $_POST['street'];
    $house = $_POST['house'];
    $flat = $_POST['flat'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $flattype_id = $_POST['flattype_id'];
    $sign_auto_calc = $_POST['sign_auto_calc'];
    $calc_start_day = $_POST['calc_start_day'];
    $query = "UPDATE consumers
                SET flattype_id = '$flattype_id', street = '$street', house = '$house', flat = '$flat', code = CONCAT(shirkat_id, '$house', '$flat'), owner = '$owner', phone = '$phone', email = '$email', sign_auto_calc = '$sign_auto_calc', calc_start_day = '$calc_start_day'
                WHERE id = " . $consumer_id;
    $ins_consumer = mysqli_query($connection, $query);
    if ($ins_consumer){
        echo 1;
    } else {
        echo mysqli_error($connection);
    }
    $connection -> close();
?>
