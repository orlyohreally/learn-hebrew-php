<?php
	require 'includes/connect.php';
	include 'menu.php';
?>
<div id="page_content">
	<div class="container mb-5 mt-5" id="lists">
			<div class="row">
				<div class="col-12">
					<h1 class="text-center">Мои списки</h1>
				</div>
				<div class="col-12 text-right">
					<button type="button" id="create_list" class="btn btn-primary">Создать новый список</button>
				</div>
			</div>
			
			<div class="row">
			<?php
					if($list = $conn->query('select l.id, l.name, count(wl.id) from webuser_list l left join word_list wl on wl.webuser_list_id = l.id
											where l.webuser_id = '.$_SESSION['user_id'].' group by l.id')) {
						$list_id = 0;
						while($row = $list->fetch_assoc()) {
							?>
							<div class="col-12 col-sm-6 mt-4 mb-2">
								<div class="card text-center">
									<h5 class="card-header p-3"><?php echo $row['name']; ?></h5>
									<div class="card-body p-2">
										<?php 
											echo '<p class="card-text p-3">'. $row['count(wl.id)'].' сл. в тесте</p>';
										?>
										<a href="/my-list/<?php echo $row['name']; ?>" class="btn btn-primary">Перейти / Редактировать</a>
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