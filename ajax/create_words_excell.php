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
$words = " '" . implode("' , '", $words) . "' ";

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$row_counter = 0;
$part_of_speech = '';
$res['sql'] = 'select w.word word,w.plural, w.translation, w.verb_id verb_id, w.part_of_speech, v.ms, v.fs, v.mp, v.fp, v.infinitive from word w left join verb v on v.id = w.verb_id where w.id in ('.$words.') order by w.part_of_speech, w.id';

//foreach($words as $item=>$value) {
	if($list = $conn->query('select w.word word,w.plural plural, w.translation translation, w.part_of_speech part_of_speech, v.ms ms, v.fs fs, v.mp mp, v.fp fp, v.infinitive infinitive from word w left join verb v on v.id = w.verb_id where w.id in ('.$words.') order by w.part_of_speech, w.id')) {
		while($row = $list->fetch_assoc()) {
			$row_counter = $row_counter + 1;
			$pos_name = '';
			if ($row['part_of_speech']=='noun')
				$pos_name = 'Существительное';
			if ($row['part_of_speech']=='adj')
				$pos_name = 'Прилагательное';
			if ($row['part_of_speech']=='verb')
				$pos_name = 'Глагол';
			if ($row['part_of_speech']=='adverb')
				$pos_name = 'Наречие';
			if ($row['part_of_speech']=='pronoun')
				$pos_name = 'Местоимение';
			if ($row['part_of_speech']=='conj')
				$pos_name = 'Союз';
			if ($row['part_of_speech']=='prep')
				$pos_name = 'Предлог';
			if ($row['part_of_speech']=='question')
				$pos_name = 'Вопрос';
			if ($row['part_of_speech']=='phrase')
				$pos_name = 'Фраза';
			if ($row['part_of_speech']=='number')
				$pos_name = 'Числительное';
			if($part_of_speech != $row['part_of_speech']) {
				$sheet->setCellValue('A'.$row_counter, $pos_name);
				$part_of_speech = $row['part_of_speech'];

				$sheet->getStyle('A'.$row_counter)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->getStyle('A'.$row_counter)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
				$sheet->getStyle('A'.$row_counter)->getFill()->getStartColor()->setARGB('2980b9');
				$sheet->mergeCells('A'.$row_counter.':B'.$row_counter);
				$row_counter = $row_counter + 1;
			}

			if($row['part_of_speech'] != 'verb') {
				$sheet->setCellValue('A'.$row_counter, $row['word'].($row['plural'] != '' ? ' - '.$row['plural'] : ''));	
				$sheet->setCellValue('B'.$row_counter, $row['translation']);	
			}
			else {
				$sheet->setCellValue('A'.$row_counter, $row['infinitive'].' - '.$row['ms'].' - '.$row['fs']);
				$sheet->setCellValue('B'.$row_counter, $row['translation']);	
			}
			
		}
	}
//}
$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->getColumnDimension('B')->setAutoSize(true);
$code = addslashes(randomString(5));
$file = '../download/words-'.$code.'.xlsx';
$res['code'] = $code;
$writer = new Xlsx($spreadsheet);
$writer->save($file);
$res['status'] = 'success';
echo json_encode($res);
?>