<html>
<head>
	<meta name="description" content="<?php echo $lang['HEAD_DESCRIPTION']; ?>">
	<meta name="keywords" content="lolmasteries, lol masteries, lol champion masteries, my champion masteries, maestrias lol, maestrias de campeon lol, maestrias de campeon, lolmaesteries.esy.es, lol.masteries">
    <meta name="author" content="IXTR Unai">
    <link rel="icon" href="images/favicon.png">
</head>
<body>
<div id="tabla">
	<div class="masteriesTable">
	<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.11/js/dataTables.bootstrap.min.js"></script>
	<script>
		//Original source:  https://www.datatables.net/
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
	if(isset($_GET['view'])){
		include_once 'campeones.php';
		include_once "php-riot-api.php";
		include_once "FileSystemCache.php";
		$info = new riotapi($server, new FileSystemCache('cache/'));
		//get ddragon version for loading images correctly
		$ddragon = $info->getStatic('versions');
		$ddragon = explode('"', $ddragon);
		$_SESSION['ddragon'] = $ddragon[1];
		$nombre = $invocador->name;
		$nivel = $invocador->summonerLevel;
		$id = $invocador->id;
		//PRINT CHAMPS TABLE
		print "<table id='masteriesTable' class='table table-bordered, masteriesTable'>";
		print "<thead><tr><th>".$lang['TABLE_CHAMPION']."</th><th>Summoner</th><th>".$lang['TABLE_LEVEL']."</th><th>".$lang['TABLE_MASTERY_POINTS']."</th><th>".$lang['TABLE_MAX_GRADE']."</th></tr></thead><tbody>";
		for($i=0; $i<count($maestrias); $i++){
			$campeon = $nom_campeon[$idCampeon];
			$sql_select = mysql_query("SELECT  from champ$idCampeon where summ_id = '$id'", $conexion);

			print "<tr><td><a title='".$lang['TABLE_CHAMP_TITLE']."$campeon' href='matchistory.php?server=$server&nomInvocador=".$_GET['nomInvocador']."&champId=$idCampeon'><img width='32px' src='http://ddragon.leagueoflegends.com/cdn/".$_SESSION['ddragon']."/img/champion/$campeon.png'/> $campeon</a></td><td><img title='".$lang['TABLE_LEVEL_TITLE']."$nivelCampeon' width='32px' src='images/masteries/mastery_lvl$nivelCampeon.png'/><span style='visibility:hidden;'>$nivelCampeon</span></td><td>$puntosMaestria</td><td>$rangoMasAlto</td><td>$fecha</td></tr>";
			$loaded = true;
		}
		print "</tbody></table>";
		$footer = "static"; //'cause this table was printed the footer will be static
	}
	}
	else{
		header("Location: leaderboards.php");
	}

?>
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