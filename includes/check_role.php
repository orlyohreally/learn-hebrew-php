<?php
	session_start();
	require 'connect.php';
	$user_role = 'user';
	if(isset($_SESSION['user_id'])) {
		if($list = $conn->query('select name from role r, webuser u where u.role_id = r.id and u.id = '.$_SESSION['user_id'])) {
			if($row = $list->fetch_assoc()) {
				$user_role = $row['name'];
			}
		}
	}
?>