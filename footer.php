		</div><!--.page-content-->
		<footer class="footer text-center">
		  <div class="container">
			<span class="copyright">Copyright &copy; 2018 <a href="https://orlyknop.herokuapp.com/">orlyohreally</a></span>
		  </div>
		</footer>
		<script src = "/js/jquery.min.js"></script>
        <script src = "/js/bootstrap-4.min.js"></script>
        <script src = "/js/bootbox.min.js"></script>
        <script src = "/js/utils.js"></script>

		<?php
			switch($out) {
				case 'main':
					require'js/scripts.php';
					break;
				case 'login':
					require 'js/login_scripts.php';
					break;
				case 'words':
					echo '<script type="text/javascript" src="../plugins/DataTables/datatables.min.js"></script>';
					require 'js/words_scripts.php';
					require 'js/datatable_scripts.js';
					break;
				case 'word_lists':
					require 'js/word_lists.php';
					break;
				case 'training':
					require 'js/training.php';
					echo '<script src="https://unpkg.com/web-animations-js@2.3.1/web-animations.min.js"></script>';
					echo '<script src="https://unpkg.com/hammerjs@2.0.8/hammer.min.js"></script>';
					echo '<script src="plugins/muuri/muuri.js"></script>';
					break;
				case 'tests':
					require 'js/tests_scripts.php';
					break;
				case 'word_list_details':
					require 'js/word_list_details.php';
					break;
				case 'verbs':
					echo '<script type="text/javascript" src="../plugins/DataTables/datatables.min.js"></script>';
					require 'js/datatable_scripts.js';
					break;
				case 'nouns_exceptions':
					echo '<script type="text/javascript" src="../plugins/DataTables/datatables.min.js"></script>';
					require 'js/datatable_scripts.js';
					break;
				case 'rule_article':
					echo '<script type="text/javascript" src="../plugins/markitup/jquery.markitup.js"></script>';
					echo '<script type="text/javascript" src="../plugins/markitup/sets/default/set.js"></script>';
					require 'js/rule_article_scripts.php';
					break;
			}
		?>
    </body>
</html>