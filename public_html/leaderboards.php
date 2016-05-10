<?php
	include_once 'lang/common.php';
	include_once 'functions.php';
	header('Content-Type: text/html; charset=UTF-8');
	session_start();
	$conexion = mysql_connect("dbhost", "user", "pass") or die("No se puede conectar al servidor");
	Mysql_select_db ("db") or die ("No se puede seleccionar");
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
		<title><?php echo $lang['LEADERBOARDS_PAGE_TITLE']; ?></title>
	</head>
	<body>
		
		<header>
		<div id='menu'>
			<ul>
				<li><a href='index.php'>LoL Masteries</a></li>
				<li class='last'><a href='index.php'><?php echo $lang['MENU_LEADERBOARDS']; ?></a></li>
			</ul>
			<!--<a href='index.php'>LoL Masteries</a> |
			<a href='index.php'>Leaderboards</a>-->
		</div>
		<div id="languages">
			<?php
				header('Content-Type: text/html; charset=UTF-8');
				echo $lang['LANG_SELECT'];
				echo '<a href="index.php?lang=en">English</a> | ';
				echo '<a href="index.php?lang=es">Español</a>';
			?>
		</div>
	</header>
	<body>
		<div id='main_container'>
			<div id="masteries_by_region">
				<h3>Champion masteries by region</h3>
				<div id="region" class="panel panel-info">
					<div class="panel-heading"><?php echo $lang['FORM_SERVER_BR_TITLE']; ?></div>
					<div class="panel-body">
						<?php
							printLeaderboardsData('br');
						?>
					</div>
				</div>
				<div id="region" class="panel panel-info">
					<div class="panel-heading"><?php echo $lang['FORM_SERVER_EUNE_TITLE']; ?></div>
					<div class="panel-body">
						<?php
							printLeaderboardsData('eune');
						?>
					</div>
				</div>
				<div id="region" class="panel panel-info">
					<div class="panel-heading"><?php echo $lang['FORM_SERVER_EUW_TITLE']; ?></div>
					<div class="panel-body">
						<?php
							printLeaderboardsData('euw');
						?>
					</div>
				</div>
				<div id="region" class="panel panel-info">
					<div class="panel-heading"><?php echo $lang['FORM_SERVER_JP_TITLE']; ?></div>
					<div class="panel-body">
						<?php
							printLeaderboardsData('jp');
						?>
					</div>
				</div>
				<div id="region" class="panel panel-info">
					<div class="panel-heading"><?php echo $lang['FORM_SERVER_KR_TITLE']; ?></div>
					<div class="panel-body">
						<?php
							printLeaderboardsData('kr');
						?>
					</div>
				</div>
				<div id="region" class="panel panel-info">
					<div class="panel-heading"><?php echo $lang['FORM_SERVER_LAN_TITLE']; ?></div>
					<div class="panel-body">
						<?php
							printLeaderboardsData('lan');
						?>
					</div>
				</div>
				<div id="region" class="panel panel-info">
					<div class="panel-heading"><?php echo $lang['FORM_SERVER_LAS_TITLE']; ?></div>
					<div class="panel-body">
						<?php
							printLeaderboardsData('las');
						?>
					</div>
				</div>
				<div id="region" class="panel panel-info">
					<div class="panel-heading"><?php echo $lang['FORM_SERVER_NA_TITLE']; ?></div>
					<div class="panel-body">
						<?php
							printLeaderboardsData('na');
						?>
					</div>
				</div>
				<div id="region" class="panel panel-info">
					<div class="panel-heading"><?php echo $lang['FORM_SERVER_OCE_TITLE']; ?></div>
					<div class="panel-body">
						<?php
							printLeaderboardsData('oce');
						?>
					</div>
				</div>
				<div id="region" class="panel panel-info">
					<div class="panel-heading"><?php echo $lang['FORM_SERVER_RU_TITLE']; ?></div>
					<div class="panel-body">
						<?php
							printLeaderboardsData('ru');
						?>
					</div>
				</div>
				<div id="region" class="panel panel-info lastRegion">
					<div class="panel-heading"><?php echo $lang['FORM_SERVER_TR_TITLE']; ?></div>
					<div class="panel-body">
						<?php
							printLeaderboardsData('tr');
						?>
					</div>
				</div>
			</div>
		</div>
		
	<?php echo "<span class='fixed'><footer>".$lang['FOOTER_LEGAL']."</footer></span>";?>
	</body>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
</html>
