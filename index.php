<?php
	require 'includes/connect.php';
	$par = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
	require 'includes/out.php';			
?>
<html>
    <head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <link href="../css/bootstrap-4.min.css" rel="stylesheet">
        <link href="../css/styles.css" rel="stylesheet">
		<?php if($out == 'words' || $out == 'verbs' || $out == 'nouns_exceptions')
				echo '<link href="../plugins/DataTables/datatables.min.css" rel="stylesheet">';
		?>
        <link rel="stylesheet" href="../font-awesome-4.7.0/css/font-awesome.min.css">
		<title>אני לומד עברית</title>
    </head>
    <body>
		<?php
			switch($out) {
				case 'main':
					include 'main.php';
					break;
				case 'words':
					include 'words.php';
					break;
				case 'word_form':
					include 'word_form.php';
					break;
				case 'verbs':
					include 'verbs.php';
					break;
				case 'nouns_exceptions':
					include 'nouns_exceptions.php';
					break;
				default:
					include '404.php';
			}
		?>
		
		
		<script src = "../js/jquery.min.js"></script>
        <script src = "../js/bootstrap-4.min.js"></script>
        <script src = "../js/utils.js"></script>
		
		<?php
			switch($out) {
				case 'main':
					require'js/scripts.php';
					break;
				case 'word_form':
					require 'js/word_form_scripts.php';
					break;
				case 'words':
					echo '<script type="text/javascript" src="../plugins/DataTables/datatables.min.js"></script>';
					require 'js/datatable_scripts.js';
					break;
				case 'verbs':
					echo '<script type="text/javascript" src="../plugins/DataTables/datatables.min.js"></script>';
					require 'js/datatable_scripts.js';
					break;
				case 'nouns_exceptions':
					echo '<script type="text/javascript" src="../plugins/DataTables/datatables.min.js"></script>';
					require 'js/datatable_scripts.js';
					break;
				default:
					include '404.php';
			}
		?>
    </body>
</html>