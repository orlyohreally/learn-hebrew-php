<?php
session_start();
require '../includes/connect.php';
require '../includes/utils.php';
$res = [];
$res['status'] = 'error';
$res['msg'] = 'Ошибка!';
$words = json_decode($_POST['words']);
/*if(isset($_SESSION['user_id'])) {*/
	if(!isset($_POST['task']) || !isset($_POST['lang'])){
		echo '{"status": "error", "msg": "Не указаные данные"}';
		die();
	}
	$added = 0;
	$code = randomString(5);
	foreach($words as $item=>$value) {
		if($list = $conn->query('insert into training (webuser_id, word_id, code) values ('.(isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '2').', '.$value.', "'.$code.'")')) {
			$added = $added + 1;
		}
	}
	if($added == sizeof($words)) {
		$res['status'] = 'success';
		$res['msg'] = 'OK';
		$res['code'] = stripslashes($code);
	}
	else {
		$res['msg'] = 'При формировании списка произошла ошибка';
	}
/*}
else {
	echo '{"status": "error", "msg": "Для данного действия необходимо авторизаваться"}';
	die();
}*/
echo json_encode($res);
?>