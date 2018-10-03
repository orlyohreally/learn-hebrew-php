<?php
require 'includes/connect.php';
include 'menu.php';
?>
<div class="container">
	<div class="row">
		<div class="col-10 offset-1 mt-5 mb-5">
		<?php
			if(isset($_GET['id'])) {
				$id = (int)$_GET['id'];
			}
			else $id = 0;

			if($res = $conn->query('select * from word where id = '.$id)) {
				if($row = $res->fetch_assoc()) {
					$word = $row['word'];
					$translation = $row['translation'];
					$gender = $row['gender'];
					$plural = $row['plural'];
					$plural_translation = $row['plural_translation'];
					$exception_id = $row['exception_id'];
				}
				else {
					$word = '';
					$translation = '';
					$gender = '';
					$plural = '';
					$plural_translation = '';
					$exception_id = '';
				}
			}

			if ($id > 0)
					echo '<h1>Обновить слово</h1>';
			else
					echo '<h1>Добавить слово</h1>';
		?>
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
				<div class="form-group">
					<label for="password_input">Пароль</label>
					<input type="text" class="form-control" id="password_input" aria-describedby="Пароль" placeholder="Пароль">
				</div>
				<div class="text-center">
					<div class="alert alert-dismissible fade show" role="alert"></div>
					<?php
						if ($id > 0)
							echo '<button type="submit" class="btn btn-primary">Обновить</button>';
						else
							echo '<button type="submit" class="btn btn-primary">Добавить</button>';
					?>
				</div>
			</form>
		</div>
	</div>
</div>