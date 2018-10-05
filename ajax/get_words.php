<?php
require '../includes/check_role.php';
require '../includes/connect.php';
if(!isset($_GET['task']) || !isset($_GET['lang']) || !isset($_GET['code'])){
	echo '{"status": "error", "msg": "Не указаны все обязательные данные"}';
	die();
}
$task = addslashes($_GET['task']);
$lang = addslashes($_GET['lang']);
$code = addslashes($_GET['code']);
$word_count = $task == 'multichoice' ? 4 : ($task == 'spelling' ? 1 : 0);
$words = [];
$q = [];
$res = [];
$res['status'] = 'error';
$res['words'] = $words;
if($list = $conn->query('select w.id, word, comment, translation from word w, training t where w.id = t.word_id and webuser_id='.(isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '1').' and code = "'.$code.'" and answered = false and tries < 3 order by rand() limit 1')) {
	if($row = $list->fetch_assoc()) {
		$q = $row;
		if($word_count > 1) {
			if($list = $conn->query('select id, word, comment, translation from word where id != '.$q['id'].' order by rand() limit '.($word_count - 1))) {
				$i = random_int(1, $word_count);
				while($row = $list->fetch_assoc()) {
					if(sizeof($words) + 1 == $i){
						$words[] = $lang == 'he-ru' ? $q['translation'] : $q['word'];
					}
					$words[] = $lang == 'he-ru' ? $row['translation'] : $row['word'];		
				}
				if(sizeof($words) + 1 == $i){
					$words[] = $lang == 'he-ru' ? $q['translation'] : $q['word'];
				}
				$words[] = $lang == 'he-ru' ? $q['word'] : $q['translation'];
				$res['words'] = $words;
				$res['status'] = 'success';
			}
		}
		else {
			$words[] = $lang == 'he-ru' ? $q['word'] : $q['translation'];
			$res['words'] = $words;
			$res['status'] = 'success';
		}
	}
	else {
		if($list = $conn->query('select w.id, word, comment, translation, tries, answered from word w, training t where w.id = t.word_id and webuser_id='.(isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '1').' and code = "'.$code.'" order by answered, tries')) {
			while($row = $list->fetch_assoc()) {
				$results[] = $row;
			}
			$res['results'] = $results;
			$res['status'] = 'success';
		}
	}
}
echo json_encode($res);
?>