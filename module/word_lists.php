<?php
	require 'includes/connect.php';
	include 'menu.php';
?>
<div id="page_content">
	<div class="container mb-5 mt-5" id="lists">
			<div class="row">
				<div class="col-12">
					<h1 class="text-center">Мои тесты</h1>
				</div>
			</div>
			<div class="row">
		
			<?php
					if($list = $conn->query('select count(*), l.name
											from webuser_list l, word_list wl
											where l.webuser_id = '.$_SESSION['user_id'].' and wl.webuser_list_id = l.id')) {
						$list_id = 0;
						while($row = $list->fetch_assoc()) {
							?>
							<div class="col-12 col-sm-6 mt-4 mb-2">
								<div class="card text-center">
									<h5 class="card-header p-3"><?php echo $row['name']; ?></h5>
									<div class="card-body p-2">
										<?php 
											echo '<p class="card-text p-3">'. $row['count(*)'].' сл. в тесте</p>';
										?>
										<a href="<?php echo $row['url']; ?>" class="btn btn-primary">Пройти</a>
									</div>
								</div>
							</div>
							<?php
						}
					}
				?>
			</div>
		</div>
	</div>

</div>
<div class="container">
	<div class="row" id = "training">
		<div class="training-container text-center col-12">
			<h5 class="word p-2"></h5>
			<div class="task"></div>
			<div id="answer-area">
				<div class="alert alert-dismissible fade show" role="alert"></div>
				<button type="button" class="btn btn-lg btn-primary mb-2" id="answer">Ответить</button>
				<button type="button" class="btn btn-lg btn-danger mb-2" id="finish">Закончить</button>
			</div>
		</div>
	</div>	
</div>
