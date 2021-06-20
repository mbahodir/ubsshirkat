<?php
	session_start();
	require_once 'connect.php';

	$login = $_POST['login'];
	$password = md5($_POST['password']);

	$query = "SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'";
	$check_query = mysqli_query($connection, $query);
	$rows = mysqli_num_rows($check_query);
	
	if ( $rows > 0 ) {
		$user = mysqli_fetch_assoc($check_query);

		$_SESSION['user'] = [
			"id" => $user['id'],
			"user_type" => $user['user_type'], 
			"id_shirkat" => $user['id_shirkat'], 
			"full_name" => $user['full_name'], 
			"mobile_phone" => $user['mobile_phone'], 
			"email" => $user['email'], 
			"login" => $user['login'], 
			"password" => $user['password'], 
			"avatar" => $user['avatar']
		];

		echo json_encode('Кейинги формага кириш');
	} else {
		echo json_encode('Логин ёки парол нотугри!');
	}
?>