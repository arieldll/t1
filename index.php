<?php 
	include 'app/default.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>PRO VELHA - multiplayer game</title>
		<style type="text/css">
			body{
				font-family: arial, verdana;
				font-size: 12px;
			}
			.campos{
				width: 300px;
			}
		</style>
	</head>
	
	<body style="background-image: url(img/fundo_verde.jpg)">
		<div style="width: 85%; margin-left: auto; margin-right: auto;">
			<center>
				<img src="img/logo.png" title="PRO VELHA" alt="PRO VELHA" />
				<form action="joga.php" method="post">
					<?php 
						autoerro();
					?>
					<b> Your Nickname or Email: </b>
					<br />
					<input type="text" name="alias" class="campos"/>
					<br />
					<b>Login as:</b> <br />
					<input type="radio" value="1" name="la" checked="checked" />Normal nickname
					<input type="radio" value="2" name="la" />Email from gravatar.com
					<br />
					<br />
					<b> Start game by: </b><br />
					<input type="radio" value="2" name="sp" checked="checked" />Player 1
					<input type="radio" value="1" name="sp" />Player 2
					<br />
					<input type="submit" value="Start game!" style='width: 200px' />
				</form>
				<p>
					<a href="http://validator.w3.org/check?uri=referer"><img
					  src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Transitional" height="31" width="88" /></a>
				  </p>
			</center>
		</div>		
	</body>
</html>
