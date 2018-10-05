<?php
session_start();
require '../includes/connect.php';
$res = [];
$res['status'] = 'error';
$res['msg'] = 'Ошибка!';
if(isset($_SESSION['user_id'])) {
	if(!isset($_POST['list_id'])){
		echo '{"status": "error", "msg": "Не указан список"}';
		die();
	}
	$list_id = (int)$_POST['list_id'];
	if($list = $conn->query('select id from webuser_list where webuser_id = '.$_SESSION['user_id'].' and id = '.$list_id)) {
		$row = $list->fetch_assoc();
		$res['rows'] = mysqli_num_rows($list);
		if(mysqli_num_rows($list) == 1) {
				if($list = $conn->query('delete from word_list where webuser_list_id = '.$list_id)) {
					$res['status'] = 'success';
					$res['msg'] = 'OK';
				}
		}
		else
			$res['msg'] = 'Нет доступа к этому действию';
	}
}
else {
	echo '{"status": "error", "msg": "Для данного действия необходимо авторизаваться"}';
	die();
}
echo json_encode($res);
?>