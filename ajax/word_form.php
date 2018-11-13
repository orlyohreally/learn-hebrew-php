<?php
	require '../includes/check_role.php';
	require '../includes/connect.php';

	$title = 'Просмотр слова';
	if(isset($_GET['id'])) {
		$id = (int)$_GET['id'];
	}
	else $id = 0;

	if($res = $conn->query('select w.*, topic_id, e.name exception, v.infinitive, v.ms, v.fs, v.mp, v.fp, v.form_id from word w left join pl_exception e on e.id = w.exception_id left join verb v on w.verb_id = v.id where w.id = '.$id)) {
		if($row = $res->fetch_assoc()) {
			$word = $row['word'];
			$translation = $row['translation'];
			$gender = $row['gender'];
			$plural = $row['plural'];
			$plural_translation = $row['plural_translation'];
			$exception_id = $row['exception_id'];
			$exception = $row['exception'];
			$part_of_speech = $row['part_of_speech'];
			$comment = $row['comment'];
			$ms = $row['ms'];
			$fs = $row['fs'];
			$fp = $row['fp'];
			$mp = $row['mp'];
			$form_id = $row['form_id'];
			$verb_id = $row['verb_id'];
			$infinitive = $row['infinitive'];
			$topic_id = $row['topic_id'];
		}
		else {
			$word = '';
			$translation = '';
			$gender = '';
			$plural = '';
			$plural_translation = '';
			$exception_id = '';
			$exception = '';
			$part_of_speech = '';
			$comment = '';
			$ms = '';
			$fs = '';
			$fp = '';
			$mp = '';
			$form_id = '';
			$verb_id = '';
			$infinitive = '';
			$topic_id = '';
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
							<input type="text" required value = "<?php echo $word?>" class="form-control" id="word_input" aria-describedby="Слово" placeholder="Слово">
						</div>
						<div class="row">
							<div class="form-group col-12 col-md-8">
								<label for="partofspeech_input">Часть речи</label>
								<select rows="2" id="partofspeech_input" aria-describedby="Часть речи" class="form-control">
									<option <?php if ($part_of_speech=='noun') echo 'selected'; ?> value="noun">Существительное</option>
									<option <?php if ($part_of_speech=='adj') echo 'selected'; ?> value="adj">Прилагательное</option>
									<option <?php if ($part_of_speech=='verb') echo 'selected'; ?> value="verb">Глагол</option>
									<option <?php if ($part_of_speech=='adverb') echo 'selected'; ?> value="adverb">Наречие</option>
									<option <?php if ($part_of_speech=='pronoun') echo 'selected'; ?> value="pronoun">Местоимение</option>
									<option <?php if ($part_of_speech=='conj') echo 'selected'; ?> value="conj">Союз</option>
									<option <?php if ($part_of_speech=='prep') echo 'selected'; ?> value="prep">Предлог</option>
									<option <?php if ($part_of_speech=='question') echo 'selected'; ?> value="question">Вопрос</option>
									<option <?php if ($part_of_speech=='phrase') echo 'selected'; ?> value="phrase">Фраза</option>
									<option <?php if ($part_of_speech=='number') echo 'selected'; ?> value="number">Числительное</option>
								</select>
							</div>
							<div class="form-group col-12 col-md-4">
								<label for="gender_input">Род</label>
								<select id="gender_input" aria-describedby="Род" class="form-control">
									<option <?php if ($gender=='f') echo 'selected'; ?> value="f">Ж</option>
									<option <?php if ($gender=='m') echo 'selected'; ?> value="m">М</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="translation_input">Перевод</label>
							<input type="text" required value = "<?php echo $translation;?>" class="form-control" id="translation_input" aria-describedby="Перевод" placeholder="Перевод">
						</div>
						<div class="row">
							<div class="form-group col-12 col-md-7">
								<label for="plural_input">Множественное число</label>
								<input type="text" value = "<?php echo $plural;?>" class="form-control" id="plural_input" aria-describedby="Множественное число" placeholder="Множественное число">
							</div>
							<div class="form-group col-12 col-md-5">
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
						</div>
						<div class="form-group">
							<label for="pl_translation_input">Перевод мн.ч.</label>
							<input type="text" value = "<?php echo $plural_translation;?>" class="form-control" id="pl_translation_input" aria-describedby="Перевод мн.ч." placeholder="Перевод мн.ч.">
						</div>
						<div class="form-group">
							<label for="infinitive_input">Инфинитив</label>
							<input type="text" value = "<?php echo $infinitive;?>" class="form-control" id="infinitive_input" aria-describedby="Инфинитив" placeholder="Инфинитив">
						</div>
						<div class="form-group">
							<label for="translation_input">Ед.ч. м.р.</label>
							<input type="text" value = "<?php echo $ms;?>" class="form-control" id="ms_input" aria-describedby="Ед.ч. м.р." placeholder="Ед.ч. м.р.">
						</div>
						<div class="form-group">
							<label for="translation_input">Ед.ч. ж.р.</label>
							<input type="text" value = "<?php echo $fs;?>" class="form-control" id="fs_input" aria-describedby="Ед.ч. ж.р." placeholder="Ед.ч. ж.р.">
						</div>
						<div class="form-group">
							<label for="translation_input">Мн.ч. м.р.</label>
							<input type="text" value = "<?php echo $mp;?>" class="form-control" id="mp_input" aria-describedby="Мн.ч. м.р." placeholder="Мн.ч. м.р.">
						</div>
						<div class="form-group">
							<label for="translation_input">Мн.ч. ж.р.</label>
							<input type="text" value = "<?php echo $fp;?>" class="form-control" id="fp_input" aria-describedby="Мн.ч. ж.р." placeholder="Мн.ч. ж.р.">
						</div>
						<div class="form-group">
							<label for="form_id_input">Форма</label>
							<select id="form_id_input" aria-describedby="Форма" class="form-control">
								<option value="">Нет</option>
							<?php
									if($res = $conn->query('select * from verb_form')) {
										while($row = $res->fetch_assoc()) {
											echo '<option ';
											if ($form_id==$row['id'])
												echo 'selected ';
											echo 'value="'.$row['id'].'">'.$row['form'].'</option>';
										}
									}
							?>
							</select>
						</div>
						<div class="form-group">
							<label for="topic_id_input">Тема</label>
							<select id="topic_id_input" aria-describedby="Тема" class="form-control">
								<option value="">Нет</option>
							<?php
									if($res = $conn->query('select id, name from topic')) {
										while($row = $res->fetch_assoc()) {
											echo '<option ';
											if ($topic_id==$row['id'])
												echo 'selected ';
											echo 'value="'.$row['id'].'">'.$row['name'].'</option>';
										}
									}
							?>
							</select>
						</div>
						<div class="form-group">
							<label for="comment_textarea">Примечание</label>
							<textarea class="form-control" id="comment_textarea" aria-describedby="Примечание" placeholder="Примечание"><?php echo $comment;?></textarea>
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
											<span><?php echo $word.($part_of_speech == 'noun' || $part_of_speech == 'number' ? ($gender!='' ? ($gender == 'm' ? ' (м.р.)' : ' (ж.р.)' ) : '') : '');?></span>
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
							<?php if($part_of_speech == 'noun') { ?>
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
							<?php } ?>
							<?php if($part_of_speech == 'verb') { ?>
							<li class="list-group-item">
								<div class="col-12">
									<div class="row">
										<div class="col-3">
											<strong>Инфинитив</strong>
										</div>
										<div class="col-9 text-right">
											<span><?php echo $infinitive;?></span>
										</div>
									</div
								</div>
							</li>
							<li class="list-group-item">
								<div class="col-12">
									<div class="row">
										<div class="col-3">
											<strong>Ед.ч. м.р.</strong>
										</div>
										<div class="col-9 text-right">
											<span><?php echo $ms;?></span>
										</div>
									</div
								</div>
							</li>
							<li class="list-group-item">
								<div class="col-12">
									<div class="row">
										<div class="col-3">
											<strong>Ед.ч. ж.р.</strong>
										</div>
										<div class="col-9 text-right">
											<span><?php echo $fs;?></span>
										</div>
									</div
								</div>
							</li>
							<li class="list-group-item">
								<div class="col-12">
									<div class="row">
										<div class="col-3">
											<strong>Мн.ч. м.р.</strong>
										</div>
										<div class="col-9 text-right">
											<span><?php echo $mp;?></span>
										</div>
									</div
								</div>
							</li>
							<li class="list-group-item">
								<div class="col-12">
									<div class="row">
										<div class="col-3">
											<strong>Мн.ч. ж.р.</strong>
										</div>
										<div class="col-9 text-right">
											<span><?php echo $fp;?></span>
										</div>
									</div
								</div>
							</li>
							<?php } ?>
						</ul>
					</div>
					
				<?php }?>
			</div>
		</div>
	</div>
</div>
<?php require '../js/word_form_scripts.php';?>
