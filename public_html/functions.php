<?php
	$dbhost = "dbHost_Here";
	$dbuser = "dbUser_Here";
	$dbpass = "dbPass_Here";
	$dbname = "dbName_Here";
	
	//SET LAST DDRAGON VERSION 
	if(empty($_SESSION['ddragon'])){
		if(empty($_GET['inputServer'])){
			$server = 'euw';
		}
		else{
			$server = $_GET['inputServer'];
		}
		include_once 'php-riot-api.php';
		include_once 'FileSystemCache.php';
		$info = new riotapi($server, new FileSystemCache('cache/'));
		$ddragon = $info->getStatic('versions');
		$ddragon = explode('"', $ddragon);
		$_SESSION['ddragon'] = $ddragon[1];
	}
	
	//ITEM ID´S FIX
	function setItem($item){
		if($item == 1309){
			$item = 3280;
		}
		else if($item == 1305){
			$item = 3282;
		}
		else if($item == 1305){
			$item = 3282;
		}
		else if($item == 1307){
			$item = 3281;
		}
		else if($item == 1306){
			$item = 3284;
		}
		else if($item == 1305){
			$item = 3282;
		}
		else if($item == 1308){
			$item = 3283;
		}
		else if($item == 1333){
			$item = 3278;
		}
		else if($item == 1331){
			$item = 3279;
		}
		else if($item == 1304){
			$item = 3250;
		}
		else if($item == 1302){
			$item = 3251;
		}
		else if($item == 1301){
			$item = 3254;
		}
		else if($item == 1314){
			$item = 3255;
		}
		else if($item == 1300){
			$item = 3252;
		}
		else if($item == 1303){
			$item = 3253;
		}
		else if($item == 1318){
			$item = 3263;
		}
		else if($item == 1316){
			$item = 3264;
		}
		else if($item == 1324){
			$item = 3265;
		}
		else if($item == 1322){
			$item = 3266;
		}
		else if($item == 1319){
			$item = 3260;
		}
		else if($item == 1317){
			$item = 3261;
		}
		else if($item == 1315){
			$item = 3262;
		}
		else if($item == 1310){
			$item = 3257;
		}
		else if($item == 1312){
			$item = 3256;
		}
		else if($item == 1311){
			$item = 3259;
		}
		else if($item == 1313){
			$item = 3258;
		}
		else if($item == 1332){
			$item = 3276;
		}
		else if($item == 1330){
			$item = 3277;
		}
		else if($item == 1326){
			$item = 3274;
		}
		else if($item == 1334){
			$item = 3275;
		}
		else if($item == 1325){
			$item = 3272;
		}
		else if($item == 1328){
			$item = 3273;
		}
		else if($item == 1329){
			$item = 3270;
		}
		else if($item == 1327){
			$item = 3271;
		}
		else if($item == 1321){
			$item = 3269;
		}
		else if($item == 1323){
			$item = 3268;
		}
		else if($item == 1320){
			$item = 3267;
		}
		//FIRSTLY, TRY TO GET IMAGES FROM DDRAGON, IF NOT FOUND, RETURN TRANSPARENT
		if(is_404("http://ddragon.leagueoflegends.com/cdn/".$_SESSION['ddragon']."/img/item/$item.png")){
			//TRY ANOTHER VERSION
			if(is_404("http://ddragon.leagueoflegends.com/cdn/5.9.1/img/item/$item.png")){
				//IF NOT FOUND --> RETURN TRANSPARENT
				return "<img class='item' src='/images/transparent.png'/>";
			}
			else{
				//IF FOUND ON ANOTHER VERSION --> RETURN FROM DDRAGON
				return "<img class='item' src='http://ddragon.leagueoflegends.com/cdn/5.9.1/img/item/$item.png'/>";
			}
			
		}
		else{
			return "<img class='item' src='http://ddragon.leagueoflegends.com/cdn/".$_SESSION['ddragon']."/img/item/$item.png'/>";
		}
		
	}
	//CHECK FOR 404 ERROR ON IMAGE LINKS
	function is_404($url) {
		$handle = curl_init($url);
		curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

		/* Get the HTML or whatever is linked in $url. */
		$response = curl_exec($handle);

		/* Check for 404 (file not found). */
		$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
		curl_close($handle);

		/* If the document has loaded successfully without any redirection or error */
		if ($httpCode >= 200 && $httpCode < 300) {
			return false;
		} else {
			return true;
		}
	}
	
	function champStats($id, $champId){
		$info = new riotapi($_GET['server'], new FileSystemCache('cache/'));
		$listaPartidas = $info->getMatchHistory($id, $champId);
		$listaPartidas = json_decode($listaPartidas);
		$listaPartidas = $listaPartidas->matches;
		//LIMIT MAXIMUM MATCHES TO CHECK FOR AVOIDING LOADING ERRORS
		if(count($listaPartidas)>=10){
			$maximo = 10;
		}
		else{
			$maximo = count($listaPartidas);
		}
		for($i=0; $i<$maximo; $i++){
			try{
				$idPartida = $listaPartidas[$i]->matchId;
				$partida = $info->getMatch($idPartida);
				$partida = json_decode($partida);
				$timePlayed = $partida->matchDuration;
				$tiempoTotal = $tiempoTotal + $timePlayed;
				$participantes = $partida->participants;
				$nom_participantes = $partida->participantIdentities;
				for($z=0; $z<count($nom_participantes); $z++){
					$jugador = $nom_participantes[$z]->player;
					$id_participante[$z] = $jugador-> summonerId;
				}
				for($j=0; $j<count($participantes); $j++){
					if($id != $id_participante[$j]){
						continue;
					}
					$stats = $participantes[$j]->stats;
					$asesinatos = $stats->kills;
					$muertes = $stats->deaths;
					$asistencias = $stats->assists;
					$resultado[0] = $resultado[0] + $asesinatos;
					$resultado[1] = $resultado[1] + $muertes;
					$resultado[2] = $resultado[2] + $asistencias;
				}
			}
			catch (Exception $e){
				if(strpos($e, 'NOT_FOUND')){
					continue;
				}
			}
		}
		$tiempoHoras = intval($tiempoTotal/3600);
		$tiempoMins = intval(($tiempoTotal%3600)/60);
		$tiempoSegs = $tiempoTotal%60;
		if($tiempoHoras==0){
			$tiempoHoras = "";
		}
		else if($tiempoHoras<10){
			$tiempoHoras = "0".$tiempoHoras.":";
		}
		else{
			$tiempoHoras = $tiempoHoras.":";
		}
		if($tiempoSegs<10){
			$tiempoSegs = "0".$tiempoSegs;
		}
		if($tiempoMins<10){
			$tiempoMins = "0".$tiempoMins;
		}
		$resultado[3] = "$tiempoHoras$tiempoMins:$tiempoSegs";
		$resultado[4] = $maximo;
		return $resultado;
	}
?>