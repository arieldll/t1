<?php
	$status = "ERRO";
	$jogo = 0;
	include 'app/default.php';
	if(isset($_POST["alias"]) && strlen($_POST["alias"])){
			$file = fopen("control/".$_GET["x"].".play", "r");
			$line = fgets($file);
			$fulldata = explode(";", $line);
			$line = "";
			$_POST["alias"] = str_replace('>', '', $_POST["alias"]);
			if((int)$_POST["la"]==2){
				if(!validagravatar($_POST["alias"])){
					header("Location: jogab.php?x=$_GET[x]&emsg=Gravatar is not valid");
					exit("");
				}
				$_POST["alias"] = '>>>'.md5(strtolower(trim($_POST["alias"])));
			}
			$fulldata[3] = str_replace(";", '', $_POST["alias"]);
			foreach($fulldata as $d => $p){
				$line.="$p;";
			}
			fclose($file);
			$file = fopen("control/".$_GET["x"].".play", "w");
			fwrite($file, substr($line, 0, -1));
			fclose($file);
			header("Location: ?x=$_GET[x]");
	}
?>

<?php 
	$bloqueado=true;
	if(isset($_GET["x"])){
		$jogo = $_GET["x"]; //x is the game's name parameter
		$file = fopen("control/$jogo.play", "r");
		$vet = fgets($file);
		$fulldata = explode(";", $vet);
		if($fulldata[3]==""){
			$bloqueado=false;
		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<?php include 'app/cabecalho.php'; ?>
	<body style="background-image: url(img/fundo_verde.jpg)">
		
		<?php 
				if(!$bloqueado){ ?>
					<div style="width: 85%; margin-left: auto; margin-right: auto;">
							<center>
								<img src="img/logo.png" title="PRO VELHA" alt="PRO VELHA" />
								<form action="jogab.php?x=<?php echo $_GET["x"]; ?>" method="post">
									<?php
										autoerro();
									?>
									<b>Please fill your Nickname:</b>
									<br />
									<input type="text" name="alias" class="campos"/>
									<br />
									<b>Login as:</b> <br />
									<input type="radio" value="1" name="la" checked="checked" />Normal nickname
									<input type="radio" value="2" name="la" />Email from gravatar.com
									<br />
									<input type="submit" value="Join game!" />
								</form>
							</center>
						</div>
				<?php
					exit("");
				}
		?>
		
		<div style="width: 85%; margin-left: auto; margin-right: auto; height: 100%;">
			<div>
				<div style="border-style: solid; border-color: black; border-width: 5px; background-color: white; padding: 20px; width: 45%; margin-left: auto; margin-right: auto;">
						<?php
							if(isset($_GET["x"])){
								$jogo = $_GET["x"]; //x is the game's name parameter
								$file = fopen("control/$jogo.play", "r");
								$vet = fgets($file);
								$fulldata = explode(";", $vet);
								if($fulldata[3]==""){
									echo "Para jogar, identifique-se! :D<br />";
									echo "Seu nome: <br /><input type='text' name='alias' class='campos' />";
								}
								if($fulldata[1]=="2") $status="Player 1 is playing!"; else $status="You must play now!";
								if(winner($fulldata[0])){
									 $trava = true;
									 if(winner($fulldata[0])== 2) $status= "You win!"; else $status = "Player ".winner($fulldata[0])." wins!";
								}
								if(terminado($fulldata[0]) && !winner($fulldata[0])){
									$status = "Game over - Without winners";
								}
								$vet = explode("|", $fulldata[0]);
								for($i=1; $i<=9; $i++){
										$pos = $vet[$i-1]; //PLAYER'S POSITION
										if($pos == "0"){
											$data = base64_encode(($i-1)."|2"."|$jogo");
											if(!$trava) echo "<a href='dataControl.php?rfx=$data'><img src='img/nada.png' title='jogar' alt='jogar' /> </a>"; else echo "<img src='img/nada.png' title='jogar' alt='jogar' />";
										}
										if($pos == "1"){
											echo "<img src='img/bola.png' title='bola' alt='bola' />";
										}
										if($pos == "2"){
											echo "<img src='img/xis.png' title='x' alt='x' />";
										}
										if($i%3!=0){
											echo "<img src='img/separador.png' title='separador' alt='separador' />";
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
						$realadd = str_replace('jogab', 'expecters', $_SERVER['PHP_SELF']);
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



