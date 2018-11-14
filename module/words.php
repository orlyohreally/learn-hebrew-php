<?php
	require 'includes/connect.php';
	include 'menu.php';
?>
<div class="container mt-5 mb-5">
	<h1>Слова | מילים</h1>
	<div class="row">
		<?php
			if($user_role == 'admin') {?>
				<div class="col-12 text-right">
					<button type="button" id="create_word" class="btn btn-primary">Добавить новое слово<hr>הוסף מילה חדשה</button>
				</div>
			<?php }
		?>

		<div class="col-12 mt-4 mb-2">
			<table id="list" class="table table-striped table-bordered display nowrap" style="width:100%">
				<thead>
					<tr>
						<th>Перевод | תרגום</th>
						<th>Слово | מילה</th>
						<th>Мн.ч. | רבים</th>
					</tr>
				</thead>
				<tbody>
				<?php
					if($list = $conn->query('select id, word, comment, translation, gender, plural, plural_translation, part_of_speech from word order by word, translation')) {
						while($row = $list->fetch_assoc()) {
							echo '<tr><td>'.$row['translation'].'</td>';
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