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
		<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/main.css">
		<title><?php echo $lang['LEADERBOARDS_PAGE_TITLE']; ?></title>		
	</head>
	<body>
		
		<header>
		<div id='menu'>
			<ul>
				<li><a href='index'>LoL Masteries</a></li>
				<li><a href='leaderboards'><?php echo $lang['MENU_LEADERBOARDS']; ?></a></li>
				<li class='last'><a href='about'><?php echo $lang['MENU_ABOUT']; ?></a></li>
			</ul>
			<!--<a href='index.php'>LoL Masteries</a> |
			<a href='index.php'>Leaderboards</a>-->
		</div>
		<div id="languages">
			<?php
				header('Content-Type: text/html; charset=UTF-8');
				echo $lang['LANG_SELECT'];
				if(isset($_GET['champ'])){
					echo '<a href="leaderboards?champ='.$_GET['champ'].'&lang=en">English</a> | ';
					echo '<a href="leaderboards?champ='.$_GET['champ'].'&lang=es">Español</a>';
				}
				else{
					echo '<a href="leaderboards?lang=en">English</a> | ';
					echo '<a href="leaderboards?lang=es">Español</a>';
				}
				
			?>
		</div>
	</header>
	<body>
		<div class="leaderboardsTable">
			<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
			<script src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
			<script src="https://cdn.datatables.net/1.10.11/js/dataTables.bootstrap.min.js"></script>
			<script>
				//Original source:  https://www.datatables.net/
				
				//Ranking sort function
				$.fn.dataTable.ext.type.order['rank-pre'] = function ( d ) {
					switch ( d ) {
						case 'S+':    return 15;
						case 'S': return 14;
						case 'S-':   return 13;
						case 'A+':   return 12;
						case 'A':   return 11;
						case 'A-':   return 10;
						case 'B+':   return 9;
						case 'B':   return 8;
						case 'B-':   return 7;
						case 'C+':   return 6;
						case 'C':   return 5;
						case 'C-':   return 4;
						case 'D+':   return 3;
						case 'D':   return 2;
						case 'D-':   return 1;
					}
					return 0;
				};
				$(document).ready(function() {
					$('#leaderboardsTable').DataTable( {
						"paging":   false,
						"info":     false,
						"order": [[ 0, "asc" ]], //Sort by champ name by default
						"language": {
							//Set language for DataTable elements
							"url":"lang/<?php echo $lang['TABLE_SEARCHBOX_SET_LANG']?>.json"
						},
						"columnDefs": [ {
							"type": "rank",  //set rank column to type rank to use the correct sorting function
							"targets": 5 //col number (count starts in 0)
						} ]
					} );
				} );
				$(document).ready(function() {
					$('#leaderboardsTable_champ').DataTable( {
						"paging":   false,
						"info":     false,
						"order": [[ 3, "desc" ]], //Sort by champ name by default
						"language": {
							//Set language for DataTable elements
							"url":"lang/<?php echo $lang['TABLE_SEARCHBOX_SET_LANG']?>.json"
						},
						"columnDefs": [ {
							"type": "rank",  //set rank column to type rank to use the correct sorting function
							"targets": 4 //col number (count starts in 0)
						} ]
					} );
				} );
			</script>
			<?php
				//API functions
				include "php-riot-api.php";
				include "FileSystemCache.php";
				//Champion names
				include "campeones.php";
				
				//PRINT TOP 20 or less PLAYERS FOR A CHAMPION
				if(isset($_GET['champ'])){
					echo "<center><h1><img width='64px' src='http://ddragon.leagueoflegends.com/cdn/".$_SESSION['ddragon']."/img/champion/".$nom_campeon[$_GET['champ']].".png'/> ".$nom_campeon[$_GET['champ']]."</h1></center>";
					echo "<table id='leaderboardsTable_champ' class='table table-bordered, leaderboardsTable'>";
					echo "<thead><tr><th>".$lang['TABLE_SUMM_NAME']."</th><th>Region</th><th>".$lang['TABLE_LEVEL']."</th><th>".$lang['TABLE_MASTERY_POINTS']."</th><th>".$lang['TABLE_MAX_GRADE']."</th><th>".$lang['TABLE_LAST_PLAYED']."</th></tr></thead><tbody>";
					$points_sql = "SELECT summ_id, points, level, grade, server, playTime FROM champs_summs WHERE champ_id='".$_GET['champ']."' ORDER BY points desc";
					$max = "SELECT count(summ_id) FROM champs_summs WHERE champ_id='".$_GET['champ']."' ORDER BY points desc";
					$puntos = mysql_query($points_sql, $conexion) or die("error al obtener puntos maximos <br> $points_sql");		
					$maxquery = mysql_query($max, $conexion) or die("error al obtener cantidad de jugadores<br> $max");		
					$max = mysql_fetch_array($maxquery);
					if($max[0]>20){
						$max[0] = 20;
					}
					for($i=0; $i<$max[0]; $i++){
						$info = mysql_fetch_array($puntos);
						$rito = new riotapi($info[4], new FileSystemCache('cache_leaders/'));
						$invocador = $rito->getSummoner($info[0], 'name');
						$invocador = json_decode($invocador);
						$nombre = $invocador->$info[0];					
						echo "<tr><td class='lesswidth'><a href='index?nomInvocador=$nombre&inputServer=$info[4]&lang=".$_SESSION['lang']."&buscar='>$nombre</a></td><td class='lesswidth'>".strtoupper($info[4])."</td></td><td class='lesswidth' value='".$info[2]."'><img title='".$lang['TABLE_LEVEL_TITLE']."".$info[2]."' width='32px' src='images/masteries/mastery_lvl".$info[2].".png'/> ".$info[2]."</td><td class='lesswidth'>".$info[1]."</td><td class='lesswidth'>".$info[3]."</td><td class='lesswidth'>".$info[5]."</td></tr>";																			
					}
					echo "</tbody></table>";
					if($max[0]<=4){
						$footerclass = "fixed";
					}
					else{
						$footerclass = "static";
					}
				}
				
				//PRINT A TOP PLAYER FOR EACH CHAMPION
				else{
					echo "<table id='leaderboardsTable' class='table table-bordered, leaderboardsTable'>";
					echo "<thead><tr><th>".$lang['TABLE_CHAMPION']."</th><th>".$lang['TABLE_SUMM_NAME']."</th><th>Region</th><th>".$lang['TABLE_LEVEL']."</th><th>".$lang['TABLE_MASTERY_POINTS']."</th><th>".$lang['TABLE_MAX_GRADE']."</th><th>".$lang['TABLE_LAST_PLAYED']."</th></tr></thead><tbody>";
					$sqlcount_champs = "SELECT COUNT( DISTINCT  champ_id) FROM  champs_summs";
					$numero = mysql_query($sqlcount_champs, $conexion) or die("error al obtener numero de campeones <br> $sqlcount_champs");
					$numero = mysql_fetch_array($numero);
					$totalChamps = $numero[0];
					$champs_sql = "SELECT DISTINCT champ_id FROM champs_summs ORDER BY champ_id ASC";
					$champs_sql = mysql_query($champs_sql, $conexion) or die("error al obtener campeones <br> $champs_sql");				
					for($i=0; $i<$totalChamps; $i++){
						//SELECT CHAMP_IDs 
						$champs_result = mysql_fetch_array($champs_sql);
						//SELECT MAX POINTS OBTAINED FOR A CHAMP
						$points_sql = "SELECT MAX(points) FROM champs_summs WHERE champ_id='".$champs_result[0]."'";
						$puntos = mysql_query($points_sql, $conexion) or die(mysql_query($points_sql, $conexion));
						$puntos = mysql_fetch_array($puntos);
						$summ_sql = "SELECT summ_id, points, level, grade, server, playTime FROM champs_summs where points ='".$puntos[0]."' and champ_id='".$champs_result[0]."'";
						$info = mysql_query($summ_sql, $conexion) or die("error al obtener summoner <br> $summ_sql");
						$info = mysql_fetch_array($info);
						$campeon = $nom_campeon[$champs_result[0]];
						//Summoner name
						try{
							$rito = new riotapi($info[4], new FileSystemCache('cache_leaders/'));
							$invocador = $rito->getSummoner($info[0], 'name');
							$invocador = json_decode($invocador);
							$nombre = $invocador->$info[0];			
							//print $info[4]." ".$nombre."<br>";
							echo "<tr><td class='lesswidth'><a href='leaderboards?champ=".$champs_result[0]."&lang=".$_SESSION['lang']."'><img width='32px' src='http://ddragon.leagueoflegends.com/cdn/".$_SESSION['ddragon']."/img/champion/$campeon.png'/> ".$campeon."</a></td><td class='lesswidth'><a href='index?nomInvocador=$nombre&inputServer=$info[4]&lang=".$_SESSION['lang']."&buscar='>$nombre</a></td><td class='lesswidth'>".strtoupper($info[4])."</td></td><td class='lesswidth' value='".$info[2]."'><img title='".$lang['TABLE_LEVEL_TITLE']."".$info[2]."' width='32px' src='images/masteries/mastery_lvl".$info[2].".png'/> ".$info[2]."</td><td class='lesswidth'>".$info[1]."</td><td class='lesswidth'>".$info[3]."</td><td class='lesswidth'>".$info[5]."</td></tr>";																			
						}
						catch (Exception $e){
							$rito = new riotapi($info[4], new FileSystemCache('cache_leaders/'));
							$invocador = $rito->getSummoner($info[0], 'name');
							$invocador = json_decode($invocador);
							$nombre = $invocador->$info[0];			
							//print $info[4]." ".$nombre."<br>";
							echo "<tr><td class='lesswidth'><a href='leaderboards?champ=".$champs_result[0]."&lang=".$_SESSION['lang']."'><img width='32px' src='http://ddragon.leagueoflegends.com/cdn/".$_SESSION['ddragon']."/img/champion/$campeon.png'/> ".$campeon."</a></td><td class='lesswidth'><a href='index?nomInvocador=$nombre&inputServer=$info[4]&lang=".$_SESSION['lang']."&buscar='>$nombre</a></td><td class='lesswidth'>".strtoupper($info[4])."</td></td><td class='lesswidth' value='".$info[2]."'><img title='".$lang['TABLE_LEVEL_TITLE']."".$info[2]."' width='32px' src='images/masteries/mastery_lvl".$info[2].".png'/> ".$info[2]."</td><td class='lesswidth'>".$info[1]."</td><td class='lesswidth'>".$info[3]."</td><td class='lesswidth'>".$info[5]."</td></tr>";																			
					
						}
					}
					echo "</tbody></table>";
					$footerclass = "static";
				}
				
				
			?>
		</div>


		<?php echo "<span class='$footerclass'><footer>".$lang['FOOTER_LEGAL']."</footer></span>";?>
	</body>
</html>