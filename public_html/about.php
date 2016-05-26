<?php 
	include_once 'lang/common.php';
	include_once 'functions.php';
	session_start();	
	$conexion = mysql_connect($dbhost, $dbuser, $dbpass) or die("No se puede conectar al servidor");
	Mysql_select_db ($dbname) or die ("No se puede seleccionar");
	header('Content-Type: text/html; charset=UTF-8');
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
    <title><?php echo $lang['MENU_ABOUT']; ?></title>      
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
				echo $lang['LANG_SELECT'];
				echo '<a href="about?lang=en">English</a> | ';
				echo '<a href="about?lang=es">Español</a>';
			?>
		</div>
	</header>
	<div class='aboutContainer'>
		<div class='aboutBloque1'>
			<h1>Estructura</h1>
			<p>El sitio web esta compuesto por las siguientes páginas: </p>
			<ul>
				<li>Páginas visibles:</li>
				<ul>
					<li><a href="index">index</a></li>
					<li><a href="livegame">livegame</a></li>
					<li><a href="leaderboards">leaderboards</a></li>
					<li><a href="matchistory">matchistory</a></li>
					
				</ul>
				<li>Páginas "ocultas"</li>
				<ul>
					<li><a href="campeones">campeones</a></li>
					<li><a href="functions">functions</a></li>
					<li><a href="loadmore">loadmore</a></li>
					<li><a href="tracker">tracker</a></li>
				</ul>
				<li>API de Riot</li>
				<ul>
					<li><a href="php-riot-api">php-riot-api</a></li>
					<li><a href="FileSystemCache">FileSystemCache</a></li>
					<li><a href="CacheInterface">CacheInterface</a></li>
				</ul>
			</ul>
			<h4>Páginas visibles:</h4>
			<p>Estas son las páginas a las que puedes acceder para ver la información que necesites.<br><br>
			<b>Index:</b> Esta es la página principal, desde ella podrás realizar una búsqueda del invocador que quieras y tendrás dos opciones.<br>
			Si pulsas la opción "Maestrías de campeones", se te mostrará en una tabla todos los campeones que ha jugado desde que se introdujo el sistema de maestrías y sus respectivos niveles. Además, toda la información mostrada en la tabla se guardará en la base de datos.<br>
			Si pulsas la opción "Buscar en partida", el sistema te redirigirá a <b><a href="livegame">livegame</a></b>.<br><br>
			<b>Livegame (acceso por redirección):</b> Esta página es la encargada de mostrar la información de aquellos invocadores que se encuentran en una partida. Desde aquí podrás ver el nivel que tiene cada uno con el campeón que esta jugando en la partida.<br><br>
			<b>Leaderboards:</b> Esta página recoge información de una base de datos propia y según los datos guardados mostrará a aquellos jugadores que más puntos de maestría tengan con cada campeón.<br>
			Si crees que deberías de aparecer en esta página con algún campeón y no estas, realiza una búsqueda de tu nombre de invocador desde <b><a href="index">aquí</a></b> seleccionando la opción "Maestrías de campeones".<br><br>
			<b>Matchistory (acceso por redirección):</b> Para acceder a esta página deberás realizar la búsqueda de un invocador seleccionando la opción "Maestrías de campeones" y a continuación tendrás que hacer click en cualquier campeon que aparezca en la tabla.<br>
			Esta página mostrará por defecto las últimas 3 partidas clasificatorias jugadas con el campeon seleccionado, así cómo un resumen de las últimas 10 a la izquierda. Si haces scroll hacía abajo irá cargando más partidas de tres en tres.
			</p>
			<h4>Páginas ocultas:</h4>
			<p>Estas páginas contienen funciones y/o son de uso interno del sitio.<br><br>
			<b>Campeones:</b> Es un archivo que contiene un array con los nombres de los campeones por Id (ejemplo:  campeones[1] = "Annie").<br><br>
			<b>Functions:</b> Es uno de los archivos más importantes de la página. Este contiene funciones de acceso a la base de datos y de obtención de cierta información de la API además de otras cosas.<br><br>
			<b>Loadmore:</b> Es un archivo utilizado por <b><a href="matchistory">matchistory</a></b>. Este será el encargado de ir cargando las partidas de tres en tres una vez que hagamos scroll, además de guardar cierta información obtenida a través de esas partidas en la base de datos.<br><br>
			<b>Tracker:</b> Archivo que es ejecutado por el servidor cada 5 minutos y que sirve para añadir nuevos invocadores a la base de datos con el objetivo de que la información mostrada en <b><a href="leaderboards">leaderboards</a></b> sea lo más precisa posible.
			</p>
			<h4>API de Riot</h4>
			<p>Esta es una librería pública que facilita el acceso a la API de Riot. He modificado ligeramente algunas funciones para adaptarlas a mi página.<br><br>
			<b>php-riot-api:</b> Este es el archivo que contiene todas las funciones para acceder a la información de la API. Es el archivo más importante de la página y se usa en todas las páginas visibles.<br><br>
			<b>FileSystemCache:</b> Se encarga de almacenar en caché cierta información.<br><br>
			<b>CacheInterface:</b> Interfaz que se implementa en FileSystemCache.
			</p>
		</div>
		<div class='aboutBloque2'>
			<h1>Base de datos</h1>
			<p>El sitio utiliza una base de datos (BDD) para recolectar información sobre las búsquedas realizadas y poder utilizarla para mostrar la tabla con los mejores jugadores.<br>
			Actualmente se han analizado:</p>
			<table id="update" class="aboutTable table" >
				<tr><th>Invocadores analizados</th><th>Servidor</th></tr>
				<?php 
					//Regions
					$region[0] = "euw"; 
					$region[1] = "lan"; 
					$region[2] = "br"; 
					$region[3] = "jp"; 
					$region[4] = "kr"; 
					$region[5] = "eune"; 
					$region[6] = "las"; 
					$region[7] = "na"; 
					$region[8] = "oce"; 
					$region[9] = "tr"; 
					$region[10] = "ru"; 
					$total =0;
					for($i=0; $i<11; $i++){
						$sql_select = mysql_query("SELECT count(distinct summ_id) FROM champs_summs WHERE server='".$region[$i]."'", $conexion);
						$result = mysql_fetch_array($sql_select);
						echo "<tr><td>".$result[0]."</td><td>".strtoupper($region[$i])."</td></tr>";
						$total = $total + $result[0];
					}
					echo "<tr><td><b>$total</b></td><td><b>TOTAL</b></td></tr>";
				?>
				
			</table>
			
		</div>
	</div>
	<script>
		setInterval(loadMore, 5000);
		function loadMore() {
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					document.getElementById("update").innerHTML = xmlhttp.responseText;
				}
			};
			xmlhttp.open("GET", "summonersUpdate.php", true);
			xmlhttp.send();
		}
	</script>
     <!-- /container -->
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <!--<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>-->
  </body>
  <span class='static'><footer><?php echo $lang['FOOTER_LEGAL'];?></footer></span>
</html>