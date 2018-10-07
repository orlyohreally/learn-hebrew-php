<?php
	require 'includes/connect.php';
	include 'menu.php';
	$rule_article = [];
	if($list = $conn->query('select * from rule_article where slug = "'.$rule_slug.'"')) {
		if($row = $list->fetch_assoc()) {
			$rule_article = $row;
		}
	}
?>

<div class="container mt-5 mb-5">
	<h1 id="title_header"><?php echo (isset($rule_article['id']) ? $rule_article['title'] : '<input id="article_title" type="text" placeholder = "Название" />'); ?></h1>
	<?php
	if(isset($rule_article['id'])) {
		echo '<div id = "article_content">'.$rule_article['content'].'</div>';
		echo '<div id = "article_description" style="display: none;">'.$rule_article['description'].'</div>';
	}
	else {
		echo '<div id = "article_content"><textarea id = "content" class = "markItUp" ></textarea></div>';
		echo '<div id = "article_description"><textarea id = "description" class="col-12" rows="5" placeholder="Краткое описание" ></textarea></div>';
	}	
	?>
	<div class="row">
		<div class="col-12">
			<div class="alert alert-dismissible fade show" role="alert"></div>
		</div>
		<div class="col-12 col-md-6 offset-md-3 mb-2">
		<?php
			if($user_role == 'admin' && !isset($rule_article['id']))
				echo '<button class="btn btn-lg btn-info btn-block" id="create_rule_article" type="button">Добавить</button>';
			else if($user_role == 'admin'){
				echo '<button class="btn btn-lg btn-info btn-block" id="edit_rule_article" type="button">Редактировать</button>';
				echo '<button style="display: none;" class="btn btn-lg btn-info btn-block" id="update_rule_article" type="button">Обновить</button>';
			}
		?>
		</div>
	</div>
</div>
