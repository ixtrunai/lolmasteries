<?php
	/*
	-----------------
	Language: English
	-----------------
	
	$_GET['nomInvocador'] = saves the entered name for the next search
	$_GET['inputServer'] = saves the selected server for the next search
	
	*/
	$lang = array();
	
	//WINDOW TITLE (index.php)
	$lang['INDEX_PAGE_TITLE'] = '[BETA] Summoner search';
	$lang['HEAD_DESCRIPTION'] = 'Search for your champion masteries or for your friends champion masteries!';
	//WINDOW TITLE (matchistory.php)
	$lang['MATCHISTORY_PAGE_TITLE'] = '[BETA] Played rankeds';
	
	//WINDOW TITLE (leaderboards.php)
	$lang['LEADERBOARDS_PAGE_TITLE'] = '[INDEV] Top players';
	
	//FORM HEADER (index.php)
	$lang['SEARCH_TITLE'] = 'Search for summoner';
	
	//LANG SELECT
	$lang['LANG_SELECT'] = 'Change language: ';
	
	//MENU
	$lang['MENU_LEADERBOARDS'] = 'Leaderboards';
	
	//MATCH DATA (matchistory.php)
	$lang['MATCH_MAP_1'] = "Summoner's Rift (Summer variant)";
	$lang['MATCH_MAP_2'] = "Summoner's Rift (Autumn variant)";
	$lang['MATCH_MAP_8'] = 'The Crystal Scar';
	$lang['MATCH_MAP_10'] = 'Twisted Treeline';
	$lang['MATCH_MAP_11'] = "Summoner's Rift";
	$lang['MATCH_DATE_TITLE'] = 'Match date';
	$lang['MATCH_DURATION_TITLE'] = 'Match duration';
	$lang['MATCH_MULTIKILL_2'] = 'Double kill';
	$lang['MATCH_MULTIKILL_3'] = 'Triplle kill';
	$lang['MATCH_MULTIKILL_4'] = 'Quadra kill';
	$lang['MATCH_MULTIKILL_5'] = 'Pentakill';
	$lang['MATCH_MULTIKILL_6'] = 'Hexakill';
	$lang['MATCH_MULTIKILL_MAX'] = 'Unreal kill';
	$lang['MATCH_MINIONS_KILLED'] = 'Minions killed';
	$lang['MATCH_ADAMAGE_DEALT'] = 'Physical damage dealt';
	$lang['MATCH_MDAMAGE_DEALT'] = 'Magical damage dealt';
	$lang['MATCH_WARDS_PLACED'] = 'Wards placed';
	$lang['MATCH_WARDS_DESTROYED'] = 'Wards destroyed';
	$lang['MATCH_LOADMORE_BUTTON'] = 'Load more';
	
	//CHAMPION STATS (matchistory.php)
	$lang['STATS_CHAMP'] = 'Stats with ';
	$lang['STATS_TIME_PLAYED'] = 'Time played: ';
	$lang['STATS_KILLS'] = 'Kills: ';
	$lang['STATS_DEATHS'] = 'Deaths: ';
	$lang['STATS_ASSISTS'] = 'Assists: ';
	$lang['STATS_MATCHES_1'] = 'Based on last ';
	$lang['STATS_MATCHES_2'] = ' matches.';
	
	//FORM (index.php)
	$lang['FORM_SUMMONER_NAME'] = 'Summoner name';
	$lang['FORM_SUMMONER_NAME_TITLE'] = 'Enter a summoner name';
	$lang['FORM_SERVER'] = 'Server:'; //<-- este elemento no es visible
	$lang['FORM_SERVER_TITLE'] = 'Select a server';
	$lang['FORM_SERVER_REMEMBER'] = 'Remember the server';		
	$lang['FORM_SERVER_SEARCH'] = 'Search for summoner';
	
	//SERVERS (index.php)(form select tag -> options)
	$lang['FORM_SERVER_BR_TITLE'] = 'Brazil';
	$lang['FORM_SERVER_EUNE_TITLE'] = 'Europe Nordic & East';
	$lang['FORM_SERVER_EUW_TITLE'] = 'Europe West';
	$lang['FORM_SERVER_JP_TITLE'] = 'Japan';
	$lang['FORM_SERVER_KR_TITLE'] = 'Republic of Korea';
	$lang['FORM_SERVER_LAN_TITLE'] = 'Latin America North';
	$lang['FORM_SERVER_LAS_TITLE'] = 'Latin America South';
	$lang['FORM_SERVER_NA_TITLE'] = 'North America';
	$lang['FORM_SERVER_OCE_TITLE'] = 'Oceania';
	$lang['FORM_SERVER_RU_TITLE'] = 'Russia';
	$lang['FORM_SERVER_TR_TITLE'] = 'Turkey';
	
	 
	//TABLA DE CAMPEONES (index.php)
	$lang['TABLE_CHAMPION'] = 'Champion';
	$lang['TABLE_LEVEL'] = 'Level';
	$lang['TABLE_LEVEL_TITLE'] = 'Mastery level: ';
	$lang['TABLE_MASTERY_POINTS'] = 'Mastery points';
	$lang['TABLE_MAX_GRADE'] = 'Highest grade';
	$lang['TABLE_LAST_PLAYED'] = 'Last time played';
	$lang['TABLE_CHAMP_TITLE'] = 'Ranked games with ';
	$lang['TABLE_SEARCHBOX_SET_LANG'] = 'English'; //File based on --> http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/English.json
	
	//EXCEPTIONS (index.php)
	$lang['EXCEPTION_NOT_FOUND'] = 'No account with the name '. $_GET['nomInvocador'] .' has been found in the '. strtoupper($_GET['inputServer']) .' server.';
	
	//FOOTER (index.php)
	$lang['FOOTER_LEGAL'] = "<b>Created by <a href='https://twitter.com/ixtrunai'> IXTR Unai</a></b><br> LoL Masteries isn’t endorsed by Riot Games and doesn’t reflect the views or opinions of Riot Games or anyone officially involved in producing or managing League of Legends. League of Legends and Riot Games are trademarks or registered trademarks of Riot Games, Inc. League of Legends © Riot Games, Inc."
?>
