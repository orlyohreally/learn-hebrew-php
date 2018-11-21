<?php
	require 'includes/connect.php';
	include 'menu.php';
?>
<div class="container mt-5 mb-5">
	<h1>Формы глаголов | בניינים</h1>
	<div class="row">
		<div class="col-12">
			<a class="btn btn-primary" href="/download/verbs.php" role="button">Скачать</a>
		</div>
		<div class="col-12 mt-4 mb-2">
				<?php
					if($list = $conn->query('select GROUP_CONCAT(p.name SEPARATOR ", ") prepositions, f.id form_id, v.past_ms, f.name v_group, v.id, infinitive, ms, fs, mp, fp, translation, form from verb v left join verb_preposition vp on v.id= vp.verb_id left join preposition p on p.id = vp.preposition_id, verb_form f where f.id = v.form_id group by f.id, v.past_ms, f.name, v.id, infinitive, ms, fs, mp, fp, translation, form order by form_id, ms, translation')) {
						$form_id = 0;
						while($row = $list->fetch_assoc()) {
							if ($form_id != $row['form_id']) {
								if($form_id > 0)
									echo '</tbody></table>';
								?>
								<h2><?php echo $row['v_group']; ?></h2>
								<table id="list-<?php echo $row['form_id'];?>" class="table table-striped table-bordered display nowrap" style="width:100%">
									<thead>
										<tr>
											<th>Перевод | תרגום</th>
											<th>Прош. вр | עבר</th>
											<th>Наст. вр. | הווה</th>
											<th>Инфинитив | שם הפועל</th>
										</tr>
									</thead>
									<tbody>
									
								<?php
									echo '<tr><td>'.$row['translation'].'</td>';
									echo '<td class="hebrew">'.$row['past_ms'].'</td>';
									echo '<td class="hebrew">'.$row['ms']. ' | '.$row['fs'].'</td>';
									echo '<td class="hebrew">'.$row['infinitive'].' '.$row['prepositions'].'</td></tr>';
									
									
							}
							else {
								echo '<tr><td>'.$row['translation'].'</td>';
									echo '<td class="hebrew">'.$row['past_ms'].'</td>';
									echo '<td class="hebrew">'.$row['ms']. ' | '.$row['fs'].'</td>';
									echo '<td class="hebrew">'.$row['infinitive'].' '.$row['prepositions'].'</td></tr>';
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