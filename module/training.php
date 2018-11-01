<?php
	require 'includes/connect.php';
	include 'menu.php'; ?>
<div class="container">
	<div class="row m-5" id = "training">
		<div class="training-container text-center col-12">
			<h5 class="word p-2"></h5>
			<div class="task"></div>
				<div class="progress m-2">
			 		<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
				</div>
			<div id="answer-area">
				<div class="alert alert-dismissible fade show" role="alert"></div>
				<button type="button" class="btn btn-lg btn-primary mb-2" id="answer">Ответить</button>
				<button type="button" class="btn btn-lg btn-danger mb-2" id="finish">Закончить</button>
			</div>
		</div>
	</div>	
</div>
