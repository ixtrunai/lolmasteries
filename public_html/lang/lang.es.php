<?php
	/*
	-----------------
	Language: Spanish
	-----------------
	
	$_SESSION['servidor'] = guarda el servidor seleccionado para proximas busquedas
	$_GET['nomInvocador'] = guarda el nombre introducido para realizar la búsqueda
	$_GET['inputServer'] = guarda el servidor seleccionado para realizar la proxima busqueda
	
	*/
	$lang = array();

	//TITULO DE LA VENTANA (index.php)
	$lang['INDEX_PAGE_TITLE'] = 'Búsqueda de invocador';
	$lang['HEAD_DESCRIPTION'] = '¡Consulta tus maestrias de campeones o las de tus amigos!';
	
	//TITULO DE LA VENTANA (matchistory.php)
	$lang['MATCHISTORY_PAGE_TITLE'] = '[BETA] Rankeds jugadas';
	
	//TITULO DE LA VENTANA (leaderboards.php)
	$lang['LEADERBOARDS_PAGE_TITLE'] = '[BETA] Top jugadores';
	
	//ENCABEZADO DEL FORMULARIO (index.php)
	$lang['SEARCH_TITLE'] = 'Busca un invocador';
	
	//LANG SELECT
	$lang['LANG_SELECT'] = 'Cambiar idioma: ';
	
	//MENU
	$lang['MENU_LEADERBOARDS'] = 'Top jugadores';
	$lang['MENU_LIVEGAME'] = 'En partida';
	$lang['MENU_ABOUT'] = 'Información';
	
	//DATOS PARTIDAS (matchistory.php)
	$lang['MATCH_MAP_1'] = "Grieta del invocador (Variante de verano)";
	$lang['MATCH_MAP_2'] = "Grieta del invocador (Variante de otoño)";
	$lang['MATCH_MAP_8'] = 'Cicatriz de cristal';
	$lang['MATCH_MAP_10'] = 'Bosque retorcido';
	$lang['MATCH_MAP_11'] = 'Grieta del invocador';
	$lang['MATCH_DATE_TITLE'] = 'Fecha y hora de la partida';
	$lang['MATCH_DURATION_TITLE'] = 'Duración de la partida';
	$lang['MATCH_MULTIKILL_2'] = 'Asesinato doble';
	$lang['MATCH_MULTIKILL_3'] = 'Asesinato triple';
	$lang['MATCH_MULTIKILL_4'] = 'Asesinto cuadruple';
	$lang['MATCH_MULTIKILL_5'] = 'Pentakill';
	$lang['MATCH_MULTIKILL_6'] = 'Hexakill';
	$lang['MATCH_MULTIKILL_MAX'] = 'Unreal kill';
	$lang['MATCH_MINIONS_KILLED'] = 'Súbditos asesinados';
	$lang['MATCH_ADAMAGE_DEALT'] = 'Daño físico realizado';
	$lang['MATCH_MDAMAGE_DEALT'] = 'Daño mágico realizado';
	$lang['MATCH_WARDS_PLACED'] = 'Guardianes colocados';
	$lang['MATCH_WARDS_DESTROYED'] = 'Guardianes destruidos';
	$lang['MATCH_LOADING'] = 'Cargando partidas ';
	
	//STATS CON CAMPEON (matchistory.php)
	$lang['STATS_CHAMP'] = 'Estadísticas con ';
	$lang['STATS_TIME_PLAYED'] = 'Tiempo jugado: ';
	$lang['STATS_KILLS'] = 'Asesinatos: ';
	$lang['STATS_DEATHS'] = 'Muertes: ';
	$lang['STATS_ASSISTS'] = 'Asistencias: ';
	$lang['STATS_MATCHES_1'] = 'Basado en las últimas ';
	$lang['STATS_MATCHES_2'] = ' partidas.';

	
	//FORMULARIO (index.php)
	$lang['FORM_SUMMONER_NAME'] = 'Nombre de invocador';
	$lang['FORM_SUMMONER_NAME_TITLE'] = 'Introduce un nombre de invocador';
	$lang['FORM_SERVER'] = 'Servidor:'; //<-- este elemento no es visible
	$lang['FORM_SERVER_TITLE'] = 'Selecciona el servidor';
	$lang['FORM_SERVER_REMEMBER'] = 'Recordar servidor';		
	$lang['FORM_SERVER_SEARCH'] = 'Maestrias de campeones';
	$lang['FORM_SERVER_SEARCH_GAME'] = 'Buscar en partida';
	
	//SERVIDORES (index.php) (opciones de la etiqueta select)
	$lang['FORM_SERVER_BR_TITLE'] = 'Brasil';
	$lang['FORM_SERVER_EUNE_TITLE'] = 'EU nórdico y este';
	$lang['FORM_SERVER_EUW_TITLE'] = 'EU oeste';
	$lang['FORM_SERVER_JP_TITLE'] = 'Japón';
	$lang['FORM_SERVER_KR_TITLE'] = 'Corea';
	$lang['FORM_SERVER_LAN_TITLE'] = 'Latinoámerica Norte';
	$lang['FORM_SERVER_LAS_TITLE'] = 'Latinoámerica Sur';
	$lang['FORM_SERVER_NA_TITLE'] = 'Norteámerica';
	$lang['FORM_SERVER_OCE_TITLE'] = 'Oceanía';
	$lang['FORM_SERVER_RU_TITLE'] = 'Rusia';
	$lang['FORM_SERVER_TR_TITLE'] = 'Turquía';
	
	 
	//TABLA DE CAMPEONES (index.php/leaderboards.php)
	$lang['TABLE_CHAMPION'] = 'Campeon';
	$lang['TABLE_LEVEL'] = 'Nivel';
	$lang['TABLE_LEVEL_TITLE'] = 'Nivel de maestría: ';
	$lang['TABLE_MASTERY_POINTS'] = 'Puntos de maestría';
	$lang['TABLE_MAX_GRADE'] = 'Rango más alto';
	$lang['TABLE_LAST_PLAYED'] = 'Jugado por última vez';
	$lang['TABLE_CHAMP_TITLE'] = 'Rankeds jugadas con ';
	$lang['TABLE_SUMM_NAME'] = "Nombre de invocador";
	$lang['TABLE_SEARCHBOX_SET_LANG'] = 'Spanish';  //Archivo basado en --> http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json
	
	//TITULO PAGINA (livegame.php)
	$lang['H1_LIVEGAME'] = 'Información de la partida';
	
	//TOP JUGADORES (leaderboards.php)
	$lang['PAGE_HEADER'] = 'Maestrías de campeón por region';
	
	//EXCEPCIONES (index.php / livegame.php)
	$lang['EXCEPTION_NOT_FOUND'] = 'No se ha encontrado ninguna cuenta con el nombre '. $_GET['nomInvocador'] .' en el servidor de '. strtoupper($_GET['inputServer']) .'.';
	$lang['EXCEPTION_LIVEGAME_NOT_FOUND'] = $_GET['nomInvocador']. " no esta jugando.";
	
	//FOOTER (index.php)
	$lang['FOOTER_LEGAL'] = "<b>Página creada por <a href='https://twitter.com/ixtrunai'> IXTR Unai</a></b><br>	<b>Aviso legal:</b> LoL Masteries no esta apoyada por Riot Games y no refleja los puntos de vista u opiniones de Riot Games o de nadie oficialmente involucrado en la producción o gestión de League of Legends. League of Legends y Riot Games son marcas comerciales o marcas comerciales registradas de Riot Games, Inc. League of Legends © Riot Games, Inc."
?>