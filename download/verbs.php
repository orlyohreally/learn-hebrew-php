<?php
require '../vendor/autoload.php';
require '../includes/connect.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/*$cache_life = 120;
$file = 'verbs.xlsx';
if(!file_exists($file) || (time() - filemtime($file) > $cache_life)) {
	$diff = time() - filemtime($file);*/
	$spreadsheet = new Spreadsheet();
	$sheet = $spreadsheet->getActiveSheet();

	if($list = $conn->query('select f.id form_id, v.past_ms, f.name v_group, v.id, infinitive, ms, fs, mp, fp, translation, form from verb v, verb_form f where f.id = v.form_id order by form_id, ms, translation')) {
		$form_id = 0;
		$row_counter = 0;

		while($row = $list->fetch_assoc()) {
			if ($form_id != $row['form_id']) {
				$row_counter = $row_counter + 1;
				$sheet->setCellValue('A'.$row_counter, $row['v_group']);
				$sheet->getStyle('A'.$row_counter)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				//$sheet->getStyle('B'.$row_counter)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
				$sheet->getStyle('A'.$row_counter)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
				$sheet->getStyle('A'.$row_counter)->getFill()->getStartColor()->setARGB('2980b9');
				$sheet->mergeCells('A'.$row_counter.':D'.$row_counter);
				$row_counter = $row_counter + 1;
				$sheet->setCellValue('A'.$row_counter, "תרגום");
				$sheet->setCellValue('B'.$row_counter, "עבר");
				$sheet->setCellValue('C'.$row_counter, "הווה");
				$sheet->setCellValue('D'.$row_counter, "שם הפועל");
				$sheet->getStyle('A'.$row_counter.':D'.$row_counter)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
				$sheet->getStyle('A'.$row_counter.':D'.$row_counter)->getFill()->getStartColor()->setARGB('6ab0de');
				$row_counter = $row_counter + 1;
				$sheet->setCellValue('A'.$row_counter, $row['translation']);
				$sheet->setCellValue('B'.$row_counter, $row['past_ms']);
				$sheet->setCellValue('C'.$row_counter, $row['ms']. ' | '.$row['fs']);
				$sheet->setCellValue('D'.$row_counter, $row['infinitive']);
				
			}
			else {
				$row_counter = $row_counter + 1;
				$sheet->setCellValue('A'.$row_counter, $row['translation']);
				$sheet->getStyle('A'.$row_counter)->getAlignment()->setWrapText(false);
				$sheet->setCellValue('B'.$row_counter, $row['past_ms']);
				$sheet->setCellValue('C'.$row_counter, $row['ms']. ' | '.$row['fs']);
				$sheet->setCellValue('D'.$row_counter, $row['infinitive']);
			}
			$form_id = $row['form_id'];
		}
	}
	/*date_default_timezone_set('Asia/Jerusalem');
	$sheet->setCellValue('A1', $diff.' Файл был обновлен: '.date("F d Y H:i:s.", time()));*/
	$sheet->getColumnDimension('A')->setAutoSize(true);
	$writer = new Xlsx($spreadsheet);
	$writer->save('verbs.xlsx');
//}

header("Location: verbs.xlsx");

?>