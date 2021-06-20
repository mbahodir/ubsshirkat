 <?php 
    require('connection.php');
    if (isset($_POST['mahalla']) && isset($_POST['name']))
    {
        $id_region =$_POST['id_region'];
        $id_district = $_POST['id_district'];
        $mahalla = $_POST['mahalla'];
        $name = $_POST['name'];
        $user_id = $_POST['user_id'];
        $query = "INSERT INTO shirkats (user_id, region_id, district_id, mahalla, name)
                        VALUES ('$user_id', '$id_region', '$id_district', '$mahalla', '$name')";
        $ins_shrk = mysqli_query($connection, $query); 
        $ins_shrk = mysqli_query($connection, 'SELECT id FROM shirkats ORDER BY id DESC');
        $ins_shrk = mysqli_fetch_assoc($ins_shrk);
        echo json_encode($ins_shrk['id']);
        $connection -> close();
    } else echo $_POST['msgerr'];
?>
