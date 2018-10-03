<?php
require '../includes/connect.php';
if(!isset($_POST['login']) || !isset($_POST['password'])){
	echo '{"status": "error", "msg": "Укажите обязательные поля"}';
	die();
}
$res = [];
$res['status'] = 'error';
$res['msg'] = 'Ошибка!';
$login  = addslashes($_POST['login']);
$password  = hash('sha256', $_POST['password']);
if($list = $conn->query('select count(*) from webuser where username="'.$login.'"')) {
	if($row = $list->fetch_assoc()) {
		if($row['count(*)'] > 0)
			$res['msg'] = 'Пользователь с таким логином уже зарегистрирован';
		else {
			if($list = $conn->query('insert into webuser (role_id, username, password) values (2, "'.$login.'", "'.$password.'")')) {
				
					$res['status'] = 'success';
					$res['u_id'] = $conn->insert_id;
					session_start();
					$_SESSION['user_id']	= $conn->insert_id;
			}
			else
				$res['msg'] = 'При регистрации произошла ошибка';

		}
	}
}
echo json_encode($res);
?>