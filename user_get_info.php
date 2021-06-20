<?php 
    session_start();
    require_once('connection.php');
    $i = 0;
    $query = 'SELECT * FROM users WHERE id = ' . $_POST['userId'];
    $select_user_info = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($select_user_info))
    {
        $arr[$i] = array
                    ('id' => $row['id'], 
                     'surename' => $row['surename'],
                     'name' => $row['name'],
                     'middlename' => $row['middlename'],
                     'phone' => $row['phone'],
                     'email' => $row['email'],
                     'username' => $row['username'],
                     'password' => $row['password']
                    );
        $i++;
    }
    echo JSON_encode($arr);
    $connection -> close();
?>  
