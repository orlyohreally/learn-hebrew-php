<?php
require '../includes/connect.php';
if(!isset($_POST['password']) || !isset($_POST['word']) || !isset($_POST['translation']) || !isset($_POST['gender'])){
	echo '{"status": "error", "msg": "Не указаны необходимые значения"}';
	die();
}
if(!isset($_POST['password']) || $_POST['password'] != "it is orly") {
	echo '{"status": "error", "msg": "Неверный пароль"}';
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