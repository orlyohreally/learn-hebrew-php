<?php
	require '../includes/connect.php';
	header("Content-Type: text/csv");
	header("Content-Disposition: attachment; filename=verbs.csv");

	function outputCSV($data) {
	  $output = fopen("php://output", "wb");
	  foreach ($data as $row)
	    fputcsv($output, $row); // here you can change delimiter/enclosure
	  fclose($output);
	}

	
	if($list = $conn->query('select f.id form_id, v.past_ms, f.name v_group, v.id, infinitive, ms, fs, mp, fp, translation, form from verb v, verb_form f where f.id = v.form_id order by form_id, ms, translation')) {
		$form_id = 0;
		while($row = $list->fetch_assoc()) {
			if ($form_id != $row['form_id']) {
				outputCSV(array(
				  	array(""),
			  		array("", $row['v_group'], ""),
			  		array("תרגום", "עבר", "שם הפועל", "הווה")
				));
				outputCSV(
				  array(array($row['translation'], $row['past_ms'], $row['ms']. ' | '.$row['fs'], $row['infinitive']))
				);
			}
			else {
				outputCSV(array(
				  array($row['translation'], $row['past_ms'], $row['ms']. ' | '.$row['fs'], $row['infinitive'])
				));
			}
			$form_id = $row['form_id'];
		}
	}
	
?>