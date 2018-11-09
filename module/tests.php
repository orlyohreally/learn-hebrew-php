<?php
	require 'includes/connect.php';
	include 'menu.php'; ?>
<div class="container">
	<div class="row m-5" id = "training">
		<div class="training-container text-center col-12">
			<h5 class="sentence-template p-2"></h5>
			<textarea id="sentence" class="form-control"></textarea>
			<div id="answer-area" class="mt-2">
				<div class="alert alert-dismissible fade show" role="alert"></div>
				<button type="button" class="btn btn-lg btn-primary mb-2" id="answer">Ответить</button>
				<button type="button" class="btn btn-lg btn-danger mb-2" id="finish">Закончить</button>
			</div>
		</div>
	</div>	
</div>
