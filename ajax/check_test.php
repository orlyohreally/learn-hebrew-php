<?php
require '../includes/check_role.php';
require '../includes/connect.php';
if(!isset($_POST['answer']) || !isset($_POST['test'])){
	echo '{"status": "error", "msg": "Не указаны все обязательные данные"}';
	die();
}
$test = addslashes($_POST['test']);
$sentence_template = addslashes($_POST['sentence_template']);
$res = [];
$res['status'] = 'error';
if($test == 'sv') {
	if(count(explode(' ', addslashes($_POST['answer']))) != 2){
		$res['status'] = 'success';
		$res['result'] = 'wrong';
	}
	else {
		$subject = explode(' ', addslashes($_POST['answer']))[0];
		$verb = explode(' ', addslashes($_POST['answer']))[1];
		if($list = $conn->query('select gender from sentence_subjects s where s.subject = "'.$subject.'"')) {
			if($row = $list->fetch_assoc()) {
				$gender = $row['gender'];
				if($list = $conn->query('select infinitive from verb s where s.'.$gender.' = "'.$verb.'"')) {
					if($row = $list->fetch_assoc()) {
						$res['result'] = 'correct';
						$res['status'] = 'success';
					}
					else {
						$res['result'] = 'wrong';
						$res['status'] = 'success';	
					}
				}
			}
		}
	}
}
echo json_encode($res);
?>