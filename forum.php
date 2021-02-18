<?php

session_start();

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /> 
	<tile>Sim Kot - gra przeglądarkowa</title>
	<link rel="stylesheet" href="style2.css" type="text/css"/>
</head>

<body>	

<?php

if(!isset($_GET['opinion']) || $_GET['opinion']=="")
	exit("Opinia nie została przesłana.");

$str = substr($_GET['opinion'], 0, 255); //get string
$str = strip_tags($str); // Strip the string from HTML tags
$str = preg_replace('/[^a-zA-X0-9\s_.!\-]/','', $str);

/*save comment*/
if(file_put_contents 
("opinie.txt", "$str\n", FILE_APPEND  ) === false)	 {
	echo " Błąd serwera. Opinia nie została zapisana.";
}
else {
	echo "Dziękujemy za przesłanie opinii.<br><br>";
}

if(file_exists('opinie.txt')) {
	$str = file_get_contents('opinie.txt'); 
	$str = nl2br($str);
	echo $str;
}
?>

	
</body>
</html>