<?php
	require '../includes/check_role.php';
	require '../includes/connect.php';

	$title = 'Просмотр слова';
	if(isset($_GET['id'])) {
		$id = (int)$_GET['id'];
	}
	else $id = 0;

	if($res = $conn->query('select w.*, e.name exception from word w left join pl_exception e on e.id = w.exception_id where w.id = '.$id)) {
		if($row = $res->fetch_assoc()) {
			$word = $row['word'];
			$translation = $row['translation'];
			$gender = $row['gender'];
			$plural = $row['plural'];
			$plural_translation = $row['plural_translation'];
			$exception_id = $row['exception_id'];
			$exception = $row['exception'];
		}
		else {
			$word = '';
			$translation = '';
			$gender = '';
			$plural = '';
			$plural_translation = '';
			$exception_id = '';
			$exception = '';
		}
	}

	if($user_role == 'admin') {
		if ($id > 0)
				$title = 'Обновить слово';
		else
				$title = 'Добавить слово';
	}
?>
		
	<div class="modal-header">
		<h5 class="modal-title" id="exampleModalLabel"><?php echo $title;?></h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	</div>
	<div class="modal-body">

		<div id="main-content" class="container">
			<div class="row">
				<div class="col-12">
				<?php if($user_role == 'admin') {?>
					<form id="word_form">
						<div class="form-group">
							<label for="word_input">Слово</label>
							<input type="text" value = '<?php echo $word?>' class="form-control" id="word_input" aria-describedby="Слово" placeholder="Слово">
						</div>
						<div class="form-group">
							<label for="translation_input">Перевод</label>
							<input type="text" value = '<?php echo $translation;?>' class="form-control" id="translation_input" aria-describedby="Перевод" placeholder="Перевод">
						</div>
						<div class="form-group">
							<label for="gender_input">Род</label>
							<select rows="2" id="gender_input" aria-describedby="Род" class="form-control">
								<option <?php if ($gender=='f') echo 'selected'; ?> value="f">Женский род</option>
								<option <?php if ($gender=='m') echo 'selected'; ?> value="m">Мужской род</option>
							</select>
						</div>
						<div class="form-group">
							<label for="plural_input">Множественное число</label>
							<input type="text" value = '<?php echo $plural;?>' class="form-control" id="plural_input" aria-describedby="Множественное число" placeholder="Множественное число">
						</div>
						<div class="form-group">
							<label for="exception_id_input">Исключение</label>
							<select id="exception_id_input" aria-describedby="Исключение" class="form-control">
								<option value="">Не исключение</option>
							<?php
									if($res = $conn->query('select * from pl_exception')) {
										while($row = $res->fetch_assoc()) {
											echo '<option ';
											if ($exception_id==$row['id'])
												echo 'selected ';
											echo 'value="'.$row['id'].'">'.$row['name'].'</option>';
										}
									}
							?>
							</select>
						</div>
						<div class="form-group">
							<label for="pl_translation_input">Перевод мн.ч.</label>
							<input type="text" value = '<?php echo $plural_translation;?>' class="form-control" id="pl_translation_input" aria-describedby="Перевод мн.ч." placeholder="Перевод мн.ч.">
						</div>
						<div class="text-center">
							<div class="alert alert-dismissible fade show" role="alert"></div>
							<?php
								if($user_role == 'admin') {?>
									<div class="modal-footer">
										<button type="submit" class="btn btn-primary"><?php echo $id > 0 ? 'Обновить' : 'Добавить';?></button>
									</div>
								<?php }
							?>
						</div>
					</form>
				<?php }
				else {?>
					
					<div class="card">
						<ul class="list-group list-group-flush">
							<li class="list-group-item">
								<div class="col-12">
									<div class="row">
										<div class="col-3">
											<strong>Слово:</strong>
										</div>
										<div class="col-9 text-right">
											<span><?php echo $word.($gender!='' ? ($gender == 'm' ? ' (м.р.)' : ' (ж.р.)' ) : '');?></span>
										</div>
									</div
								</div>
							</li>
							<li class="list-group-item">
								<div class="col-12">
									<div class="row">
										<div class="col-3">
											<strong>Перевод:</strong>
										</div>
										<div class="col-9 text-right">
											<span><?php echo $translation;?></span>
										</div>
									</div
								</div>
							</li>
							<li class="list-group-item">
								<div class="col-12">
									<div class="row">
										<div class="col-3">
											<strong>Множественное число:</strong>
										</div>
										<div class="col-9 text-right">
											<span><?php echo $plural;?></span>
										</div>
									</div
								</div>
							</li>
							<li class="list-group-item">
								<div class="col-12">
									<div class="row">
										<div class="col-3">
											<strong>Исключение:</strong>
										</div>
										<div class="col-9 text-right">
											<span><?php echo $exception != '' ? $exception : '-';?></span>
										</div>
									</div
								</div>
							</li>
							
						</ul>
					</div>
					
				<?php }?>
			</div>
		</div>
	</div>
</div>
<?php require '../js/word_form_scripts.php';?>
