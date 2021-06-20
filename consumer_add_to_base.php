 <?php 
    // mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    require_once('connection.php');
    $shirkat_id = $_POST['shirkatId'];
    $district_id = $_POST['districtId'];
    $owner = $_POST['owner'];
    $street = $_POST['street'];
    $house = $_POST['house'];
    $flat = $_POST['flat'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $flattype_id = $_POST['flattype_id'];
    $code = $district_id . $shirkat_id . $house . $flat;
    $query = 'SELECT * FROM consumers WHERE code = ' . $code;
    $select_code = mysqli_query($connection, $query);
    $checkcode = mysqli_num_rows($select_code);
    if ($checkcode > 0) {
        echo 0;
    } else {
        $query = "INSERT INTO consumers (shirkat_id, flattype_id, street, house, flat, code, owner, phone, email)
                        VALUES ('$shirkat_id', '$flattype_id', '$street', '$house', '$flat', '$code', '$owner', '$phone', '$email')";
        $ins_consumer = mysqli_query($connection, $query);
        if ($ins_consumer){
            echo 2;
        } else {
            echo mysqli_error($connection);
        }        
      }
    // if (($owner != '') && ($street != '')
    //     && ($house != '') && ($flat != '')
    //     && ($phone != '') && ($flattype_id != 0))
    // {
    //     $query = "INSERT INTO consumers (shirkat_id, flattype_id, street, house, flat, code, owner, phone, email)
    //                     VALUES ('$shirkat_id', '$flattype_id', '$street', '$house', '$flat', '$code', '$owner', '$phone', '$email')";
    //     $ins_consumer = mysqli_query($connection, $query);
    //     if ($ins_consumer){
    //         echo 1;
    //     } else {
    //         echo mysqli_error($connection);
    //     }
    // } else echo 1;
    $connection -> close();
?>
