<?php
require '../includes/connect.php';
if(!isset($_POST['type'])){
	echo '{"status": "error", "msg": "Не указан тип задания"}';
	die();
}
$tasktype = addslashes($_POST['type']);
$word_count = isset($_POST['count']) ? (int)$_POST['count'] : 4;
$words = [];
$q = '';
$res = [];
$res['status'] = 'error';
if($list = $conn->query('select word, translation from word order by rand() limit '.$word_count)) {
	$i = random_int(1, $word_count);
	while($row = $list->fetch_assoc()) {
		if($word_count > 1) {
			$words[] = $tasktype == 'he-ru' ? $row['translation'] : $row['word'];
			if(sizeof($words) == $i)
				$q = $tasktype == 'he-ru' ? $row['word'] :$row['translation'];
		}
		else {
			$q = $tasktype == 'he-ru' ? $row['word'] :$row['translation'];
		}
	}
	$words[] = $q;
	$res['words'] = $words;
	$res['status'] = 'success';
}
echo json_encode($res);
?>