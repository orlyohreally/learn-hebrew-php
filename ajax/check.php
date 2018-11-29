<?php
require '../includes/check_role.php';
require '../includes/connect.php';

if(!isset($_POST['lang']) || !isset($_POST['task']) || !isset($_POST['code'])){
	echo '{"status": "error", "msg": "Не указаны обязательные данные"}';
	die();
}
if($_POST['task'] != 'prepositions' && (!isset($_POST['word']) || !isset($_POST['answer']))){
	echo '{"status": "error", "msg": "Не указан слово или ответ"}';
	die();
}

$lang = addslashes($_POST['lang']);
$code = $_POST['code'];
$task = addslashes($_POST['task']);
$res = [];
$res['status'] = 'error';
$res['result'] = false;

if($task == 'prepositions') {
	$verbs = json_decode($_POST['words']);
	$prepositions = json_decode($_POST['prepositions']);
	$correct = 0;
	foreach($verbs as $item=>$value) {
		$sql = 'select * from verb_preposition where verb_id = "'.$value.'" and preposition_id = "'.$prepositions[$item].'"';
		if($list = $conn->query($sql)) {
			if(mysqli_num_rows($list) >= 1) {
				$correct = $correct + 1;
			}
		}
	}
	$res['correct'] = $correct;
	$res['total'] = count($verbs);

	if($correct == $res['total']) {
		foreach($verbs as $item=>$value) {
			$sql = 'update verb v join word w on w.verb_id = v.id join training t on t.word_id = w.id set answered = 1, tries = tries + 1 where webuser_id = '.(isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '2').' and code = '.$code.' and v.id = "'.$value.'"';
			if($list = $conn->query($sql)) {
				$res['status'] = 'success';
			}
			else {
				$res['status'] = 'error';
				$res['msg'] = $conn->error;
				echo json_encode($res);
				die();
			}
		}
	}
	$res['result'] = $correct == $res['total'] ? 'correct' : 'wrong';
	$res['status']= 'success';
}
else {
	$word = addslashes($_POST['word']);
	$answer = addslashes($_POST['answer']);

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
}
echo json_encode($res);
?>