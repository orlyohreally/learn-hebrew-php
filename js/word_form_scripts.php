<script>
	$("#word_form").on('submit', function(e){console.log('word='+$("#word_input").val()+'&translation='+$("#translation_input").val()+'&gender='+$("#gender_input").val() + '&plural=' + $("#plural_input").val() + '&pl_translation=' + $("#pl_translation_input").val() + '&password='+$("#password_input").val()<?php if(isset($_GET['id'])) echo "+'&id='+".$_GET['id'];?>);
		e.preventDefault();
		console.log('word='+$("#word_input").val()+'&translation='+$("#translation_input").val()+'&gender='+$("#gender_input").val() + '&plural=' + $("#plural_input").val() + '&pl_translation=' + $("#pl_translation_input").val() + '&exception_id=' + $("#exception_id_input").val()<?php if(isset($_GET['id'])) echo "+'&id='+".$_GET['id'];?>);
		$.ajax({
				method: 'POST',
				data: 'word='+$("#word_input").val()+'&translation='+$("#translation_input").val()+'&gender='+$("#gender_input").val() + '&plural=' + $("#plural_input").val() + '&pl_translation=' + $("#pl_translation_input").val() + '&exception_id=' + $("#exception_id_input").val()<?php if(isset($_GET['id'])) echo "+'&id='+".$_GET['id'];?>,
				dataType: 'json',
				url: 'ajax/edit_word.php',
				success: function(data) {
					console.log('success', data, $(".alert"));
					if(data.status == 'success') {
						utils.showNotif($(".alert"), data.msg, 'success', 500);
					}
					else {
						utils.showNotif($(".alert"), data.msg, 'danger', 500);
					}

				},
				error: function(data) {
					console.log('error', data);
				}
			});
	});
</script>