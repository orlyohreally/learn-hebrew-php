<?php
require '../includes/check_role.php';
require '../includes/connect.php';
require '../vendor/autoload.php';
use voku\helper\URLify;
if(!isset($_POST['name'])) {
	echo '{"status": "error", "msg": "Заполните обязательные поля"}';
	die();
}
$res = [];
$res['status'] = 'error';
$res['msg'] = 'Ошибка!';
$name = addslashes($_POST['name']);
$slug = URLify::filter($name);
if(isset($_SESSION['user_id'])) {
	if($list = $conn->query('select count(*) from webuser_list where webuser_id = '.$_SESSION['user_id'].' and slug = "'.$slug.'"')) {
		if($row = $list->fetch_assoc()) {
			if($row['count(*)'] == 0) {
				if($list = $conn->query('insert into webuser_list (webuser_id, name, slug) values ('.$_SESSION['user_id'].', "'.$name.'", "'.$slug.'")')) {
					$res['slug'] = $slug;
					$res['msg'] = 'OK';
					$res['status'] = 'success';
				}
				else {
					$res['msg'] = 'При создании списка произошла ошибка';
				}
			}
			else
				$res['msg'] = 'Список с таким названием уже есть';
		}
	}
}
else {
	echo '{"status": "error", "msg": "Для данного действия необходимо авторизаваться"}';
	die();
}
echo json_encode($res);
?>