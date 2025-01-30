<?php

	session_start();
	
	if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true)) {
		header('Location: gra.php');
		exit();
	}
	
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="Content-Security-Policy" content="default-src *;
  		img-src * 'self' data: https:; script-src 'self' 'unsafe-inline' 'unsafe-eval' *;
   		style-src  'self' 'unsafe-inline' *">
	<title>Sim Kot - gra przeglądarkowa</title>	
	<link rel="stylesheet" href="style.css" type="text/css"/>
	<link href="https://fonts.googleapis.com/css?family=Lora" rel="stylesheet">	
</head>

<body>
	
	<header>
		<h1>Walcz, negocjuj, inwestuj! Wszystko dla rozbudowy twego miasta</h1>
	</header>

	<section>
		<div class="form-rejestration">
			<a href="rejestracja.php" class="link">
				<div class="rejestration">Załóż darmowe konto!
				</div>
			</a>
	
			<form action="zaloguj.php" method="post">
				Login: <br/> 
				<input type="text" name="login" placeholder="login" onfocus="this.placeholder=''" onblur="this.placeholder='login'"/> <br/>
		
				Hasło: <br/> <input type="password" name="password" placeholder="hasło" onfocus="this.placeholder=''" onblur="this.placeholder='hasło'"/> <br /><br/>
				<input type="submit" value="Zaloguj się"/>
			</form>
	

<?php
	if(isset($_SESSION['error'])) echo $_SESSION['error'];
	unset($_SESSION['error']);
?>

		</div>
	</section>
	
</body>
</html>
