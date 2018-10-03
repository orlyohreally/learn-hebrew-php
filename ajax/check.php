<?php
require '../includes/connect.php';
if(!isset($_POST['type'])){
	echo '{"status": "error", "msg": "Не указан тип задания"}';
	die();
}
if(!isset($_POST['word']) || !isset($_POST['answer'])){
	echo '{"status": "error", "msg": "Не указан слово или ответ"}';
	die();
}

$tasktype = addslashes($_POST['type']);
$word = addslashes($_POST['word']);
$answer = addslashes($_POST['answer']);
$res = [];
$res['status'] = 'error';
		
if($tasktype == 'he-ru')
	$sql = 'select word, translation from word where word = lower("'.$word.'")';
else
	$sql = 'select word, translation from word where translation = lower("'.$word.'")';

if($list = $conn->query($sql)) {
	if($row = $list->fetch_assoc()) {
		$res['status'] = 'success';
		if($tasktype == 'he-ru') {
			if ($row['translation'] == mb_strtolower($answer)) {
				$res['result'] = 'correct';
			}
			else {
				$res['result'] = 'wrong';
			}
			$res['correct'] = $row['translation'];
		}
		else {
			if ($row['word'] == mb_strtolower($answer)) {
				$res['result'] = 'correct';
			}
			else {
				$res['result'] = 'wrong';
			}
			$res['correct'] = $row['word'];
		}
	}
}
echo json_encode($res);
?>