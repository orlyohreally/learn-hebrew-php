<?php
session_start();
require '../includes/connect.php';
$res = [];
$res['status'] = 'error';
$res['msg'] = 'Ощибка!';
//print_r(json_decode($_POST['words']));
$words = json_decode($_POST['words']);
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
			$added = 0;
			foreach($words as $item=>$value) {
				if($list = $conn->query('insert into word_list (webuser_list_id, word_id) values ('.$list_id.', '.$value.')')) {
					$added = $added + 1;
				}
			}
			if($added == sizeof($words)) {
				$res['status'] = 'success';
				$res['msg'] = 'OK';
			}
			else {
				$res['msg'] = 'При обновлении произошла ошибка';
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