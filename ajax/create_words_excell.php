<?php
require '../vendor/autoload.php';
require '../includes/connect.php';
require '../includes/utils.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$res = [];
$res['status'] = 'error';
$res['msg'] = 'Ощибка!';

if(!isset($_POST['words'])) {
	$res['msg'] = 'Слова не выбраны';
	echo json_encode($res);
	die();
}
$words = json_decode($_POST['words']);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$row_counter = 0;
foreach($words as $item=>$value) {
	if($list = $conn->query('select w.word word from word w where w.id = '.(int)$value)) {
		if($row = $list->fetch_assoc()) {
			$row_counter = $row_counter + 1;
			$sheet->setCellValue('A'.$row_counter, $row['word']);
		}
	}
}
$sheet->getColumnDimension('A')->setAutoSize(true);
$code = addslashes(randomString(5));
$file = '../download/words-'.$code.'.xlsx';
$res['code'] = $code;
$writer = new Xlsx($spreadsheet);
$writer->save($file);
$res['status'] = 'success';
echo json_encode($res);
?>