<?php

	session_start();
	
	/*if (!isset($_SESSION['good_connection'])) {
		header('Location: index.php');
		exit();
	} else {
		unset($_SESSION['good_connection']);
	}*/
	
	// unset $_SESSION
	if (isset($_SESSION['fr_nick'])) unset($_SESSION['fr_nick']);
	if (isset($_SESSION['fr_email'])) unset($_SESSION['fr_email']);
	if (isset($_SESSION['fr_password1'])) unset($_SESSION['fr_password1']);
	if (isset($_SESSION['fr_password2'])) unset($_SESSION['fr_password2']);
	if (isset($_SESSION['fr_statute'])) unset($_SESSION['fr_statute']);
	
	//unset errors
	if (isset($_SESSION['e_nick'])) unset($_SESSION['e_nick']);
	if (isset($_SESSION['e_email'])) unset($_SESSION['e_email']);
	if (isset($_SESSION['e_password'])) unset($_SESSION['e_password']);
	if (isset($_SESSION['fr_password2'])) unset($_SESSION['fr_password2']);
	if (isset($_SESSION['e_statute'])) unset($_SESSION['e_statute']);
	if (isset($_SESSION['e_bot'])) unset($_SESSION['e_bot']);
			
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="Content-Security-Policy" content="default-src *;
   		img-src * 'self' data: https:; script-src 'self' 'unsafe-inline' 'unsafe-eval' *;
   		style-src  'self' 'unsafe-inline' *">
	<title>Sim Kot - gra przeglądarkowa</title>
	<link rel="stylesheet" href="style2.css" type="text/css"/>
</head>

<body>
	
	<div class="container welcome">
		Dziękujemy za rejestracje w serwisie! Możesz już zalogować się na swoje konto!
		<a href="index.php">Zaloguj się na swoje konto!</a>
	</div>
	
</body>
</html>
