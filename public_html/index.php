<?php 
	include_once 'lang/common.php';
	session_start();	
	$conexion = mysql_connect("mysql.hostinger.es", "u772650915_unai", "-ElPutoAmo96-") or die("No se puede conectar al servidor");
	Mysql_select_db ("u772650915_loldb") or die ("No se puede seleccionar");
?>
<html lang="es"><!--manifest="localCache.appcache"-->
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="<?php echo $lang['HEAD_DESCRIPTION']; ?>">
	<meta name="keywords" content="lolmasteries, lol masteries, lol champion masteries, my champion masteries, maestrias lol, maestrias de campeon lol, maestrias de campeon, lolmaesteries.esy.es, lol.masteries">
    <meta name="author" content="IXTR Unai">
    <link rel="icon" href="images/favicon.png">
	<!--<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">-->
    <title><?php echo $lang['INDEX_PAGE_TITLE']; ?></title>
  </head>

  <body>
	<header>
		<div id='menu'>
			<ul>
				<li><a href='index.php'>LoL Masteries</a></li>
				<li class='last'><a href='leaderboards.php'><?php echo $lang['MENU_LEADERBOARDS']; ?></a></li>
			</ul>
			<!--<a href='index.php'>LoL Masteries</a> |
			<a href='index.php'>Leaderboards</a>-->
		</div>
		<div id="languages">
			<?php
				header('Content-Type: text/html; charset=UTF-8');
				echo $lang['LANG_SELECT'];
				//IF SOMEONE SEARCHED FOR A SUMMONER
				if(isset($_GET['nomInvocador'])){
					//IF SERVER WAS SELECTED
					if(isset($_GET['inputServer'])){
						$nombre = str_replace(" ","+",$_GET['nomInvocador']);
						echo "<a href='index.php?nomInvocador=".$nombre."&inputServer=".$_GET['inputServer']."&lang=en&buscar='>English</a> | ";
						echo "<a href='index.php?nomInvocador=".$nombre."&inputServer=".$_GET['inputServer']."&lang=es&buscar='>Español</a>";
					}
					//IF SERVER WASNT SELECTED BUT A SERVER WAS SAVED
					else if(isset($_SESSION['servidor'])){
						$nombre = str_replace(" ","+",$_GET['nomInvocador']);
						echo "<a href='index.php?nomInvocador=".$nombre."&inputServer=".$_SESSION['servidor']."&lang=en&buscar='>English</a> | ";
						echo "<a href='index.php?nomInvocador=".$nombre."&inputServer=".$_SESSION['servidor']."&lang=es&buscar='>Español</a>";
					}
					else{
						echo '<a href="index.php?lang=en">English</a> | ';
						echo '<a href="index.php?lang=es">Español</a>';
					}
				}
				//DEFAULT PAGE LOAD (NO SEARCHES)
				else{
					echo '<a href="index.php?lang=en">English</a> | ';
					echo '<a href="index.php?lang=es">Español</a>';
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
	
		<div id="tabla">
			<div class="masteriesTable">
			<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
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
					$('#masteriesTable').DataTable( {
						"paging":   false,
						"info":     false,
						"order": [[ 2, "desc" ]], //Sort by mastery points by default
						"language": {
							//Set language for DataTable elements
							"url":"lang/<?php echo $lang['TABLE_SEARCHBOX_SET_LANG']?>.json"
						},
						"columnDefs": [ {
							"type": "rank",  //set rank column to type rank to use the correct sorting function
							"targets": 3 //col number (count starts in 0)
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
				$footer; //<-- This will set the footer position later(fixed or static)
				
				//IF SOMEONE TRIES TO SEARCH FOR A SUMMONER
				if(isset($_GET['buscar']) && isset($_GET['nomInvocador'])){
					$server; //<-- This will contain the region for the search
					//IF NO SERVER WAS SELECTED
					if($_GET['inputServer'] == "null" || empty($_GET['inputServer'])){
						//IF THERE IS NO SAVED SERVER
						if(empty($_SESSION['servidor'])){
							header("Location: index.php");
						}
					}
					try{
						//IF A SERVER WAS SELECTED
						if(!empty($_GET['inputServer'])){
							$server = $_GET['inputServer']; //<--This will set the region for the search
						}
						//IF A SERVER WASN´T SELECTED (BUT THERE IS A SAVED SERVER)
						else{
							$server = $_SESSION['servidor']; //<--This will set the region for the search
						}
						$info = new riotapi($server, new FileSystemCache('cache/'));
						$summId = $info->obtenerId($_GET['nomInvocador'], $server);//<-- this gets the Id from a summoner on the selected region
						$maestrias = $info->getMasteries($summId, "champions");
						$maestrias = json_decode($maestrias);
						$invocador = $info->getSummonerByName($_GET['nomInvocador'], $server);
						$invocador = json_decode($invocador);
						$buscar = strtolower($_GET['nomInvocador']);
						$buscar = preg_replace('/\s+/', '', $buscar);
						$invocador = $invocador->$buscar;
						$icono = $invocador->profileIconId;
						//get ddragon version for loading images correctly
						$ddragon = $info->getStatic('versions');
						$ddragon = explode('"', $ddragon);
						$_SESSION['ddragon'] = $ddragon[1];
						$nombre = $invocador->name;
						$nivel = $invocador->summonerLevel;
						$id = $invocador->id;
						print "<div class='encabezado'><img class='summonerIcon' src='http://ddragon.leagueoflegends.com/cdn/".$_SESSION['ddragon']."/img/profileicon/$icono.png'></img> $nombre</div>";
						//PRINT CHAMPS TABLE
						print "<table id='masteriesTable' class='table table-bordered, masteriesTable'>";
						print "<thead><tr><th>".$lang['TABLE_CHAMPION']."</th><th>".$lang['TABLE_LEVEL']."</th><th>".$lang['TABLE_MASTERY_POINTS']."</th><th>".$lang['TABLE_MAX_GRADE']."</th><th>".$lang['TABLE_LAST_PLAYED']."</th></tr></thead><tbody>";
						for($i=0; $i<count($maestrias); $i++){
							$idCampeon = $maestrias[$i] -> championId;
							$nivelCampeon = $maestrias[$i] -> championLevel;
							$puntosMaestria = $maestrias[$i] -> championPoints;
							$ultimaVezJugado = $maestrias[$i] -> lastPlayTime;
							$rangoMasAlto = $maestrias[$i] -> highestGrade;
							$fecha = $ultimaVezJugado/1000;
							$fecha = date("Y/m/d - H:i:s", strtotime('+2 hours', $fecha));
							$campeon = $nom_campeon[$idCampeon];
							$sql_select = mysql_query("SELECT points from champ$idCampeon where summ_id = '$id'", $conexion);
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
								mysql_query("INSERT INTO champ$idCampeon VALUES ('$id', '$server', '$puntosMaestria', '$fecha', '$nivelCampeon', '$rangoMasAlto' )", $conexion) or die ("fallo al subir a bdd");
							}
							else if($result[0]<$puntosMaestria){
								mysql_query("DELETE FROM champ$idCampeon WHERE summ_id='$id'", $conexion) or die ("fallo al eliminar de bdd");
								mysql_query($sql_create, $conexion);
								mysql_query("INSERT INTO champ$idCampeon VALUES ('$id', '$server', '$puntosMaestria', '$fecha', '$nivelCampeon', '$rangoMasAlto' )", $conexion) or die ("fallo al subir a bdd");
							}
							print "<tr><td><a title='".$lang['TABLE_CHAMP_TITLE']."$campeon' href='matchistory.php?server=$server&nomInvocador=".$_GET['nomInvocador']."&champId=$idCampeon'><img width='32px' src='http://ddragon.leagueoflegends.com/cdn/".$_SESSION['ddragon']."/img/champion/$campeon.png'/> $campeon</a></td><td><img title='".$lang['TABLE_LEVEL_TITLE']."$nivelCampeon' width='32px' src='images/masteries/mastery_lvl$nivelCampeon.png'/><span style='visibility:hidden;'>$nivelCampeon</span></td><td>$puntosMaestria</td><td>$rangoMasAlto</td><td>$fecha</td></tr>";
							$loaded = true;
						}
						print "</tbody></table>";
						$footer = "static"; //'cause this table was printed the footer will be static
					}
					catch (Exception $e){
						if(strpos($e, 'NOT_FOUND')){
							echo "<div id='exception'>".$lang['EXCEPTION_NOT_FOUND']."</div>";
						}
					}
					
				}
				if($loaded==true){
					$containerclass = "container_bot";
					$autofocus = "";
				}
				else{
					$containerclass = "container";
					$autofocus = "autofocus";
				}
			?>
			</div>
		</div>
		<div class="<?php echo $containerclass;?>">
	  <form action="index.php" method="GET">
			<h2><?php echo $lang['SEARCH_TITLE']; ?></h2>
			<label for="inputSummoner" class="sr-only"><?php echo $lang['FORM_SUMMONER_NAME']; ?></label>
			<input title="<?php echo $lang['FORM_SUMMONER_NAME_TITLE']; ?>" type="text" name="nomInvocador" id="inputSummoner" class="form-control" placeholder="<?php echo $lang['FORM_SUMMONER_NAME']; ?>" <?php echo $autofocus ?> required><br>
		   <label for="inputServer" class="sr-only"><?php echo $lang['FORM_SERVER']; ?></label>
			<select name="inputServer" title="<?php echo $lang['FORM_SERVER_TITLE']; ?>" id="inputServer" class="form-control">
				<option title="<?php echo $lang['FORM_SERVER_TITLE']; ?>" <?php if(empty($_SESSION['servidor'])){echo "value='null' disabled ";}else{echo "value='".$_SESSION['servidor']."'";}?> selected><?php if(empty($_SESSION['servidor'])){echo $lang['FORM_SERVER_TITLE'];}else{echo strtoupper($_SESSION['servidor']);} ?></option>
				<option title="<?php echo $lang['FORM_SERVER_BR_TITLE']; ?>" value="br">BR</option>
				<option title="<?php echo $lang['FORM_SERVER_EUNE_TITLE']; ?>" value="eune">EUNE</option>
				<option title="<?php echo $lang['FORM_SERVER_EUW_TITLE']; ?>" value="euw">EUW</option>
				<option title="<?php echo $lang['FORM_SERVER_JP_TITLE']; ?>" value="jp">JP</option>
				<option title="<?php echo $lang['FORM_SERVER_KR_TITLE']; ?>" value="kr">KR</option>
				<option title="<?php echo $lang['FORM_SERVER_LAN_TITLE']; ?>" value="lan">LAN</option>
				<option title="<?php echo $lang['FORM_SERVER_LAS_TITLE']; ?>" value="las">LAS</option>
				<option title="<?php echo $lang['FORM_SERVER_NA_TITLE']; ?>" value="na">NA</option>
				<option title="<?php echo $lang['FORM_SERVER_OCE_TITLE']; ?>" value="oc">OCE</option>
				<option title="<?php echo $lang['FORM_SERVER_RU_TITLE']; ?>" value="ru">RU</option>
				<option title="<?php echo $lang['FORM_SERVER_TR_TITLE']; ?>" value="tr">TR</option>
			</select>
			<div class="checkbox">
			  <label>
				<input <?php if(!empty($_SESSION['servidor'])){echo "checked";}?> type="checkbox" name="guardarServidor" value="true"> <?php echo $lang['FORM_SERVER_REMEMBER']; ?>
			  </label>
			  
			</div>
			<button class="btn btn-lg btn-primary btn-block" id="buscar" name="buscar" type="submit"><?php echo $lang['FORM_SERVER_SEARCH']; ?></button>
			
      </form>
	  </div>
     <!-- /container -->
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <!--<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>-->
  </body>
  <?php
	if($footer == "static"){
		echo "<span class='static'><footer>".$lang['FOOTER_LEGAL']."</footer></span>";
	}
	else{
		echo "<span class='fixed'><footer>".$lang['FOOTER_LEGAL']."</footer></span>";
	}
  ?>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
</html>