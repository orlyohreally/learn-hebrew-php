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
$all_words = $_GET['all_words'] == 'true' ? true : false;
$words = [];
$q = [];
$res = [];
$res['status'] = 'error';
$res['words'] = $words;


if($list = $conn->query('select * from (SELECT count(*) answered FROM training where webuser_id='.(isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '2').' and code = "'.$code.'" and (answered = 1 or tries >= 3)) t join (SELECT count(*) total FROM training where webuser_id='.(isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '2').' and code = "'.$code.'") t1')) {
		if($row = $list->fetch_assoc()) {
			$res['total'] = $row['total'];
			if($word_count > $row['total'] && !$all_words)
				$word_count = $row['total'];
			$res['answered'] = $row['answered'];
	}
}
if($task == 'multichoice' || $task == 'spelling') {
	if($list = $conn->query('select w.id, word, comment, translation from word w, training t where w.id = t.word_id and webuser_id='.(isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '2').' and code = "'.$code.'" and answered = false and tries < 3 order by rand() limit 1')) {
		if($row = $list->fetch_assoc()) {
			$q = $row;
			if($word_count > 1) {
				$sql = $all_words ? 'select id, word, comment, translation from word where id != '.$q['id'].' order by rand() limit '.($word_count - 1) : 'select w.id, word, comment, translation from word w, training t where w.id = t.word_id and webuser_id='.(isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '2').' and w.id != '.$q['id'].' and code = "'.$code.'" order by rand() limit '.($word_count - 1);
				if($list = $conn->query($sql)) {
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
			if($list = $conn->query('select w.id, word, comment, translation answer, tries, answered from word w, training t where w.id = t.word_id and webuser_id='.(isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '2').' and code = "'.$code.'" order by answered, tries')) {
				$results = [];
				while($row = $list->fetch_assoc()) {
					$results[] = $row;
				}
				$res['results'] = $results;
				$res['status'] = 'success';
			}
		}
	}
}
else if($task == "plural"){//plural
	if($list = $conn->query('select w.id, word, plural answer, comment from word w, training t where w.id = t.word_id and webuser_id='.(isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '2').' and part_of_speech = "noun" and plural is not null and plural != "" and code = "'.$code.'" and answered = false and tries < 3 order by rand() limit 1')) {
		if($row = $list->fetch_assoc()) {
			$words[] = $row['word'];
			$res['words'] = $words;
			$res['status'] = 'success';
		}
		else {
			if($list = $conn->query('select w.id, word, comment, translation, tries, answered from word w, training t where w.id = t.word_id and part_of_speech = "noun" and plural is not null and plural != "" and webuser_id='.(isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '2').' and code = "'.$code.'" order by answered, tries')) {
				$results = [];
				while($row = $list->fetch_assoc()) {
					$results[] = $row;
				}
				$res['results'] = $results;
				$res['status'] = 'success';
			}
		}
	}
}
else if($task == "infinitive") {
	if($list = $conn->query('select w.id, v.ms, v.fs, v.mp, v.fp from word w, training t, verb v where w.id = t.word_id and v.id = w.verb_id and webuser_id='.(isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '2').' and part_of_speech = "verb" and v.infinitive is not null and v.infinitive != "" and code = "'.$code.'" and answered = false and tries < 3 order by rand() limit 1')) {
		if($row = $list->fetch_assoc()) {
			$form_i = random_int(0, 3);
			$words[] = $row[array('ms', 'fs', 'mp', 'fp')[$form_i]];
			$res['words'] = $words;
			$res['status'] = 'success';
		}
		else {
			if($list = $conn->query('select v.ms word, concat_ws(" ", v.infinitive, w.translation) as answer, tries, answered from word w, training t, verb v where w.id = t.word_id and part_of_speech = "verb" and w.verb_id = v.id and v.infinitive is not null and v.infinitive != "" and webuser_id='.(isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '2').' and code = "'.$code.'" order by answered, tries')) {
				$results = [];
				while($row = $list->fetch_assoc()) {
					$results[] = $row;
				}
				$res['results'] = $results;
				$res['status'] = 'success';
			}
		}
	}
}
echo json_encode($res);
?>