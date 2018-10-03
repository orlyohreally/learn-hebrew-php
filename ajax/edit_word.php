<?php
session_start();
require '../includes/connect.php';
if(isset($_SESSION['user_id'])) {
	$list = $conn->query('select w.id from webuser w, role r where w.role_id = r.id and w.id = '.$_SESSION['user_id'].' and r.id = 1');
	if(mysqli_num_rows($list) != 1) {
		echo '{"status": "error", "msg": "Нет прав для обновления этих данных"}';
		die();
	}
}
else {
	echo '{"status": "error", "msg": "Для данного действия необходимо авторизаваться"}';
	die();
}
if(!isset($_POST['word']) || !isset($_POST['translation']) || !isset($_POST['gender'])){
	echo '{"status": "error", "msg": "Не указаны необходимые значения"}';
	die();
}
$res = [];
$res['status'] = 'error';
$res['msg'] = 'При добавлении произошла ошибка';
if(isset($_POST['id']))
	$id = (int)$_POST['id'];
else
	$id = 0;
$word = addslashes($_POST['word']);
$translation = addslashes($_POST['translation']);
$gender = addslashes($_POST['gender']);
if(isset($_POST['plural']))
	$plural = addslashes($_POST['plural']);
else
	$plural = '';
if(isset($_POST['pl_translation']))
	$pl_translation = addslashes($_POST['pl_translation']);
else
	$pl_translation = '';
if(isset($_POST['exception_id']))
	$exception_id = (int)$_POST['exception_id'];
else
	$exception_id = 0;
if($id == 0) {
	if($list = $conn->query('insert into word (word, translation, gender, plural, plural_translation, exception_id) values (lower("'.$word.'"), lower("'.$translation.'"), "'.$gender.'", lower("'.$plural.'"), lower("'.$pl_translation.'"), '. ($exception_id > 0 ? $exception_id : 'null') .')')) {
		$res['status'] = 'success';
		$res['msg'] = 'Слово успешно добавлено';
	}
	else
		$res['msg'] = $conn->error;
}
else {
	if($list = $conn->query('update word set word = lower("'.$word.'"), translation = lower("'.$translation.'"), gender = "'.$gender.'", plural = lower("'.$plural.'"), plural_translation = lower("'.$pl_translation.'"), exception_id = '.($exception_id > 0 ? $exception_id : 'null').' where id = '.$id)) {
		$res['status'] = 'success';
		$res['msg'] = 'Слово успешно обновлено';
	}
	else
		$res['msg'] = $conn->error;
}
echo json_encode($res);
?>