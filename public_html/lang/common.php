<?php
	session_start();
	header('Cache-control: private'); // IE 6 FIX
	 
	if(isSet($_GET['lang'])){
		$lang = $_GET['lang'];
		// register the session and set the cookie
		$_SESSION['lang'] = $lang;
	}
	else if(isSet($_SESSION['lang'])){
		$lang = $_SESSION['lang'];
	}
	else{
		$lang = 'es';
	}
	switch ($lang) {
		case 'en':
			$lang_file = 'lang.en.php';
			break;
		case 'es':
			$lang_file = 'lang.es.php';
			break;
		default:
		$lang_file = 'lang.es.php';
	}
	include_once $lang_file;
?>