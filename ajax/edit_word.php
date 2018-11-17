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
if(!isset($_POST['word']) || !isset($_POST['translation']) || !isset($_POST['partofspeech'])  || (addslashes($_POST['partofspeech']) == 'verb' &&  (int)$_POST['form_id'] <= 0)) {
	echo '{"status": "error", "msg": "Не указаны необходимые значения"}';
	die();
}

$partofspeech = addslashes($_POST['partofspeech']);
$word = ($partofspeech != 'verb' ? addslashes($_POST['word']) : addslashes($_POST['ms']));
$translation = addslashes($_POST['translation']);

if(isset($_POST['id']) && (int)$_POST['id'] > 0) {//word is being updated
	$id = (int)$_POST['id'];
	if($list = $conn->query('select id, verb_id from word where id = '.$id)) {
		if($row = $list->fetch_assoc()) {
			$id = $row['id'];
			$verb_id = $row['verb_id'];
		}
	}
	else
		$res['msg'] = 'Такого слова не найдено';
}
else {//check if it's a new word
	if($list = $conn->query('select count(*) from word where word = "'.$word.'" and translation = "'.$translation.'"')) {
		if($row = $list->fetch_assoc()) {
			if($row['count(*)'] > 0) {
				echo '{"status": "error", "msg": "Это слово уже было добавлено"}';
				die();
			}
			else
				$id = 0;
		}
		
	}
}
$res = [];
$res['status'] = 'error';
$res['msg'] = 'При добавлении произошла ошибка';
			
if(isset($_POST['gender']))
	$gender = addslashes($_POST['gender']);
else
	$gender = '';
if($partofspeech == 'verb') {
	$gender = 'm';
}
if(isset($_POST['comment']))
	$comment = addslashes($_POST['comment']);
else
	$comment = '';
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
if(isset($_POST['topic_id']))
	$topic_id = (int)$_POST['topic_id'];
else
	$topic_id = 0;
if($partofspeech == 'verb') {//it's a verb
	if($id == 0 || !isset($verb_id)) {//new word or changed to verb
		$sql = 'insert into verb (ms, fs, mp, fp, past_ms, translation, form_id, infinitive) values ('.(isset($_POST['ms']) ? 'lower("'.addslashes($_POST['ms']).'")' : 'null').', '.(isset($_POST['fs']) ? 'lower("'.addslashes($_POST['fs']).'")' : 'null').', '.(isset($_POST['mp']) ? 'lower("'.addslashes($_POST['mp']).'")' : 'null').', '.(isset($_POST['fp']) ? 'lower("'.addslashes($_POST['fp']).'")' : 'null').', '.(isset($_POST['past_ms']) ? 'lower("'.addslashes($_POST['past_ms']).'")' : 'null').', "'.$translation.'", '.(isset($_POST['form_id']) ? (int)$_POST['form_id'] : 'null').', '.(isset($_POST['infinitive']) ? 'lower("'.addslashes($_POST['infinitive']).'")' : 'null').')';
		if($list = $conn->query($sql)) {
			$verb_id = $conn->insert_id;
		}
		else {
			$res['msg'] = $conn->error;
			echo $conn->error;
		}
	}
	else {
		$sql = 'update verb set ms = '.(isset($_POST['ms']) ? 'lower("'.addslashes($_POST['ms']).'")' : 'null').', fs = '.(isset($_POST['fs']) ? 'lower("'.addslashes($_POST['fs']).'")' : 'null').', mp = '.(isset($_POST['mp']) ? 'lower("'.addslashes($_POST['mp']).'")' : 'null').', fp = '.(isset($_POST['fp']) ? 'lower("'.addslashes($_POST['fp']).'")' : 'null').', past_ms = '.(isset($_POST['past_ms']) ? 'lower("'.addslashes($_POST['past_ms']).'")' : 'null').', translation = "'.$translation.'", form_id = '.(isset($_POST['form_id']) ? (int)$_POST['form_id'] : 'null').', infinitive = '.(isset($_POST['infinitive']) ? 'lower("'.addslashes($_POST['infinitive']).'")' : 'null').' where id = '.$verb_id;
		if($list = $conn->query($sql)) {
		}
		else {
			$res['msg'] = $conn->error;
		}
	}
}
if($id == 0) {
	if($list = $conn->query('insert into word (word, translation, gender, plural, plural_translation, exception_id, part_of_speech, comment, verb_id, topic_id) values (lower("'.$word.'"), lower("'.$translation.'"), "'.$gender.'", lower("'.$plural.'"), lower("'.$pl_translation.'"), '. ($exception_id > 0 ? $exception_id : 'null').', "'.$partofspeech.'"'.', "'.$comment.'", '.(isset($verb_id) ? $verb_id : 'null').', '.($topic_id > 0 ? $topic_id : 'null').')')) {
		$res['status'] = 'success';
		$res['msg'] = 'Слово успешно добавлено';
	}
	else
		$res['msg'] = $conn->error;
}
else {
	if($partofspeech == 'verb') {
		$verb_id_new = $verb_id;
	}
	if($list = $conn->query('update word set word = lower("'.$word.'"), translation = lower("'.$translation.'"), gender = "'.$gender.'", plural = lower("'.$plural.'"), verb_id='.(isset($verb_id_new) ? $verb_id_new : 'null').', comment = "'.$comment.'", part_of_speech = "'.$partofspeech.'", plural_translation = lower("'.$pl_translation.'"), exception_id = '.($exception_id > 0 ? $exception_id : 'null').', topic_id = '.($topic_id > 0 ? $topic_id : 'null').' where id = '.$id)) {
		if($partofspeech != 'verb' && isset($verb_id)) {//word was a verb and now it's not
			$sql = 'delete from verb where id = '.$verb_id;
			if($list = $conn->query($sql)) {
				$res['status'] = 'success';
				$res['msg'] = 'Слово успешно обновлено';
			}
			else {
				$res['msg'] = $conn->error;
			}			
		}
		else {
			$res['status'] = 'success';
			$res['msg'] = 'Слово успешно обновлено';
		}
		
	}
	else
		$res['msg'] = $conn->error;

}
echo json_encode($res);
?>