<?php
	include_once 'lang/common.php';
	include_once 'functions.php';
	header('Content-Type: text/html; charset=UTF-8');
	session_start();
	$conexion = mysql_connect($dbhost, $dbuser, $dbpass) or die("No se puede conectar al servidor");
	Mysql_select_db ($dbname) or die ("No se puede seleccionar");
?>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="<?php echo $lang['HEAD_DESCRIPTION']; ?>">
		<meta name="keywords" content="lolmasteries, lol masteries, lol champion masteries, my champion masteries, maestrias lol, maestrias de campeon lol, maestrias de campeon, lolmaesteries.esy.es, lol.masteries">
		<meta name="author" content="IXTR Unai">
		<link rel="icon" href="images/favicon.png">
		<title><?php echo $lang['MATCHISTORY_PAGE_TITLE']; ?></title>
	</head>
	<body>
		
		<header>
		<div id='menu'>
			<ul>
				<li><a href='index'>LoL Masteries</a></li>
				<li><a href='leaderboards'><?php echo $lang['MENU_LEADERBOARDS']; ?></a></li>
				<li class='last'><a href='about'><?php echo $lang['MENU_ABOUT']; ?></a></li>
			</ul>
		</div>
		<div id="languages">
			<?php
				header('Content-Type: text/html; charset=UTF-8');
				echo $lang['LANG_SELECT'];
				//IF SOMEONE SEARCHED FOR A SUMMONER
				if(isset($_GET['nomInvocador'])){
					//IF SERVER WAS SELECTED
					if(isset($_GET['server'])){
						$nombre = str_replace(" ","+",$_GET['nomInvocador']);
						echo "<a href='matchistory?nomInvocador=".$nombre."&server=".$_GET['server']."&champId=".$_GET['champId']."&lang=en'>English</a> | ";
						echo "<a href='matchistory?nomInvocador=".$nombre."&server=".$_GET['server']."&champId=".$_GET['champId']."&lang=es'>Español</a>";
					}
					//IF SERVER WASNT SELECTED BUT A SERVER WAS SAVED
					else if(isset($_SESSION['servidor'])){
						$nombre = str_replace(" ","+",$_GET['nomInvocador']);
						echo "<a href='matchistory?nomInvocador=".$nombre."&server=".$_SESSION['servidor']."&champId=".$_GET['champId']."&lang=en'>English</a> | ";
						echo "<a href='matchistory?nomInvocador=".$nombre."&server=".$_SESSION['servidor']."&champId=".$_GET['champId']."&lang=es'>Español</a>";
					}
					else{
						echo '<a href="index?lang=en">English</a> | ';
						echo '<a href="index?lang=es">Español</a>';
					}
				}
				//DEFAULT PAGE LOAD (NO SEARCHES)
				else{
					echo '<a href="index?lang=en">English</a> | ';
					echo '<a href="index?lang=es">Español</a>';
				}
			?>
			<?php
					//IF "REMEMBER THE SERVER" WAS CHECKED
					if(isset($_GET['guardarServidor'])){
						//IF A SERVER WAS SELECTED
						if(!empty($_GET['inputServer'])){
							unset($_SESSION['servidor']);
							$_SESSION['servidor'] = $_GET['inputServer'];
							/*var_dump(getStatic('versions'));*/
						}
					}else{
						$server = $_SESSION['servidor'];
						unset($_SESSION['servidor']);
					}
						
				?>
		</div>
	</header>
		<script>
		
		</script>
		
		<?php

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
			print "<div class='encabezado1'><img class='summonerIcon' src='http://ddragon.leagueoflegends.com/cdn/".$_SESSION['ddragon']."/img/profileicon/$icono.png'></img> $nombre</div>";
			if(empty($_SESSION['servidor'])){
				$atributos = "value='null' disabled";
				$opcion = $lang['FORM_SERVER_TITLE'];
			}
			else{	
				$atributos = "value='".$_SESSION['servidor']."'";
				$opcion = strtoupper($_SESSION['servidor']);
				$atributo_chk = "checked";
			}
			$total = champStats($id, $_GET['champId']);
			if($total[1]>0){
				$kda = ($total[0]+$total[2])/$total[1];
			}
			else{
				$kda = $total[0]+$total[2];
			}
			if($_GET['lang'] == "es"){
				$kda = number_format($kda, 2, ',', ',');
			}
			else{
				$kda = number_format($kda, 2, '.', ',');
			}
			
			$nomCampeon = $nom_campeon[$_GET['champId']];
			print "<div class='colgatePuto'>";
			print "<div class='busqueda'>
						<div class='panel panel-primary'>
							<div class='panel-heading'>".$lang['SEARCH_TITLE']."</div>
							<div class='panel-body'>
								<form action='index' method='GET'>
									<input type='text' name='nomInvocador' id='inputSummoner' class='form-control' title='".$lang['FORM_SUMMONER_NAME_TITLE']."' placeholder=".$lang['FORM_SUMMONER_NAME']." required autofocus><br>
									<select name='inputServer' title='".$lang['FORM_SERVER_TITLE']."' id='inputServer' class='form-control'>
										<option title='".$lang['FORM_SERVER_TITLE']."' $atributos selected>$opcion</option>
										<option title='".$lang['FORM_SERVER_BR_TITLE']."' value='br'>BR</option>
										<option title='".$lang['FORM_SERVER_EUNE_TITLE']."' value='eune'>EUNE</option>
										<option title='".$lang['FORM_SERVER_EUW_TITLE']."' value='euw'>EUW</option>
										<option title='".$lang['FORM_SERVER_JP_TITLE']."' value='jp'>JP</option>
										<option title='".$lang['FORM_SERVER_KR_TITLE']."' value='kr'>KR</option>
										<option title='".$lang['FORM_SERVER_LAN_TITLE']."' value='lan'>LAN</option>
										<option title='".$lang['FORM_SERVER_LAS_TITLE']."' value='las'>LAS</option>
										<option title='".$lang['FORM_SERVER_NA_TITLE']."' value='na'>NA</option>
										<option title='".$lang['FORM_SERVER_OCE_TITLE']."' value='oc'>OCE</option>
										<option title='".$lang['FORM_SERVER_RU_TITLE']."' value='ru'>RU</option>
										<option title='".$lang['FORM_SERVER_TR_TITLE']."' value='tr'>TR</option>
									</select>	
									<input $atributo_chk type='checkbox' name='guardarServidor' value='true'>".$lang['FORM_SERVER_REMEMBER']."									
									<button class='btn btn-lg btn-primary btn-block' id='buscar' name='buscar' type='submit'>".$lang['FORM_SERVER_SEARCH']."</button>									
								</form>
							</div>
						</div>
						<div class='champStats'>
						<div class='panel panel-primary'>
							<div class='panel-heading'>".$lang['STATS_CHAMP'].$nomCampeon."<br>".$lang['STATS_MATCHES_1']."$total[4]".$lang['STATS_MATCHES_2']."</div>
							<div class='panel-body'>
								<p class='text-left'><b>".$lang['STATS_TIME_PLAYED']."</b> ".$total[3]."</p>
								<p class='text-left'><b>".$lang['STATS_KILLS']."</b> ".$total[0]."</p>
								<p class='text-left'><b>".$lang['STATS_DEATHS']."</b> ".$total[1]."</p>
								<p class='text-left'><b>".$lang['STATS_ASSISTS']."</b> ".$total[2]."</p>
								<p class='text-left'><b>KDA</b> ".$kda."</p>
							</div>
						</div>
					</div>
					</div>";
			
			
			print "</div>";
			$listaPartidas = $info->getMatchHistory($id, $_GET['champId']);
			$listaPartidas = json_decode($listaPartidas);
			$listaPartidas = $listaPartidas->matches;
			//$i<count($listaPartidas)
			if(count($listaPartidas)<3){
				$tope = count($listaPartidas);
			}
			else{
				$tope = 3;
			}
			echo "<div id='partidas'>";
			for($i=0; $i<$tope; $i++){
				$idPartida = $listaPartidas[$i]->matchId;
				try{
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
					echo "<span>Ranked | ".$lang['MATCH_MAP_'.$mapaJuego.'']."</span><span class='fechapartida'><span title='".$lang['MATCH_DATE_TITLE']."'>$fecha</span>  <span title='".$lang['MATCH_DURATION_TITLE']."'>$tiempoHoras$tiempoMins:$tiempoSegs</span></span>";
					echo "</div>";
					$participantes = $partida->participants;
					$nom_participantes = $partida->participantIdentities;
					for($z=0; $z<count($nom_participantes); $z++){
						$jugador = $nom_participantes[$z]->player;
						$id_participante[$z] = $jugador-> summonerId;
					}
					for($j=0; $j<count($participantes); $j++){
						if($id == $id_participante[$j]){
							//This should save match players data on database, but page load would cause a 500 error
							//so function is omitted and will be done while loading next matches through ajax for not
							//causing load errors.
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
						}	
					}
				}
				catch (Exception $e){
					if(strpos($e, 'SERVER_ERROR')){
						echo "<p>Ha habido un error al cargar los datos de la partida. Prueba a actualizar la página.</p>";
					}
					if(strpos($e, 'NOT_FOUND')){
						$tope++;
						continue;
					}
				}
				echo "</div>";
			}
			//FOOTER FIX
			if(count($listaPartidas)==1){
				$footermargin = "style='margin-top: 17.3%'";
			}
			echo "<div id='loading'></div>";	
			echo "</div>";	
			
			$_SESSION['contador'] = 3;
			echo "</body><span class='static'><footer $footermargin>".$lang['FOOTER_LEGAL']."</footer></span>";
		?>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
		<script>
			//LOAD MORE MATCHES WHILE SCROLLING
			//original source --> http://jsfiddle.net/2KhjJ/ (from stackoverflow -> http://goo.gl/DoR4Iq)
			function isScrolledIntoView(elem) {
				var docViewTop = $(window).scrollTop();
				var docViewBottom = docViewTop + $(window).height();
				var elemTop = $(elem).offset().top;
				var elemBottom = elemTop + $(elem).height();

				//console.log(docViewTop, docViewBottom, elemTop, elemBottom);
				return ((elemBottom >= docViewTop) && (elemTop <= docViewBottom) && (elemBottom <= docViewBottom) && (elemTop >= docViewTop)
			);}
			var timer;
			$(window).scroll(function () {
				clearTimeout(timer);
				timer = setTimeout(function() {
					if (isScrolledIntoView($('footer'))) {
						loadMore();
						return false;
					}
				}, 500);
			});
			function loadMore() {
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() {
					if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
						document.getElementById("partidas").innerHTML = document.getElementById("partidas").innerHTML + xmlhttp.responseText;
						$("#loading").remove();
					}
				};
				document.getElementById("loading").innerHTML =  '<center><span class="encabezado1"><?php echo $lang['MATCH_LOADING'];?></span><img width="64px" src="images/loading.gif" /></center>';
				xmlhttp.open("GET", "loadmore?nomInvocador=<?php echo $_GET['nomInvocador']?>&champId=<?php echo $_GET['champId']?>&server=<?php echo $_GET['server']?>", true);
				xmlhttp.send();
			}
		</script>
		<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/main.css">
</html>