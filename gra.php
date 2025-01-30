<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany'])) {
		header('Location: index.php');
		exit();
	}
	
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<meta https-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /> 
	<tile>Sim kot - gra przeglądarkowa</title>
	<link rel="stylesheet" href="style2.css" type="text/css"/>
</head>

<body>	

<?php

	echo "<p>Witaj ".$_SESSION['user'].'! [ <a href="logout.php">Wyloguj się!</a> ]</p>';
	echo "<p><b>money</b>: ".$_SESSION['money'];
	echo " | <b>soldiers</b>: ".$_SESSION['soldiers'];
	echo " | <b>food</b>: ".$_SESSION['food']."</p>";
	
	echo "<p><b>E-mail</b>: ".$_SESSION['email'];
	echo "<br /><b>premium</b>:".$_SESSION['premium']."</p>";
	
?>

<!-- comments -->
<div class="forum">
	Dodaj swoją opinie! Możesz to również uczynić przechodząc bezpośrednio na nasze <a href="forum.php">FORUM</a>. Znajdziesz na nim porady, najczęściej zadawane pytania i inne zagadnienia dodane przez naszych graczy.
	<form metod="get" action="forum.php">
		<textarea name="opinion"></textarea>
		<br />
		<input type="submit" value="dodaj">
	</form>
</div>
	
</body>
</html>
