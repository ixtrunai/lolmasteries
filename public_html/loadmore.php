<?php
	include_once 'lang/common.php';
	include_once 'functions.php';
	header('Content-Type: text/html; charset=UTF-8');
	session_start();
	$conexion = mysql_connect("dbhost", "user", "pass") or die("No se puede conectar al servidor");
	Mysql_select_db ("db") or die ("No se puede seleccionar");
	//API functions
	include "php-riot-api.php";
	include "FileSystemCache.php";
	//Champion names
	include "campeones.php";
	$server = $_GET['server'];
	$info = new riotapi($server, new FileSystemCache('cache/'));
	$invocador = $info->getSummonerByName($_GET['nomInvocador'], $server);
	$invocador = json_decode($invocador);
	$buscar = strtolower($_GET['nomInvocador']);
	$buscar = preg_replace('/\s+/', '', $buscar);
	$invocador = $invocador->$buscar;
	$icono = $invocador->profileIconId;
	$nombre = $invocador->name;
	$id = $invocador->id;
	$comienzo = $_SESSION['contador'];
	
	$listaPartidas = $info->getMatchHistory($id, $_GET['champId']);
	$listaPartidas = json_decode($listaPartidas);
	$listaPartidas = $listaPartidas->matches;
	if($_SESSION['contador']<count($listaPartidas)){
		$inicio = $_SESSION['contador'];
		if(count($listaPartidas)-$_SESSION['contador']>2){
			$fin = 3;
		}
		else if(count($listaPartidas)-$_SESSION['contador']==2){
			$fin = 2;
		}
		else if(count($listaPartidas)-$_SESSION['contador']==1){
			$fin = 1;
		}
		else{
			exit();
		}
	}
	else{
		exit();
	}
	$fin = $inicio+$fin;
	for($i=$inicio; $i<$fin; $i++){
		try{
			$idPartida = $listaPartidas[$i]->matchId;
			$partida = $info->getMatch($idPartida);
			$partida = json_decode($partida);
			$mapaJuego = $partida->mapId;
			$modoJuego = $partida->matchMode;
			$tipoJuego = $partida->matchType;
			$campeonUsado = $partida->championId;
			$fecha = $partida->matchCreation;
			$timePlayed = $partida->matchDuration;
			$tiempoHoras = intval($timePlayed/3600);
			$tiempoMins = intval(($timePlayed%3600)/60);
			$tiempoSegs = $timePlayed%60;
			if($tiempoHoras==0){
				$tiempoHoras = "";
			}else{
				$tiempoHoras = "0".$tiempoHoras.":";
			}
			//Fecha
			$fecha = $fecha/1000;
			$fecha = date("d/m/Y - H:i | ", strtotime('+2 hours', $fecha));
			if($tiempoSegs<10){
				$tiempoSegs = "0".$tiempoSegs;
			}
			if($tiempoMins<10){
				$tiempoMins = "0".$tiempoMins;
			}

			echo "<div class='partida'>";
			echo "<div class='titulo_partida'>";
			echo "<span>Ranked | ".$lang['MATCH_MAP_'.$mapaJuego]."</span><span class='fechapartida'><span title='".$lang['MATCH_DATE_TITLE']."'>$fecha</span>  <span title='".$lang['MATCH_DURATION_TITLE']."'>$tiempoHoras$tiempoMins:$tiempoSegs</span></span>";
			echo "</div>";
			
			$participantes = $partida->participants;
			$nom_participantes = $partida->participantIdentities;
			for($z=0; $z<count($nom_participantes); $z++){
				$jugador = $nom_participantes[$z]->player;
				$nom_participante[$z] = $jugador-> summonerName;
				$id_participante[$z] = $jugador-> summonerId;
			}
			for($j=0; $j<count($participantes); $j++){
				if($id != $id_participante[$j]){
					$maestrias = $info->getMasteries($id_participante[$j], "champions");
					$maestrias = json_decode($maestrias);
					for($m=0; $m<count($maestrias); $m++){
						$idCampeon = $maestrias[$m] -> championId;
						$nivelCampeon = $maestrias[$m] -> championLevel;
						$puntosMaestria = $maestrias[$m] -> championPoints;
						$ultimaVezJugado = $maestrias[$m] -> lastPlayTime;
						$rangoMasAlto = $maestrias[$m] -> highestGrade;
						$fecha = $ultimaVezJugado/1000;
						$fecha = date("Y-m-d H:i:s", strtotime('+2 hours', $fecha));
						$sql_select = mysql_query("SELECT points from champ$idCampeon where summ_id = '$id_participante[$j]'", $conexion);
						$sql_create = "CREATE TABLE IF NOT EXISTS champ$idCampeon (
								summ_id VARCHAR(12) PRIMARY KEY, 
								server VARCHAR(4), 
								points INT NOT NULL,
								playTime DATETIME NOT NULL,
								level VARCHAR(1) NOT NULL,
								grade VARCHAR(2) NOT NULL
								);";
							if($sql_select == true){
								$result = mysql_fetch_array($sql_select);
							}
							else{
								$result[0] = "";
							}
							if(empty($result[0])){
								mysql_query($sql_create, $conexion) or die("fallo al crear $sql_create");
								mysql_query("INSERT INTO champ$idCampeon VALUES ('$id_participante[$j]', '$server', '$puntosMaestria', '$fecha', '$nivelCampeon', '$rangoMasAlto' )", $conexion) or die ("fallo al subir a bdd");
							}
							else if($result[0]<$puntosMaestria){
								$sql_delete = "DELETE FROM champ$idCampeon WHERE summ_id='$id_participante[$j]'";
								mysql_query($sql_delete, $conexion) or die ("fallo al eliminar de bdd");
								mysql_query($sql_create, $conexion);
								mysql_query("INSERT INTO champ$idCampeon VALUES ('$id_participante[$j]', '$server', '$puntosMaestria', '$fecha', '$nivelCampeon', '$rangoMasAlto' )", $conexion) or die ("fallo al subir a bdd");
							}
						else{
							continue;
						}							
					}
					//continue;
				}
				else{
					$equipo = $participantes[$j]->teamId;
					$summoner_1 = $participantes[$j]->spell1Id;
					$summoner_2 = $participantes[$j]->spell2Id;
					$campeon = $participantes[$j]->championId;
					$stats = $participantes[$j]->stats;
					$item0 = $stats->item0;
					$item1 = $stats->item1;
					$item2 = $stats->item2;
					$item3 = $stats->item3;
					$item4 = $stats->item4;
					$item5 = $stats->item5;
					$item6 = $stats->item6;
					$stats = $participantes[$j]->stats;
					$asesinatos = $stats->kills;
					$muertes = $stats->deaths;
					$asistencias = $stats->assists;
					$bajamultiple = $stats->largestMultiKill;
					$minions = $stats->minionsKilled;
					$daniofisico = $stats->physicalDamageDealt;
					$daniomagico = $stats->magicDamageDealt;
					$wardscolocados = $stats->wardsPlaced;
					$wardseliminados = $stats->wardsKilled;
					//1329 item error y parecidos -> https://developer.riotgames.com/discussion/community-discussion/show/aAnAJYXn
					if(!empty($item0)){$item0 = setItem($item0);}else{$item0="<img class='item' src='/images/transparent.png'/>";}
					if(!empty($item1)){$item1 = setItem($item1);}else{$item1="<img class='item' src='/images/transparent.png'/>";}
					if(!empty($item2)){$item2 = setItem($item2);}else{$item2="<img class='item' src='/images/transparent.png'/>";}
					if(!empty($item3)){$item3 = setItem($item3);}else{$item3="<img class='item' src='/images/transparent.png'/>";}
					if(!empty($item4)){$item4 = setItem($item4);}else{$item4="<img class='item' src='/images/transparent.png'/>";}
					if(!empty($item5)){$item5 = setItem($item5);}else{$item5="<img class='item' src='/images/transparent.png'/>";}
					if(!empty($item6)){$item6 = setItem($item6);}else{$item6="<img class='item' src='/images/transparent.png'/>";}
					
					if($bajamultiple == 2){
						$bajamultiple = $lang['MATCH_MULTIKILL_2'];
					}
					else if($bajamultiple == 3){
						$bajamultiple = $lang['MATCH_MULTIKILL_3'];
					}
					else if($bajamultiple == 4){
						$bajamultiple = $lang['MATCH_MULTIKILL_4'];
					}
					else if($bajamultiple == 5){
						$bajamultiple = $lang['MATCH_MULTIKILL_5'];
					}
					else if($bajamultiple == 6){
						$bajamultiple = $lang['MATCH_MULTIKILL_6'];
					}
					else if($bajamultiple > 6){
						$bajamultiple = $lang['MATCH_MULTIKILL_MAX'];
					}
					else{
						$bajamultiple = "";
					}
					$campeon = $nom_campeon[$campeon];
					print "<div class='campeon_principal'><img class='img_champ' src='http://ddragon.leagueoflegends.com/cdn/".$_SESSION['ddragon']."/img/champion/$campeon.png'/><br>$campeon</div>";
					print "<div class='hechizos'><div class='hechizo1'><img class='imghechizo' src='images/summs/$summoner_1.png'/></div><div><img class='imghechizo'src='images/summs/$summoner_2.png'/></div></div>";
					print "<div class='kda'>$asesinatos/<span class='muertes'>$muertes</span>/$asistencias<br><span class='multikill'>$bajamultiple</span></div>";
					print "<div class='items'><div class='grupo1'>$item0 $item1 $item2</div><div class='grupo2'>$item3 $item4 $item5</div></div><div class='talisman'>$item6</div>";
					print "<div class='stats'>".$lang['MATCH_MINIONS_KILLED'].": $minions<br>";
					print $lang['MATCH_ADAMAGE_DEALT'].": $daniofisico<br>";
					print $lang['MATCH_MDAMAGE_DEALT'].": $daniomagico<br>";
					print $lang['MATCH_WARDS_PLACED'].":$wardscolocados<br>";
					print $lang['MATCH_WARDS_DESTROYED'].":$wardseliminados</div>";
					$_SESSION['contador']++;
				}	
				
			}
		}
		catch (Exception $e){
			if(strpos($e, 'SERVER_ERROR')){
				print "";
			}
			if(strpos($e, 'NOT_FOUND')){
				print "";
			}
		}
		
		echo "</div>";	
		echo "<div id='loading'></div>";	
	}
?>
