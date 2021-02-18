<?php

	session_start();
	
	if ((!isset($_POST['login'])) || (!isset($_POST['password']))) {
		header('Location: index.php');
		exit();
	}	
	require_once "connect.php"; 	
	$connect_with = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($connect_with ->connect_errno!=0) {
		echo "Error: ".$connect_with ->connect_errno;
	} // connect_errno != 0 if error exists/
	else {
		$login = $_POST['login'];
		$password = $_POST['password'];	
		$login = htmlentities($login, ENT_QUOTES,"UTF-8");

		if ($effect = @$connect_with ->query(sprintf("SELECT * FROM sim_kot WHERE user='%s'",	
		
		mysqli_real_escape_string($connect_with ,$login)))) {
			$user_number = $effect->num_rows;
			if($user_number>0) {
				$rows = $effect->fetch_assoc();	
				if (password_verify($password, $rows['pass'])){
					$_SESSION['zalogowany'] = true;
					$_SESSION['id'] = $rows['id'];
					$_SESSION['user'] = $rows['user'];
					$_SESSION['money'] = $rows['money'];
					$_SESSION['soldiers'] = $rows['soldiers'];
					$_SESSION['food'] = $rows['food'];
					$_SESSION['email'] = $rows['email'];
					$_SESSION['premium'] = $rows['premium'];
					unset($_SESSION['error']);
				$effect->free_result();
				header('Location: gra.php');	}
				else{
					$_SESSION['error'] ='<span style="color:red">Nieprawidłowy login lub hasło!</span>';
					header('Location: index.php');
					}
				} else {
					$_SESSION['error'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
					header('Location: index.php');
				}
			}	
		$connect_with ->close();				
	}	
?>
	