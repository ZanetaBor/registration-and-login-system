<?php
	
	session_start();
	if (isset($_POST['email'])) {
		$its_OK=true;
		$nick = $_POST['nick'];
		if ((strlen($nick)<3) || (strlen($nick)>20)) {
			$its_OK = false;
			$_SESSION['e_nick']="Nick musi posiadać od 3 do 20 znaków!";
		}
		// check if all of the characters are alphanumeric
		if (ctype_alnum($nick)==false) {
			$its_OK=false;
			$_SESSION['e_nick'] = "Nick może się tylko składać z liter i cyf (bez polskich znaków)";
		}
		
		//Check if $email is a valid email address
		$email = $_POST['email'];
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email)) {
			$its_OK=false;
			$_SESSION['e_email']="Podaj poprawny adres email!";
		}
		
		//Check if password is correct
		$password1 = $_POST['password1'];
		$password2 = $_POST['password2'];
		
		if((strlen($password1)<8) || (strlen($password1)>20)){
			$its_OK=false;
			$_SESSION['e_password']="Hasło musi posiadać od 8 do 20 znaków!";
		}
		
		if ($password1!=$password2) {
			$its_OK=false;
			$_SESSION['e_password']="Podane hasła nie są identyczne!";
		}
		
		$password_hash = password_hash($password1, PASSWORD_DEFAULT);
		
		//Check if statute is accepted
		if (!isset($_POST['statute'])) {
			$its_OK=false;
			$_SESSION['e_statute']="Potwierdź akceptację regulaminu!";
		}
		
		//bot
		$secret = "6LcqVEMUAAAAAJiG7haJM9mk2KOLBGOHE0z9TJ8C";
		
		$check_this = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
		$response_one = json_decode($check_this);
		
		if ($response_one->success==false) {
			$its_OK=false;
			$_SESSION['e_bot']="Potwierdź, że nie jesteś botem!";
		}
		
		//remember the data
		$_SESSION['fr_nick'] = $nick;
		$_SESSION['fr_email'] = $email;
		$_SESSION['fr_password1'] = $password1;
		$_SESSION['fr_password2'] = $password2;
		if (isset($_POST['statute'])) $_SESSION['fr_statute'] = true;
		
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		try {
			$connect_with = new mysqli($host, $db_user, $db_password, $db_name);
			if ($connect_with ->connect_errno!=0) {
				throw new Exception(mysqli_connect_errno());
			}
			else { //is email exists?
				$effect =$connect_with ->query("SELECT id FROM sim_kot WHERE email='$email'");
				
				if (!$effect) throw new Exception($connect_with ->error);
				
				$email_number = $effect->num_rows;
				if($email_number>0) {
					$its_OK=false;
					$_SESSION['e-email']="Istnieje już konto przypisane do tego adresu e-mail!";
				}
				
				//is nick ok?
				$effect = $connect_with ->query("SELECT id FROM sim_kot WHERE user='$nick'");
				
				if (!$effect) throw new Exception($connect_with ->error);
				
				$nick_number = $effect->num_rows;
				if($nick_number>0) {
					$its_OK=false;
					$_SESSION['e_nick']="Istnieje już gracz o takim nicku! Wybierz inny.";
				}
				
				if ($its_OK==true) {
			
					if ($connect_with ->query("INSERT INTO sim_kot VALUES (NULL, '$nick', '$password_hash', '$email', 100, 100, 100, 14)")) {
						$_SESSION['good_connection']=true;
						header('Location: witamy.php');
					}
					else {
						throw new Exception($connect_with ->error);
					}
				}
				
				$connect_with ->close();
			}
		}
		catch(Exception $e)
		{
		echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
		echo '<br />Informacja developerska: '.$e;
		}		
	}	
	
?>
<!DOCTYPE HTML>
<html lang="pl">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome1">
	
	<title>Sim Kot - załóż darmowe konto!</title>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<link rel="stylesheet" href="style.css" type="text/css"/>	
</head>	

<body>

<section>

	<div class="rejestration-new-user">
		<form method="post">

		<!-- nickname -->
			Nickname: <br /> <input type="text" value="<?php 
				if (isset($_SESSION['fr_nick'])) {
					echo $_SESSION['fr_nick'];
					unset($_SESSION['fr_nick']);
				}
				?>"
				name="nick" placeholder="nickname" onfocus="this.placeholder=''" onblur="this.placeholder='nickname'"/><br />
				<?php
				if (isset($_SESSION['e_nick'])) {
					echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
					unset($_SESSION['e_nick']);
				}
				?>
		
			<!-- e-mail -->
				E-mail: <br /> <input type="text" value="<?php
				if (isset($_SESSION['fr-email'])) {
					echo $_SESSION['fr_email'];
					unset($_SESSION['fr_email']);
				}
				?>"
				name="email" placeholder="e-mail" onfocus="this.placeholder=''" onblur="this.placeholder='e-mail'"/><br />
		
				<?php
				if (isset($_SESSION['e_email'])) {
					echo '<div class="error">'.$_SESSION['e_email'].'</div>';
					unset($_SESSION['e_email']);
				}
				?>
		
			<!-- password -->
				Twoje hasło: <br /> <input type="password" value="<?php
				if (isset($_SESSION['fr_password1'])) {
					echo($_SESSION['fr_password1']);
					unset($_SESSION['fr_password1']);
				}
				?>"
				name="password1" placeholder="password" onfocus="this.placeholder=''" onblur="this.placeholder='password'"/> <br />
		
				<?php
			if (isset($_SESSION['e_password'])) {
				echo '<div class="error">'.$_SESSION['e_password'].'</div>';
				unset($_SESSION['e_password']);
			}
			?>
		
			Powtórz hasło: <br /> <input type="password" value="<?php
			if (isset($_SESSION['fr_password2'])) {
				echo $_SESSION['fr_password2'];
				unset($_SESSION['fr_password2']);
			}
			?>"
		
			name="password2" placeholder="password" onfocus="this.placeholder=''" onblur="this.placeholder='password'"/> <br />
			
			<!-- statue  -->
			<label>
				<input type="checkbox" name="statute" <?php
				if (isset($_SESSION['fr_statute'])){
					echo "checked";
					unset($_SESSION['fr_statute']);
				}
				?>/>Akceptuje regulamin
			</label>
			<?php
			if (isset($_SESSION['e_statute'])) {
				echo '<div class="error">'.$_SESSION['e_statute'].'</div';
				unset($_SESSION['e_statute']);
			}
			?>

		<!-- recaptcha -->
			<div class="g-recaptcha" 	data-sitekey="6LcqVEMUAAAAAAiLSiWs2GDMbdPRVKdOjhwfMbGb"></div>
			<?php
			if (isset($_SESSION['e_bot'])) {
				echo '<div class="error">'.$_SESSION['e_bot'].'</div';
				unset($_SESSION['e_bot']);
			}
			?>
			<input type="submit" = value="Zarejestruj się"/>
		</form>
	
	</div>
</section>	
</body>
</html>