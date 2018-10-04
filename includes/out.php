<?php
	switch($par[1]) {
		case '':
			$out = 'main';
			break;
		case 'login':
			$out = 'login';
			break;
		case 'logout':
			$out = 'logout';
			break;
		case 'words':
			$out = 'words';
			break;
		case 'verbs':
			$out = 'verbs';
			break;
		case 'word-form':
			$out = 'word_form';
			break;
		case 'nouns-exceptions':
			$out = 'nouns_exceptions';
			break;
		case 'my-lists':
			$out = 'word_lists';
			break;
		case 'my-list':
			$out = 'word_list_details';
			break;
		default:
			$out = '';
	}
?>