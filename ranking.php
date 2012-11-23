<?php
	include 'app/default.php'; 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<?php include 'app/cabecalho.php'; ?>
	<body style="background-image: url(img/fundo_verde.jpg)">
		<div style="width: 50%; margin-left: auto; margin-right: auto;">
			<div>
				<img src='img/logo.png' title='logo' alt='logo' />
			</div>
			<div style="margin-bottom: 30px; margin-top: 15px;">
				 <b> - - - - - - RANKING PAGE - - - - - -</b>
			</div>
				<div>
					<?php 
						$direc = opendir('control');
						while(false !== ($file = readdir($direc))) {
							$open = fopen("control/$file", "r");
							$linha = fgets($open);
							$pos = explode(';', $linha);
							$sep = explode('|', $pos[0]);
							if(winner($pos[0])){
								echo "Game number \ ".str_replace('.play', '', $file)." / - Winner: [ Player ".winner($pos[0])." ] ";
								if(winner($pos[0])==1) autoidentificacao($pos[2]);
								if(winner($pos[0])==2) autoidentificacao($pos[3]);
								echo "<br />";
							}
						}
						echo "<br /><b>Last update: ".date('d/m/Y - H:i:s').'</b>';
					?>
				</div>
		</div>
		
	</body>
</html>



