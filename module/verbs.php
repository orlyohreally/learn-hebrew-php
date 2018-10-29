<?php
	require 'includes/connect.php';
	include 'menu.php';
?>
<div class="container mt-5 mb-5">
	<h1>Формы глаголов</h1>
	<div class="row">
		<div class="col-12 mt-4 mb-2">
				<?php
					if($list = $conn->query('select f.id form_id, v.id, infinitive, ms, fs, mp, fp, translation, form from verb v, verb_form f where f.id = v.form_id order by form_id, ms, translation')) {
						$form_id = 0;
						while($row = $list->fetch_assoc()) {
							if ($form_id != $row['form_id']) {
								if($form_id > 0)
									echo '</tbody></table>';
								?>
								<h2><?php echo $row['form']; ?></h2>
								<table id="list-<?php echo $row['form_id'];?>" class="table table-striped table-bordered display nowrap" style="width:100%">
									<thead>
										<tr>
											<th>Значение</th>
											<th>Инфинитив</th>
											<th>Ед.ч. м.р.</th>
											<th>Ед.ч. ж.р.</th>
											<th>Мн.ч. м.р.</th>
											<th>Мн ч. ж.р.</th>
										</tr>
									</thead>
									<tbody>
									
								<?php
									echo '<tr><td>'.$row['translation'].'</td>';
									echo '<td class="hebrew">'.$row['infinitive'].'</td>';
									echo '<td class="hebrew">'.$row['ms'].'</td>';
									echo '<td class="hebrew">'.$row['fs'].'</td>';
									echo '<td class="hebrew">'.$row['mp'].'</td>';
									echo '<td class="hebrew">'.$row['fp'].'</td></tr>';
									
							}
							else {
								echo '<tr><td>'.$row['translation'].'</td>';
								echo '<td class="hebrew">'.$row['infinitive'].'</td>';
								echo '<td class="hebrew">'.$row['ms'].'</td>';
								echo '<td class="hebrew">'.$row['fs'].'</td>';
								echo '<td class="hebrew">'.$row['mp'].'</td>';
								echo '<td class="hebrew">'.$row['fp'].'</td></tr>';
							}
							$form_id = $row['form_id'];
						}
					}
				?>
				</tbody>
			</table>
		</div>
	</div>
</div>