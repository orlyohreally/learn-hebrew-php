<?php
//readfile($_POST['file']);
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=words.xlsx");
header("Pragma: no-cache");
header("Expires: 0");
readfile('words-'.$_GET['code'].'.xlsx');
unlink('words-'.$_GET['code'].'.xlsx');
?>