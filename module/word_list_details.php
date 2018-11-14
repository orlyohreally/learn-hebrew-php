<?php
	require 'includes/connect.php';
	include 'menu.php';
	$words = [];
	if($list = $conn->query('select w.id, w.word, part_of_speech, w.translation, t.slug topic, case wl.webuser_list_id when '.$list_id.' then "checked" else null end "check"
							from word w left join topic t on w.topic_id = t.id left join word_list wl on wl.word_id = w.id and (wl.webuser_list_id is null or wl.webuser_list_id = '.$list_id.') order by w.id desc')) {
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
	<div class="col-12">
		<div class="row mt-3">
				<button type="button" onclick="check(this, 'part_of_speech', 'noun', true);" class="btn btn-primary m-1"><span style="color:#ffffff;" class="fas fa-check"></span> сущ.</button>
				<button type="button" onclick="check(this, 'part_of_speech', 'verb', true);" class="btn btn-primary m-1"><span style="color:#ffffff;" class="fas fa-check"></span> глаголы</button>
				<button type="button" onclick="check(this, 'part_of_speech', 'adj', true);" class="btn btn-primary m-1"><span style="color:#ffffff;" class="fas fa-check"></span> прилаг.</button>
				<button type="button" onclick="check(this, 'part_of_speech', 'number', true);" class="btn btn-primary m-1"><span style="color:#ffffff;" class="fas fa-check"></span> числительные</button>
			<?php
				if($list = $conn->query('select name, slug from topic order by name, slug')) {
					while($row = $list->fetch_assoc()) {
						?>
						<button type="button" onclick="check(this, 'topic', '<?php echo $row['slug']; ?>', true);" class="btn btn-primary m-1"><span style="color:#ffffff;" class="fas fa-check"></span> <?php echo $row['name']; ?> </button>
						<?php
					}
				}
			?>
		</div>
	</div>
	<div class="row mt-4 mb-2">
		<div class="col-12 mb-2 selected-counter"></div>
		<div class="col-12 scrollable-table">
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
						echo '<tr><td style="width:20px;"><input oid="'.$value['id'].(isset($value['topic']) ? '" topic="'.$value['topic'] : '').'" part_of_speech="'.$value['part_of_speech'].'" type="checkbox" '.$value['check'].' /></td>';
						echo '<td>'.$value['word'].'</td>';
						echo '<td>'.$value['translation'].'</td></tr>';
					}
				?>
				</tbody>
			</table>
		</div>
		<div class="col-12 mt-2 selected-counter"></div>
	</div>
	<div class="row">
		<div class="col-12 text-center">
			<div class="alert alert-dismissible fade show" role="alert"></div>
			<?php if(isset($_SESSION['user_id'])) echo '<button type="button" id="update_list" class="btn btn-primary mb-2">Обновить список</button>';?>
			<button type="button" id="start_training" class="btn btn-primary mb-2">Начать тренировку</button>
		</div>
	</div>
	<div class="scroller"><span class="fa fa-arrow-up scroller-up"></span>
	<span class="fa fa-arrow-down scroller-down"></span></div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    </div>
  </div>
</div>
<style>
	td {
		cursor: pointer;
	}
</style>