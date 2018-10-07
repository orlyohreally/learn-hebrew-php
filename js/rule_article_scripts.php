<script>
	<?php if($user_role == 'admin') {
		if(!isset($rule_article['id']))
			echo '$("textarea.markItUp").markItUp(mySettings);';
	?>
	$("#create_rule_article, #update_rule_article").click(function(){
		$.ajax({
			method: 'POST',
			data: 'title=' + $("#article_title").val() + '&content=' + $("#content").val() + '&description=' + $("#description").val()<?if(isset($rule_article['id'])) echo '+"&id='.$rule_article['id'].'"';?>,
			dataType: 'json',
			url: '/ajax/rule_article.php',
			success: function(data) {
				console.log('success', data);
				if(data.status == 'success') {console.log(data.title);
					utils.showNotif($(".alert"), data.msg, 'success', 600);
					window.location.href = "/rule/" + data.slug;
				}
				else {
					utils.showNotif($(".alert"), data.msg, 'danger', 600);
				}
			},
			error: function(data) {
				console.log('error', data, $(".alert"));
				utils.showNotif($(".alert"), 'Ошибка!', 'danger', 600);
			}
		});
	});
	$("#edit_rule_article").click(function() {
		$("#title_header").html('<input id="article_title" type="text" placeholder = "Название" value="' + $("#title_header").html() + '" />');
		$("#article_content").html('<textarea id = "content" class = "markItUp" >' + $("#article_content").html() + '</textarea>');
		$("#article_description").html('<textarea id = "description" class="col-12" rows="5"  placeholder="Краткое описание" >' + $("#article_description").html() + '</textarea>').show();
		$("textarea.markItUp").markItUp(mySettings);
		$("#edit_rule_article").hide();
		$("#update_rule_article").show();
	});
	<?php }	?>
</script>