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
if($list = $conn->query('select id from webuser where username="'.$login.'" and password="'.$password.'"')) {
	$row = $list->fetch_assoc();
	$res['rows'] = mysqli_num_rows($list);
	if(mysqli_num_rows($list) == 1) {
			$res['status'] = 'success';
			$res['u_id'] = $row['id'];
			session_start();
			$_SESSION['user_id'] = $row['id'];
	}
	else
		$res['msg'] = 'Пользователя с таким логином и паролем не найдено';
}
echo json_encode($res);
?>