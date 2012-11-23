<?php
	$status = "Waiting Singup Player 2";

	$jogo = 0;
	include 'app/default.php';
	if(isset($_POST["alias"]) && strlen($_POST["alias"])){
			$file = fopen("ver.info", "rw+");
			$line = fgets($file);
			(int)$line+=1;
			fseek($file, 0, SEEK_SET);
			if(fwrite($file, $line)===FALSE) exit("[1] - Saída inesperada: Erro ao iniciar aplicativo"); else $jogo=$line;
			fclose($file);
			$file=fopen("control/$line.play", "w");
			$string_list="0|0|0|0|0|0|0|0|0";
			if($_POST["sp"]) $string_list.=";$_POST[sp]"; else $string_list.=";0";
			$_POST["alias"] = str_replace('>', '', $_POST["alias"]);
			if((int)$_POST["la"]==2){
				if(!validagravatar($_POST["alias"])){
					header("Location: index.php?emsg=Gravatar is not valid");
					exit("");
				}
				$_POST["alias"] = '>>>'.md5(strtolower(trim($_POST["alias"])));
			}
			$string_list.=";".str_replace(";", '', $_POST["alias"]);
			fwrite($file, $string_list);
			header("Location: ?x=$line");
			fclose($file);
	}
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
								if($fulldata[1]=="1") $status="Player 2 is playing!"; else $status="You must play now!";
								if(winner($fulldata[0])){
									 $trava = true;
									 if(winner($fulldata[0])== 1) $status= "You win!"; else $status = "Player ".winner($fulldata[0])." wins!";
								}
								if(terminado($fulldata[0]) && !winner($fulldata[0])){
									$status = "Game over - Without winners";
								}
								$vet = explode("|", $fulldata[0]);
								for($i=1; $i<=9; $i++){
										$pos = $vet[$i-1]; //PLAYER'S POSITION
										if($pos == "0"){
											$data = base64_encode(($i-1)."|1"."|$jogo");
											if(!$trava) echo "<a href='dataControl.php?rfx=$data'><img src='img/nada.png' alt='jogar' title='jogar' /> </a>"; else echo "<img src='img/nada.png' alt='jogar' title='jogar' />";
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
							}
						?>
						<input type="hidden" name="x" value="<?php echo $jogo; ?>" />
				</div>
			</div>
			<div>
				<div style="border-style: solid; border-color: black; border-width: 5px; background-color: white; padding: 20px; width: 45%; margin-left: auto; margin-right: auto; margin-top: 20px;">
					
					<?php 
						if(isset($fulldata)){
							echo "<div>Player 1 ";
							autoidentificacao($fulldata[2])."</div><br />";
							echo "<div style='margin-top: 30px; '>Player 2 ";
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
						if($jogo) echo "Invite your friends! <br /><input type='text' name='invite' value='http://$server$realadd?x=$jogo' class='campos' />";
					?>
					<br />
					<a href="ranking.php">Ranking</a>
				</center>
			</div>
		</div>
	</div>
	</body>
</html>



