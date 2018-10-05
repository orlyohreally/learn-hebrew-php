<?php
	function randomString($n) {
		$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz";
		$res = '';
		for($i = 0; $i < $n; $i++) {
			$res .= $chars[rand(0, strlen($chars) - 1)];
		}
		return $res;
	}
?>