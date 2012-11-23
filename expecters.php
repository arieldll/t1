<?php
	include 'app/default.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<?php include 'app/cabecalho.php'; ?>
	<body style="background-image: url(img/fundo_verde.jpg)">
		<div style="width: 85%; margin-left: auto; margin-right: auto; height: 100%;">
			<div>
				<div style="border-style: solid; border-color: black; border-width: 5px; background-color: white; padding: 20px; width: 45%; margin-left: auto; margin-right: auto;">
						<?php
							if(isset($_GET["x"])){
								$jogo = $_GET["x"]; //x is the game's name parameter
								$file = fopen("control/$jogo.play", "r");
								$vet = fgets($file);
								$fulldata = explode(";", $vet);
								if($fulldata[1]=="1") $status="Player 2 is playing!"; else $status="Player 1 is playing!";
								if(winner($fulldata[0])){
									 $trava = true;
									 if(winner($fulldata[0])== 1) $status= "Player 1 wins!"; else $status = "Player ".winner($fulldata[0])." wins!";
								}
								if(terminado($fulldata[0]) && !winner($fulldata[0])){
									$status = "Game over - Without winners";
								}
								$vet = explode("|", $fulldata[0]);
								for($i=1; $i<=9; $i++){
										$pos = $vet[$i-1]; //PLAYER'S POSITION
										if($pos == "0"){
											echo "<img src='img/nada.png' alt='jogar' title='jogar' />";
										}
										if($pos == "1"){
											echo "<img src='img/bola.png' alt='bola' title='bola' />";
										}
										if($pos == "2"){
											echo "<img src='img/xis.png' alt='x' title='x' />";
										}
										if($i%3!=0){
											echo "<img src='img/separador.png' alt='separador' title='separador' />";
										}
									if($i%3==0 && $i!=9){
										echo '<br /><div style="background-color: black; height: 5px; width: 100%; margin-top: 15px;"> </div><br />';
									}
								}
							}else echo "The game isn't exists!";
						?>
						<input type="hidden" name="x" value="<?php echo $jogo; ?>" />
				</div>
			</div>
			<div>
				<div style="border-style: solid; border-color: black; border-width: 5px; background-color: white; padding: 20px; width: 45%; margin-left: auto; margin-right: auto; margin-top: 20px;">
					
					<?php 
						if(isset($fulldata)){
							echo "<div>(O) Player 1 ";
							autoidentificacao($fulldata[2])."</div><br />";
							echo "<div style='margin-top: 30px; '>(X) Player 2 ";
							if($fulldata[3]){
								autoidentificacao($fulldata[3]);
							}else echo "Waiting";
							echo "</div>";
						}
					?>
					<div>
						<label style="font-size: 25px; color: red;">
							<?php echo $status; ?>
						</label>
					</div>
				</div>
			</div>
			<div>
				<center>
					<?php
						$server = $_SERVER['SERVER_NAME']; 
						$addres = $_SERVER ['REQUEST_URI'];
						$realadd = str_replace('joga', 'jogab', $_SERVER['PHP_SELF']);
						if($jogo) echo "Invite your friends to watch this game! <br /><input type='text' name='invite' value='http://$server$realadd?x=$jogo' class='campos' />";
					?>
					<br />
					<a href="ranking.php">Ranking</a>
				</center>
			</div>
		</div>
	</div>
</body>
</html>



