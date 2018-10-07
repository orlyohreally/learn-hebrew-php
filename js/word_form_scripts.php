<script>
	function pofspeech_changed() {
		if($("#partofspeech_input").val() != 'noun' && $("#partofspeech_input").val() != 'numeric') {
			$("#gender_input").parent().hide()
			$("#gender_input").val('m');
		}
		else {
			$("#gender_input").parent().show();
		}
	}
	pofspeech_changed();
	$("#partofspeech_input").on('change', function(){
		pofspeech_changed();
	});
	$("#word_form").on('submit', function(e){
		e.preventDefault();
		$.ajax({
				method: 'POST',
				data: 'word='+$("#word_input").val()+'&partofspeech='+$("#partofspeech_input").val()+'&comment='+$("#comment_textarea").val()+'&translation='+$("#translation_input").val()+'&gender='+$("#gender_input").val() + '&plural=' + $("#plural_input").val() + '&pl_translation=' + $("#pl_translation_input").val() + '&exception_id=' + $("#exception_id_input").val()<?php if(isset($_GET['id'])) echo "+'&id='+".$_GET['id'];?>,
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