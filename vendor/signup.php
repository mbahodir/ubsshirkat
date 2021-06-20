<?php
	
	session_start();
	require_once 'connect.php';

	$user_type = $_POST['user_type'];
	$id_shirkat = $_POST['id_shirkat'];
	$full_name = $_POST['full_name'];
	$mobile_phone = $_POST['mobile_phone'];
	$email = $_POST['email'];
	$login = $_POST['login'];
	$password = $_POST['password'];
	$password_confirm = $_POST['password_confirm'];

	if ($password === $password_confirm) {

		// $_FILES['Avatar']['name']
		$path = 'uploads/' . time() . $_FILES['avatar']['name'];
		if (!move_uploaded_file($_FILES['avatar']['tmp_name'], '../' . $path)) {
			$_SESSION['message'] = 'Профил расмини юклашда хатолик';
			header('location: ../register.php');
		}
		$password = md5($password);

		$query = "INSERT INTO users (user_type, id_shirkat, full_name, mobile_phone, email, login, password, avatar) 
				  VALUES ('$user_type','$id_shirkat','$full_name','$mobile_phone','$email', '$login', '$password', '$path')";
		$result = mysqli_query($connection, $query);
		// $_SESSION['message'] = 'Рўйхатдан ўтиш муваффақиятли амалга ошди';
		// header('location: ../index.php');
		echo json_encode('Рўйхатдан ўтиш муваффақиятли амалга ошди');
	} else {
		// $_SESSION['message'] = 'Пароллар мос келмади';
		// header('location: ../register.php');
		echo json_encode('Пароллар мос келмади');
	}
?>
