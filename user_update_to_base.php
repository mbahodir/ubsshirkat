<?php 
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); 
    session_start();
    require_once('connection.php');
    $path = ''; $hre = 'consumer_form.php';
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
    switch ($_GET['change']) {
        case 'data':
            if (isset($_POST['surename']) || isset($_POST['name']) || isset($_POST['middlename']) || isset($_POST['phone']) || isset($_POST['email'])){
                $surename = $_POST['surename'];
                $name = $_POST['name'];
                $middlename = $_POST['middlename'];
                $phone = $_POST['phone'];
                $email = $_POST['email'];
        /*        if (isset($_FILES['photo']['name'])){
                    $path = 'uploads/' . time() . $_FILES['photo']['name'];
                    @move_uploaded_file($_FILES["photo"]['tmp_name'],$path);
                    if ( $_FILES['photo']['error'] > 0 ) {
                        $_SESSION['message'] = $err[$_FILES['photo']['error']][$i];
                    }
                }
                   else {$_SESSION['message'] = $err[11];}*/
        //        $ins_user=1;
                    $query = "UPDATE users SET surename = '$surename', name = '$name', middlename = '$middlename', phone = '$phone', email = '$email' WHERE id = " . $_SESSION['user_id'];
                    $update_user_info = mysqli_query($connection, $query);
                } else {$_SESSION['message'] = $err[10][$i] . ' ' . mysqli_error($connection);}
                $connection -> close();
            break;
        case 'login':
            if (isset($_POST['username'])){
                $username = $_POST['username'];
                    $query = "UPDATE users SET username = '$username' WHERE id = " . $_SESSION['user_id'];
                    $update_user_info = mysqli_query($connection, $query);
                } else {$_SESSION['message'] = $err[10][$i] . ' ' . mysqli_error($connection);}
                $connection -> close();
            break;
        case 'psw':
            if (isset($_POST['psw'])){
                $password = md5($_POST['psw']);
                 $query = "UPDATE users SET password = '$password' WHERE id = " . $_SESSION['user_id'];
                    $update_user_info = mysqli_query($connection, $query);
                } else {$_SESSION['message'] = $err[10][$i] . ' ' . mysqli_error($connection);}
                $connection -> close();
            break;
    }
    header('Location: ' . $hre);
?>  
