<?php
	function getStateCount($rmhost, $rmport,$state_arg){
		$statsurl  ="http://" . $rmhost . ":" . $rmport . "/ws/v1/cluster/appstatistics?states=" . $state_arg;
		$statscont = file_get_contents($statsurl);
		$enstats   = utf8_encode($statscont);
		$statsobj  = json_decode($enstats,true);
			foreach($statsobj['appStatInfo']['statItem'] as $statsrec){ }
			return $statsrec['count'];
	}
	
		function getstartedOn(){
		$statsurl  ="http://" . $rmhost . ":" . $rmport . "/ws/v1/cluster/info";
		$statscont = file_get_contents($statsurl);
		$enstats   = utf8_encode($statscont);
		$statsobj  = json_decode($enstats,true);
			foreach($statsobj['clusterInfo'] as $cinfo){ }
			return $cinfo['id'];
	}
	
		function update_ini_file($data, $filepath) { 
		$content = ""; 
		$parsed_ini = parse_ini_file($filepath, true);
			echo $data;
		foreach($data as $section=>$values){
			$content = $section; 
			foreach($values as $key=>$value){
				echo  $key."=".$value; 
			}
		}
		if (!$handle = fopen($filepath, 'r+')) { 
			return false; 
		} 
		//$success = fwrite($handle, $content);
		fclose($handle); 
		return $success; 
	}
?>
