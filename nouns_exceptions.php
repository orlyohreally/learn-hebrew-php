<?php
	require 'includes/connect.php';
	include 'menu.php';
?>
<div class="container mt-5 mb-5">
	<h1>Список исключений</h1>
	<div class="row">
		<div class="col-12 mt-4 mb-2">
				<?php
					if($list = $conn->query('select w.id, word, plural, translation, name, exception_id from word w, pl_exception e where e.id = w.exception_id order by exception_id, word, translation')) {
						$exception_id = 0;
						while($row = $list->fetch_assoc()) {
							if ($exception_id != $row['exception_id']) {
								if ($exception_id > 0)
									echo '</tbody></table>';
								?>										
								
								<h2><?php echo $row['name']; ?></h2>
								<table id="list-<?php echo $row['exception_id'];?>" class="table table-striped table-bordered display nowrap" style="width:100%">
									<thead>
										<tr>
											<th>Ед.ч.</th>
											<th>Мн.ч.</th>
											<th>Значение</th>
										</tr>
									</thead>
									<tbody>
									
								<?php
									echo '<tr><td><a href="word_form.php?id='.$row['id'].'">'.$row['word'].'</a></td>';
									echo '<td class="hebrew">'.$row['plural'].'</td>';
									echo '<td class="hebrew">'.$row['translation'].'</td></tr>';
							}
							else {
								echo '<tr><td><a href="word_form.php?id='.$row['id'].'">'.$row['word'].'</a></td>';
								echo '<td class="hebrew">'.$row['plural'].'</td>';
								echo '<td class="hebrew">'.$row['translation'].'</td></tr>';
							}
							$exception_id = $row['exception_id'];
						}
					}
				?>
			</tbody></table>
		</div>
	</div>
</div>