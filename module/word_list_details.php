<?php
	require 'includes/connect.php';
	include 'menu.php';
	$words = [];
	if($list = $conn->query('select w.id, w.word, part_of_speech, w.translation, case wl.webuser_list_id when '.$list_id.' then "checked" else null end "check"
							from word w left join word_list wl on wl.word_id = w.id and (wl.webuser_list_id is null or wl.webuser_list_id = '.$list_id.') order by w.word, w.translation')) {
		while($row = $list->fetch_assoc()) {
			$words[] = $row;
		}
	}
?>
<div class="container mt-5 mb-5">
	<h1 class="list-name"><?php echo $list_name?></h1>
	<?php if(!isset($_SESSION['user_id'])) { ?>
	<div class="row">
		<div class="col-12 text-center m-2">
			<p>Авторизуйтесь, чтобы сохранять свои списки слов для тренировки.</p>
		</div>
	</div>
	<?php }?>
	<div class="row mt-3 text-center">
			<button type="button" onclick="check(this, 'noun', true);" class="btn btn-primary mb-2 ml-2user mr-2"><span style="color:#ffffff;" class="fas fa-check"></span> сущ.</button>
			<button type="button" onclick="check(this, 'verb', true);" class="btn btn-primary mb-2 mr-2"><span style="color:#ffffff;" class="fas fa-check"></span> глаголы</button>
			<button type="button" onclick="check(this, 'adj', true);" class="btn btn-primary mb-2 mr-2"><span style="color:#ffffff;" class="fas fa-check"></span> прилаг.</button>
			<button type="button" onclick="check(this, 'number', true);" class="btn btn-primary mb-2 mr-2"><span style="color:#ffffff;" class="fas fa-check"></span> числительные</button>
		
	</div>
	<div class="row">
		<div class="col-12 mt-4 mb-2 scrollable-table">
			<table id="list" class="table table-striped table-bordered display nowrap" style="width:100%">
				<thead>
					<tr>
						<th style="width:20px;"><input type="checkbox" class="select-all"/></th>
						<th>Слово</th>
						<th>Перевод</th>
					</tr>
				</thead>
				<tbody>
				<?php
					foreach($words as $item=>$value) {
						echo '<tr><td style="width:20px;"><input oid="'.$value['id'].'" part_of_speech="'.$value['part_of_speech'].'" type="checkbox" '.$value['check'].' /></td>';
						echo '<td>'.$value['word'].'</td>';
						echo '<td>'.$value['translation'].'</td></tr>';
					}
				?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-12 text-center">
			<div class="alert alert-dismissible fade show" role="alert"></div>
			<?php if(isset($_SESSION['user_id'])) echo '<button type="button" id="update_list" class="btn btn-primary mb-2">Обновить список</button>';?>
			<button type="button" id="start_training" class="btn btn-primary mb-2">Начать тренировку</button>
		</div>
	</div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    </div>
  </div>
</div>