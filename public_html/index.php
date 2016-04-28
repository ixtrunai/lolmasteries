<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="Consulta las maestrías de ti y tus amigos desde aquí!">
    <meta name="author" content="IXTR Unai">
    <link rel="icon" href="../../favicon.ico">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
    <title>Búsqueda de invocador</title>
  </head>

  <body>
    <div class="container">
	  <form action="index.php" method="GET">
			<h2>Busca un invocador</h2>
			<label for="inputSummoner" class="sr-only">Nombre de invocador</label>
			<input title="Introduce un nombre de invocador" type="text" name="nomInvocador" id="inputSummoner" class="form-control" placeholder="Nombre de invocador" required autofocus><br>
		   <label for="inputServer" class="sr-only">Servidor:</label>
			<select name="inputServer" title="Selecciona el servidor" id="inputServer" class="form-control">
				<option title="Brasil" value="br">BR</option>
				<option title="EU Nórdico y este" value="eune">EUNE</option>
				<option title="EU Oeste" value="euw">EUW</option>
				<option title="Japón" value="jp">JP</option>
				<option title="Korea" value="kr">KR</option>
				<option title="Latinoámerica Norte" value="lan">LAN</option>
				<option title="Latinoámerica Sur" value="las">LAS</option>
				<option title="Norteámerica" value="na">NA</option>
				<option title="Oceanía" value="oc">OCE</option>
				<option title="Cyka blyat" value="ru">RU</option>
				<option title="Turquía" value="tr">TR</option>
			</select><br>
			<!--<div class="checkbox">
			  <label>
				<input type="checkbox" value="remember-me"> Recuerdame
			  </label>
			</div>-->
			<button class="btn btn-lg btn-primary btn-block" name="buscar" type="submit">Buscar</button>
      </form>
		<?php 
			include "php-riot-api.php";
			include "FileSystemCache.php";
			if(isset($_GET['buscar']) && isset($_GET['nomInvocador'])){
				$server = preg_replace('/[0-9]+/', '', $_GET['inputServer']);
				$info = new riotapi($server, new FileSystemCache('cache/'));
				$summId = $info->obtenerId($_GET['nomInvocador'], $server);
				$info = $info->getMasteries($summId, "champions");
				
				$info = json_decode($info);
				//var_dump($info);
				print "<table class='table table-bordered'>";
				print "<thead><tr><th>Campeon</th><th>Nivel</th><th>Puntos de maestria</th><th>Rango más alto</th><th>Jugado por última vez</th></tr></thead><tbody>";
				for($i=0; $i<count($info); $i++){
					$idCampeon = $info[$i] -> championId;
					$nivelCampeon = $info[$i] -> championLevel;
					$puntosMaestria = $info[$i] -> championPoints;
					$ultimaVezJugado = $info[$i] -> lastPlayTime;
					$rangoMasAlto = $info[$i] -> highestGrade;
					$fecha = $ultimaVezJugado/1000;
					$fecha = date("d/m/Y H:i:s", $fecha);
					print "<tr><td>$idCampeon</td><td>$nivelCampeon</td><td>$puntosMaestria</td><td>$rangoMasAlto</td><td>$fecha</td></tr>";
				}
				print "</tbody></table>";
				
			}
		?>
    </div> <!-- /container -->
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>