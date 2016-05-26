<?php 
	include_once 'lang/common.php';
	include_once 'functions.php';
	include_once 'campeones.php';
	include_once 'php-riot-api.php';
	include_once 'FileSystemCache.php';
	session_start();	
	$conexion = mysql_connect($dbhost, $dbuser, $dbpass) or die("No se puede conectar al servidor");
	Mysql_select_db ($dbname) or die ("No se puede seleccionar");
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
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.11/js/dataTables.bootstrap.min.js"></script>
    <title><?php echo $lang['INDEX_PAGE_TITLE']; ?></title>
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
					if(isset($_GET['inputServer'])){
						$nombre = str_replace(" ","+",$_GET['nomInvocador']);
						echo "<a href='livegame.php?nomInvocador=".$nombre."&inputServer=".$_GET['inputServer']."&lang=en&buscar='>English</a> | ";
						echo "<a href='livegame.php?nomInvocador=".$nombre."&inputServer=".$_GET['inputServer']."&lang=es&buscar='>Español</a>";
					}
					//IF SERVER WASNT SELECTED BUT A SERVER WAS SAVED
					else if(isset($_SESSION['servidor'])){
						$nombre = str_replace(" ","+",$_GET['nomInvocador']);
						echo "<a href='livegame.php?nomInvocador=".$nombre."&inputServer=".$_SESSION['servidor']."&lang=en&buscar='>English</a> | ";
						echo "<a href='livegame.php?nomInvocador=".$nombre."&inputServer=".$_SESSION['servidor']."&lang=es&buscar='>Español</a>";
					}
					else{
						echo '<a href="livegame.php?lang=en">English</a> | ';
						echo '<a href="livegame.php?lang=es">Español</a>';
					}
				}
				//DEFAULT PAGE LOAD (NO SEARCHES)
				else{
					echo '<a href="livegame.php?lang=en">English</a> | ';
					echo '<a href="livegame.php?lang=es">Español</a>';
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
	<div class="container">
		<?php 
			//IF SOMEONE TRIES TO SEARCH FOR A SUMMONER
			if(isset($_GET['buscar']) && isset($_GET['nomInvocador'])){
				$server; //<-- This will contain the region for the search
				//IF NO SERVER WAS SELECTED
				if($_GET['inputServer'] == "null" || empty($_GET['inputServer'])){
					//IF THERE IS NO SAVED SERVER
					if(empty($_SESSION['servidor'])){
						header("Location: index");
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
					$currentGame = $info->getCurrentGame($summId, $server);
					$currentGame = json_decode($currentGame);
					//var_dump ($currentGame);
					$participants = $currentGame->participants;				
					$info = new riotapi($server, new FileSystemCache('cache/'));
					//var_dump($participants);
					print "<center><h1>".$lang['H1_LIVEGAME']."</h1></center>";
					print "<table id='livegameTable' class='table table-bordered livegameTable'>";
					print "<tr><th>".$lang['TABLE_CHAMPION']."</th><th>".$lang['TABLE_LEVEL']."</th><th>".$lang['TABLE_SUMM_NAME']."</th></tr>";
					for($i=0; $i<count($participants); $i++){
						$summId = $participants[$i]->summonerId;
						$teamId = $participants[$i]->teamId;
						$summName = $participants[$i]->summonerName;
						$champId = $participants[$i]->championId;
						$campeon = $nom_campeon[$champId];
						$masteriesInfo = json_decode($info->getMasteries($summId , "champion/".$champId.""));
						//var_dump($masteriesInfo);
						$champLvl = $masteriesInfo->championLevel;
						if($teamId == 100){
							$trClass = "blueTeam";
						}
						else{
							$trClass = "redTeam";
						}
						print "<tr class='$trClass'><td><a href='leaderboards?champ=$champId&lang=".$_SESSION['lang']."'><img width='32px' src='http://ddragon.leagueoflegends.com/cdn/".$_SESSION['ddragon']."/img/champion/$campeon.png'/> $campeon</a></td><td><img title='".$lang['TABLE_LEVEL_TITLE']."".$champLvl."' width='32px' src='images/masteries/mastery_lvl$champLvl.png'/>$champLvl</td><td><a href='index?nomInvocador=$nombre&inputServer=$server&lang=".$_SESSION['lang']."&buscar='>$summName</a></td></tr>";
					}
					print "</table>";
					$footer = "static"; //'cause this table was printed the footer will be static
				}
				catch (Exception $e){
					if(strpos($e, 'NOT_FOUND')){
						echo "<div id='exception'>".$lang['EXCEPTION_LIVEGAME_NOT_FOUND']."</div>";
					}
				}
			}
		?>
		
		<form action="index" method="GET">
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
			<button class="botones priboton btn btn-lg btn-primary btn-block" id="buscar" name="buscar" type="submit"><?php echo $lang['FORM_SERVER_SEARCH']; ?></button>
			<button class="botones ultboton btn btn-lg btn-primary btn-block" formaction="livegame.php" id="buscar" name="buscar2" type="submit"><?php echo $lang['MENU_LIVEGAME']; ?></button>
	  </form>
	  </div>
  </body>
  <?php
	if($footer == "static"){
		echo "<span class='static'><footer>".$lang['FOOTER_LEGAL']."</footer></span>";
	}
	else{
		echo "<span class='fixed'><footer>".$lang['FOOTER_LEGAL']."</footer></span>";
	}
  ?>
</html>