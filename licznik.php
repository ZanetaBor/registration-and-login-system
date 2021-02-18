<?php

// visiter counter
function getCounter()
{
	if(!file_exists('licznik.txt'))	{
		return false;
	}
	if(!$fd=fopen('licznik.txt', "r+")) {
		return false;
	}
	if(!flock($fd, LOCK_EX)) {
		echo "Nie uzyskano blokady";
		fclose($fd);
		return false;
	}
	$count= fgets($fd);
	if(is_numeric($count)) //is integer
	{
		$result = (integer) ($count+1);
		fseek($fd, 0);
		fputs($fd, $result);//save $result
	} else {
		echo " nieprawidłowy format odczytanych danych";
		$result=false;
	}
	flock($fd, LOCK_UN);
	fclose($fd);
	return $result;
}

	
?>