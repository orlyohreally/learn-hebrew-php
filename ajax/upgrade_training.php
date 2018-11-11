<?php
session_start();
require '../includes/connect.php';
require '../includes/utils.php';
$res = [];
$res['status'] = 'error';
$res['msg'] = 'Ощибка!';
if(!isset($_POST['code']) || !isset($_POST['lang']) || !isset($_POST['task'])) {
	echo '{"status": "error", "msg": "Не указаны обязательные данные"}';
	die();
}
$code = $_POST['code'];
$new_code = randomString(5);
$all_words = (isset($_POST['all_words']) ? ($_POST['all_words'] == 'true' ? true : false) : false);
if($list = $conn->query('select * from training where (answered = false or tries > 1) and webuser_id = '.(isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 2).' and code = "'.$code.'"')) {
	if(mysqli_num_rows($list) && ((mysqli_num_rows($list) > 4) || $all_words)) {
		$res['new_code'] = $new_code;
		$added = false;
		while($row = $list->fetch_assoc()) {
			if($list1 = $conn->query('insert into training (webuser_id, word_id, code) values ('.(isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 2).', "'.$row['word_id'].'", "'.$new_code.'")')) {
				$added = true;
			}
		}
		if($added) {
			$res['status'] = 'success';
			$res['msg'] = 'OK';
		}
		else {
		}
	}
	else {
		$res['status'] = 'error';
		$res['msg'] = 'Недостаточно слов для тренировки';	
	}
}
echo json_encode($res);
?>