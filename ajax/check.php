<?php
require '../includes/check_role.php';
require '../includes/connect.php';

if(!isset($_POST['lang']) || !isset($_POST['task']) || !isset($_POST['code'])){
	echo '{"status": "error", "msg": "Не указаны обязательные данные"}';
	die();
}
if(!isset($_POST['word']) || !isset($_POST['answer'])){
	echo '{"status": "error", "msg": "Не указан слово или ответ"}';
	die();
}

$lang = addslashes($_POST['lang']);
$code = $_POST['code'];
$word = addslashes($_POST['word']);
$task = addslashes($_POST['task']);
$answer = addslashes($_POST['answer']);
$res = [];
$res['status'] = 'error';
$res['result'] = false;
if($lang == 'he-ru' && ($task == 'spelling' || $task == 'multichoice'))
	$sql = 'select word, translation from word where word = lower("'.$word.'")';
else if($lang == 'ru-he' && ($task == 'spelling' || $task == 'multichoice'))
	$sql = 'select word, translation from word where translation = lower("'.$word.'")';
else if($lang == 'he-he' && $task == 'plural')
	$sql = 'select word, plural from word where word = lower("'.$word.'")';
else if($lang == 'he-he' && $task == 'infinitive')
	$sql = 'select ms, infinitive from verb where ms = "'.$word.'" or fs = "'.$word.'" or mp = "'.$word.'" or fp = "'.$word.'"';
if($list = $conn->query($sql)) {
	$is_correct = false;
	$asked_word = '';
	while($row = $list->fetch_assoc()) {
		$asked_word = (isset($row['word']) ? $row['word'] : $row['ms']);
		if($lang == 'he-ru' && ($task == 'spelling' || $task == 'multichoice')) {
			$answered = $row['translation'] == mb_strtolower($answer);
			$res['correct'] = $row['translation'];
			if($answered) {
				$res['result'] = 'correct';
				$is_correct = true;
				break;
			}
		}
		else if($lang == 'ru-he' && ($task == 'spelling' || $task == 'multichoice')){
			$answered = addslashes($row['word']) == $answer;
			$res['correct'] = $row['word'];
			if($answered) {
				$res['result'] = 'correct';
				$is_correct = true;
				break;
			}
		}
		else if($task == 'plural') {//plural
			$answered = addslashes($row['plural']) == $answer;
			$res['correct'] = $row['plural'];
			if($answered) {
				$res['result'] = 'correct';
				$is_correct = true;
				break;
			}
		}
		else if($task == 'infinitive') {
			$answered = addslashes($row['infinitive']) == $answer;
			$res['correct'] = $row['infinitive'];
			if($answered) {
				$res['result'] = 'correct';
				$is_correct = true;
				break;
			}	
		}
	}
	$sql = 'update training t join word w on w.id = t.word_id set answered = '.(int)$is_correct.', tries = tries + 1 where webuser_id = '.(isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '2').' and code = '.$code.' and word = "'.$asked_word.'"';

	if($list = $conn->query($sql)) {
		$res['status'] = 'success';
	}
	else {
		$res['status'] = 'error';
		$res['msg'] = $conn->error;
	}

}
echo json_encode($res);
?>