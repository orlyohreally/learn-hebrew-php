<?php
	require 'includes/check_role.php';
	require 'includes/connect.php';
	$par = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
	require 'includes/out.php';
	if($out != 'logout')
		include 'header.php';
	switch($out) {
		case 'main':
			include 'module/main.php';
			break;
		case 'login':
			include 'module/login.php';
			break;
		case 'logout':
			include 'module/logout.php';
			break;
		case 'words':
			include 'module/words.php';
			break;
		case 'verbs':
			include 'module/verbs.php';
			break;
		case 'nouns_exceptions':
			include 'module/nouns_exceptions.php';
			break;
		case 'word_lists':
			include 'module/word_lists.php';
			break;
		default:
			include '404.php';
	}
	if($out != 'logout')
		include 'footer.php';
?>