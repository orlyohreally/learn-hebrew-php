<?php
	require 'includes/connect.php';
	include 'menu.php';
?>
<div class="container mt-5 mb-5">
	<h1>Слова | מילים</h1>
	<?php
		$partofspeech = isset($_GET['part_of_speech']) ? addslashes($_GET['part_of_speech']) : '';
		$topic = isset($_GET['topic']) ? addslashes($_GET['topic']) : '';
	?>
	<div class="row">
		<div class="col-12 col-md-3 mt-2 mb-2">
			<select class="form-control" id="part_of_speech_select">
				<option <?php if($partofspeech == '') echo 'selected';?> value="">Все слова | כל המילים</option>
				<option <?php if($partofspeech == 'noun') echo 'selected';?> value="noun">Сущ. | שם עצם</option>
				<option <?php if($partofspeech == 'verb') echo 'selected';?> value="verb">Глаг. | פועל</option>
				<option <?php if($partofspeech == 'adj') echo 'selected';?> value="adj">Прил. | שם תואר</option>
				<option <?php if($partofspeech == 'number') echo 'selected';?> value="number">Числ. | מספר</option>
			</select>
		</div>
		<div class="col-12 col-md-3 mt-2 mb-2">
			<select class="form-control" id = "topic_select">
				<option  <?php if($topic == '') echo 'selected';?> value="">Любая тема | כל הנושאים</option>
				<?php
					if($list = $conn->query('select name, slug from topic order by name, slug')) {
						while($row = $list->fetch_assoc()) {
							?>
							<option <?php if($topic == $row['slug']) echo 'selected';?> value="<?php echo $row['slug'];?>"><?php echo $row['name'];?></option>
							<?php
						}
					}
				?>
			</select>
		</div>
		
		<?php
			if($user_role == 'admin') {?>
				<div class="col-md-6 col-12 text-right mt-2 mb-2">
					<button type="button" id="create_word" class="btn btn-primary">Добавить новое слово<hr>הוסף מילה חדשה</button>
				</div>
			<?php }
		?>
		<div class="col-12 mt-4 mb-2">
			<table id="list" class="table table-striped table-bordered display nowrap" style="width:100%">
				<thead>
					<tr>
						<th>№</th>
						<th>Перевод | תרגום</th>
						<th>Слово | מילה</th>
						<th>Мн.ч. | רבים</th>
					</tr>
				</thead>
				<tbody>
				<?php
					$sql = 'select a.*, (@r := @r+1) seq from ( select w.id id, word, comment, translation, gender, plural, plural_translation, part_of_speech from word w left join topic t on t.id = w.topic_id where ("'.$partofspeech.'" = "" or part_of_speech = "'.$partofspeech.'") and ("'.$topic.'" = "" or t.slug = "'.$topic.'") order by w.id, word, translation ) as a join (select @r:=0) as y';
					if($list = $conn->query($sql)) {
						while($row = $list->fetch_assoc()) {
							echo '<tr><td>'.$row['seq'].'</td><td>'.$row['translation'].'</td>';
							echo '<td class="hebrew link" oid="'.$row['id'].'">'.$row['word'].(isset($row['comment']) ? ' '.$row['comment'] : '');
							if($row['part_of_speech']=='noun' && $row['gender'] != '') {
								echo ' ('.($row['gender'] == 'm' ? 'м.р.' : ($row['gender'] == 'f' ? 'ж.р.' : '')).')';
							}
							echo '</td>';
							echo '<td>'.$row['plural'].'</td></tr>';
						}
					}
				?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    </div>
  </div>
</div>