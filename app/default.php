<?php 

	ini_set('display_errors', 1);
	ini_set('log_errors', 1);
	ini_set('error_log', "error/errorlog.txt");
	
	error_reporting(E_STRICT);
	
	function winner($data){
		$data = explode("|", $data);
		$dffz=0;
		foreach($data as $d=>$p) if($p!=0) $dffz++;
		if($dffz==0){ return false; }
		
		if($data[0]==$data[1] && $data[1]==$data[2]) return $data[0];
		if($data[3]==$data[4] && $data[4]==$data[5]) return $data[3];
		if($data[6]==$data[7] && $data[7]==$data[8]) return $data[8];
		
		if($data[0]==$data[3] && $data[3]==$data[6]) return $data[0];
		if($data[1]==$data[4] && $data[4]==$data[7]) return $data[4];
		if($data[2]==$data[5] && $data[5]==$data[8]) return $data[5];
		
		
		if($data[0]==$data[4] && $data[4]==$data[8]) return $data[8];
		if($data[2]==$data[4] && $data[4]==$data[6]) return $data[6];
	}
	
	function terminado($data){
		$data = explode("|", $data);
		$dffz=0;
		foreach($data as $d=>$p) if($p!=0) $dffz++;
		if($dffz==9){ return true; }
	}
	$trava = false;
	
	function autoidentificacao($p){
		if(substr($p, 0, 3)=='>>>'){
			$hash = substr($p, 3, strlen($p)-3);
			$str = file_get_contents("http://www.gravatar.com/$hash.php");
			$profile = unserialize($str);
			if(is_array($profile) && isset($profile['entry'])){
				echo "<div>";
				echo "<div><a href='http://www.gravatar.com/".$profile['entry'][0]['displayName']."' style='border:none;' target='_blank'><img src='http://www.gravatar.com/avatar/$hash' title='player' alt='player'/></a></div>";
				echo "<div>".$profile['entry'][0]['displayName']."</div>"; 
				echo "</div>";
			}else echo "User isn't valid";
		}else echo $p;
	}
	
	function validagravatar($email){
			$hash = md5(strtolower(trim($email)));
			$str = file_get_contents("http://www.gravatar.com/$hash.php");
			$profile = unserialize($str);
			if(is_array($profile) && isset($profile['entry'])) return true;
			return false;
	}
	
	function autoerro(){
		if(isset($_GET["emsg"]) && $_GET["emsg"]) echo "<label style='color: red'>$_GET[emsg]</label><br />";
	}
?>
