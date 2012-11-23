<?php 
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
		
		
		if($data[0]==$data[4] && $data[4]==$data[7]) return $data[0];
		if($data[6]==$data[4] && $data[4]==$data[1]) return $data[6];
	}
	if(isset($_GET["rfx"])){
		$rfx = base64_decode($_GET["rfx"]);
		$rfx = explode("|", $rfx);
		$msg="";
		if(file_exists("control/".$rfx[2].".play")){
			$file = fopen("control/".$rfx[2].".play", "r");
			$line = fgets($file);
			$fulldata = explode(";", $line);
			$lastplayer = $fulldata[1];
			$line = $fulldata[0];
			if($lastplayer!=$rfx[1]){
				$line = explode("|", $line);
				fclose($file);
				$line[$rfx[0]] = $rfx[1];
				$data_disk="";
				foreach($line as $l=>$d) $data_disk.= $d."|";
				$file = fopen("control/".$rfx[2].".play", "w");
				fwrite($file, substr($data_disk, 0, -1).";$rfx[1];$fulldata[2];$fulldata[3]");
				fclose($file);
			}
			if(winner($fulldata[0])){
				$msg = winner($fulldata[0]).' venceu!';
			}
			header("Location: ".(($rfx[1]=='1')?('joga.php'):('jogab.php'))."?x=$rfx[2]".(strlen($msg)?("&s=".base64_encode($msg).""):("")));
		}else exit("[2] ERRO ");
	}
?>
