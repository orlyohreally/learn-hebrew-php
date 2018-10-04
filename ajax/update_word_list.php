<?php
session_start();
require '../includes/connect.php';
if(!isset($_POST['name']) || !isset($_POST['old_name'])) {
	echo '{"status": "error", "msg": "Заполните обязательные поля"}';
	die();
}
$res = [];
$res['status'] = 'error';
$res['msg'] = 'Ощибка!';
$old_name = addslashes($_POST['old_name']);
$name = addslashes($_POST['name']);
if(isset($_SESSION['user_id'])) {
	if($list = $conn->query('select count(*) from webuser_list where webuser_id = '.$_SESSION['user_id'].' and name = "'.$old_name.'"')) {
		if($row = $list->fetch_assoc()) {
			if($row['count(*)'] == 1) {
				if($list = $conn->query('select count(*) from webuser_list where webuser_id = '.$_SESSION['user_id'].' and name = "'.$name.'"')) {
					if($row = $list->fetch_assoc()) {
						if($row['count(*)'] == 0) {
							if($list = $conn->query('update webuser_list set name = "'.$name.'" where webuser_id = '.$_SESSION['user_id'].' and name = "'.$old_name.'"')) {
								$res['name'] = $name;
								$res['msg'] = 'OK';
								$res['status'] = 'success';
							}
							else {
								$res['msg'] = 'При обновлении списка произошла ошибка';
							}
						}
						else
							$res['msg'] = 'Список с таким названием уже есть';
					}
				}
			}
			else
				$res['msg'] = 'Список не найден';
		}
	}
}
else {
	echo '{"status": "error", "msg": "Для данного действия необходимо авторизаваться"}';
	die();
}
echo json_encode($res);
?>