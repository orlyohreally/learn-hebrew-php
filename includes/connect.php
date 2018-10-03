<?
    $dbhost = 'localhost';
    $dbuser = 'hebrew';
    $dbpass = 'hebrew';
    $db = 'hebrew';
    $conn = new mysqli($dbhost, $dbuser, $dbpass, $db) or die('Failed to connect '.$conn->error);
	$conn->set_charset("utf8");
?>