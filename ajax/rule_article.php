<?php
	require '../includes/check_role.php';
	require '../includes/connect.php';
	require '../vendor/autoload.php';
	use voku\helper\URLify;
	if(!isset($_SESSION['user_id'])) {
		echo '{"status": "error", "msg": "Нет доступа к данному действию"}';
		die();
	}
	if(!isset($_POST['title']) || !isset($_POST['content']) || !isset($_POST['description'])) {
		echo '{"status": "error", "msg": "Укажите обязательныее данные"}';
		die();
	}
	$res = [];
	$res['status'] = 'error';
	$res['msg'] = 'Ошибка!';
	$rule_article = [];
	if(isset($_POST['id']))
		$rule_article['id'] = (int)$_POST['id'];
	else
		$rule_article['id'] = 0;
	$rule_article['title'] =  addslashes($_POST['title']);
	$rule_article['slug'] = URLify::filter($rule_article['title']);
	$rule_article['content'] = addslashes($_POST['content']);
	$rule_article['description'] = addslashes($_POST['description']);
	
	if($rule_article['id'] > 0) {
		if($list = $conn->query('update rule_article set description = "'.$rule_article['description'].'", slug = "'.$rule_article['slug'].'", title = "'.$rule_article['title'].'", content = "'.$rule_article['content'].'" where id = '.$rule_article['id'])) {
			$res['status'] = 'success';
			$res['slug'] = $rule_article['slug'];
			$res['sql'] = 'update rule_article set description = "'.$rule_article['description'].'", slug = "'.$rule_article['slug'].'", title = "'.$rule_article['title'].'", content = "'.$rule_article['content'].'" where id = '.$rule_article['id'];
			$res['msg'] = 'Статья успешно была обновлена';
		}
	}
	else {
		if($list = $conn->query('insert into rule_article (title, content, slug, description) values ("'.$rule_article['title'].'", "'.$rule_article['content'].'", "'.$rule_article['slug'].'", "'.$rule_article['description'].'")')) {
			$res['status'] = 'success';
			$res['slug'] = $rule_article['slug'];
			$res['msg'] = 'Статья успешно была сохранена';
		}
	}
	echo json_encode($res);
?>