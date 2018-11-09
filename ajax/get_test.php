<?php
require '../includes/check_role.php';
require '../includes/connect.php';
if(!isset($_GET['test'])){
	echo '{"status": "error", "msg": "Не указаны все обязательные данные"}';
	die();
}
$test = addslashes($_GET['test']);
$res = [];
$res['status'] = 'error';
if($test == 'sv') {
	if($list = $conn->query('select * from sentence_subjects s, verb v order by rand() limit 1')) {
			if($row = $list->fetch_assoc()) {
				$res['template'] = '('.$row['subject'].' ('.$row['infinitive'];
				$res['status'] = 'success';
		}
	}
}
echo json_encode($res);
?>