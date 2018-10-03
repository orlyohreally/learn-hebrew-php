<?php
	require 'includes/connect.php';
	include 'menu.php';
?>
<div class="container mt-5 mb-5">
	<h1>Слова</h1>
	<div class="row">
		<div class="col-12 mt-4 mb-2">
			<table id="list" class="table table-striped table-bordered display nowrap" style="width:100%">
				<thead>
					<tr>
						<th>Перевод</th>
						<th>Слово</th>
						<th>Мн.ч.</th>
					</tr>
				</thead>
				<tbody>
				<?php
					if($list = $conn->query('select id, word, translation, gender, plural, plural_translation from word order by word, translation')) {
						while($row = $list->fetch_assoc()) {
							echo '<tr><td>'.$row['translation'].'</td>';
							echo '<td class="hebrew"><a href="word-form?id='.$row['id'].'">'.$row['word'];
							if($row['gender'] != '') {
								echo ' ('.($row['gender'] == 'm' ? 'м.р.' : ($row['gender'] == 'f' ? 'ж.р.' : '')).')';
							}
							echo '</a></td>';
							echo '<td>'.$row['plural'].'</td></tr>';
						}
					}
				?>
				</tbody>
			</table>
		</div>
	</div>
</div>