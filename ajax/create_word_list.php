<?php
session_start();
require '../includes/connect.php';
if(!isset($_POST['name'])) {
	echo '{"status": "error", "msg": "Заполните обязательные поля"}';
	die();
}
$res = [];
$res['status'] = 'error';
$res['msg'] = 'Ошибка!';
$name = addslashes($_POST['name']);
if(isset($_SESSION['user_id'])) {
	if($list = $conn->query('select count(*) from webuser_list where webuser_id = '.$_SESSION['user_id'].' and name = "'.$name.'"')) {
		if($row = $list->fetch_assoc()) {
			if($row['count(*)'] == 0) {
				if($list = $conn->query('insert into webuser_list (webuser_id, name) values ('.$_SESSION['user_id'].', "'.$name.'")')) {
					$res['name'] = $name;
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