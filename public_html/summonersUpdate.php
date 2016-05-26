<?php 
	include_once 'functions.php';
	$conexion = mysql_connect($dbhost, $dbuser, $dbpass) or die("No se puede conectar al servidor");
	Mysql_select_db ($dbname) or die ("No se puede seleccionar");
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

	echo "<tr><th>Invocadores analizados</th><th>Servidor</th></tr>";
	$total = 0;
	for($i=0; $i<11; $i++){
		$sql_select = mysql_query("SELECT count(distinct summ_id) FROM champs_summs WHERE server='".$region[$i]."'", $conexion);
		$result = mysql_fetch_array($sql_select);
		echo "<tr><td>".$result[0]."</td><td>".strtoupper($region[$i])."</td></tr>";
		$total = $total + $result[0];
	}
	echo "<tr><td><b>$total</b></td><td><b>TOTAL</b></td></tr>";
?>