<?php
// mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); 
    session_start();
    require_once('connection.php');
    $path = ''; $hre = 'user_sign_up.php';
    unset($_SESSION['message']); $i = $_SESSION['langId'];
    $err[1] = array('Файл ҳажми ўрнатилган миқдордан катта!', 'Fayl hajmi o\'rnatilgan miqdordan katta!', 'Размер загружаемого файла превысил значение!', 'Upload file size exceeded!');
    $err[2] = array('Файл ҳажми ўрнатилган миқдордан катта!', 'Fayl hajmi o\'rnatilgan miqdordan katta!', 'Размер загружаемого файла превысил значение!', 'Upload file size exceeded!');
    $err[3] = array('Файл тўлиқ қабул қилинмади!', 'Fayl to\'liq qabul qilinmadi!', 'Загружаемый файл был получен только частично', 'The download file was received only partially!');
    $err[4] = array('Файл юкланмади!', 'Fayl yuklanmadi!', 'Файл не загружен!', 'File not loaded!');
    $err[5] = '';
    $err[6] = array('Вақтинчалик каталог мавжуд эмас!', 'Vaqtinchalik katalog mavjud emas!', 'Отсутствует временный каталог!', 'Missing temp directory!');
    $err[7] = array('Файл дискга ёзилмади!', 'Fayl discga yozilmadi!', 'Не удалось записать файл на диск!', 'Failed to write file to disk');
    $err[8] = array('Тизим юклашни тўхтатди!', 'Tizim yuklashni to\'xtatdi!', 'Система остановила загрузку файла!', 'The system has stopped downloading the file!');    
    $err[9] = array('Рўйхатдан муваффақиятли ўтдингиз!', 'Ro\'yxataddan muvaffaqiyatli o\'tdingiz!', 'Регистрация прошла успешно!', 'registration completed successfully');    
    $err[10] = array('Рўйхатга олишда хатолик!', 'Ro\'yxatga olishda xatolik!', 'Ошибка регистрации!', 'Registration error!');
    if (isset($_POST['name']) && isset($_POST['username']) && isset($_POST['psw'])){
        $surename = $_POST['surename'];
        $name = $_POST['name'];
        $middlename = $_POST['middlename'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = md5($_POST['psw']);
/*        if (isset($_FILES['photo']['name'])){
            $path = 'uploads/' . time() . $_FILES['photo']['name'];
            @move_uploaded_file($_FILES["photo"]['tmp_name'],$path);
            if ( $_FILES['photo']['error'] > 0 ) {
                $_SESSION['message'] = $err[$_FILES['photo']['error']][$i];
            }
        }
           else {$_SESSION['message'] = $err[11];}*/
//        $ins_user=1;
        $query = "INSERT INTO users (surename, name, middlename, phone, email, username, password) 
                  VALUES ('$surename', '$name', '$middlename', '$phone', '$email', '$username', '$password')";
        $ins_user = mysqli_query($connection, $query);
        if (mysqli_error($connection) == '') 
        {   $query = "SELECT id FROM users WHERE username = '$username' AND password = '$password'";
            $select_login_password = mysqli_query($connection, $query);
            $row = mysqli_fetch_assoc($select_login_password);
            $query_upd = "UPDATE users SET parent_id = " . $row['id'] . "
                          WHERE id = " . $row['id'];
            $select_login_password = mysqli_query($connection, $query_upd);
            $_SESSION['user_id'] = $row['id'];
            $hre = 'shirkat_sign_up.php';
        } else {$_SESSION['message'] = $err[10][$i] . ' ' . mysqli_error($connection);}
        $connection -> close();
        header('Location: ' . $hre);
    }
?>  
