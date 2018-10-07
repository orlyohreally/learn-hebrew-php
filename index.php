<?php
	require 'includes/check_role.php';
	require 'includes/connect.php';
	$par = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
	require 'includes/out.php';
	switch($out) {
		case 'main':
			include 'header.php';
			include 'module/main.php';
			break;
		case 'login':
			include 'header.php';
			include 'module/login.php';
			break;
		case 'logout':
			include 'module/logout.php';
			break;
		case 'words':
			include 'header.php';
			include 'module/words.php';
			break;
		case 'verbs':
			include 'header.php';
			include 'module/verbs.php';
			break;
		case 'nouns_exceptions':
			include 'header.php';
			include 'module/nouns_exceptions.php';
			break;
		case 'word_lists':
			if(isset($_SESSION['user_id'])) {
				include 'header.php';
				include 'module/word_lists.php';
			}
			else {
				header('Location: /my-list/generic');
			}
			break;
		case 'word_list_details':
			$list_slug = isset($par[2]) ? $par[2] : '';
			/*if(isset($_SESSION['user_id'])) {*///not registered users can use generic word list
				if($list = $conn->query('select id, name from webuser_list where webuser_id = '.(isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 2).' and slug = "'.$list_slug.'"')) {
					$row = $list->fetch_assoc();
					if(mysqli_num_rows($list) == 1) {
						$list_id = $row['id'];
						$list_name = $row['name'];
						include 'header.php';
						include 'module/word_list_details.php';
					}
					else {
						include 'header.php';
						include '404.php';
					}
				}
				else {
					include 'header.php';
					include '404.php';
				}
			/*}
			else {
				header('Location: /login');
			}*/
			break;
		case 'rule_article':
			$rule_slug = isset($par[2]) ? $par[2] : '';
			if($rule_slug != '') {
				if($list = $conn->query('select id from rule_article where slug = "'.$rule_slug.'"')) {
					$row = $list->fetch_assoc();
					if(mysqli_num_rows($list) == 1) {
						$rule_article_id = $row['id'];
						include 'header.php';
						include 'module/rule_article.php';
					}
					else {
						include 'header.php';
						include '404.php';
					}
				}
			}
			else if($user_role == 'admin') {
				include 'header.php';
				include 'module/rule_article.php';
			}
			else {
				include 'header.php';
				include '404.php';
			}
			break;
		case 'training':
			include 'header.php';
			include 'module/training.php';
			break;
		default: {
			include 'header.php';
			include '404.php';
		}
	}
	if($out != 'logout')
		include 'footer.php';
?>