<html>
    <head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <link href="../css/bootstrap-4.min.css" rel="stylesheet">
        <link href="../css/styles.css" rel="stylesheet">
		<?php
			if($out == 'words' || $out == 'verbs' || $out == 'nouns_exceptions')
				echo '<link href="../plugins/DataTables/datatables.min.css" rel="stylesheet">';
			if($out == 'rule_article') {
				echo '<link rel="stylesheet" type="text/css" href="../plugins/markitup/skins/simple/style.css">';
				echo '<link rel="stylesheet" type="text/css" href="../plugins/markitup/sets/default/style.css">';
			}
		?>
        <!--<link rel="stylesheet" href="../font-awesome-4.7.0/css/font-awesome.min.css">-->
		<link rel="stylesheet" href="/plugins/fontawesome-free-5.3.1-web/css/all.min.css">
		<title>אני לומד עברית</title>
		<div class="page-content">
    </head>
    <body>