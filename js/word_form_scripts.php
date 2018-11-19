<script>
	function pofspeech_changed() {
		if($("#partofspeech_input").val() != 'noun' && $("#partofspeech_input").val() != 'number' && $("#partofspeech_input").val() != 'verb') {
			$("#infinitive_input, #gender_input, #plural_input, #exception_id_input, #pl_translation_input, #past_ms_input, #ms_input, #fs_input, #mp_input, #fp_input, #form_id_input").parent().hide()
			$("#gender_input").val('m');
			$("#plural_input").val('');
			$("#exception_id_input").val('');
			$("#pl_translation_input").val('');
			$("#word_input").attr('required', '').parent().show();
		}
		else if($("#partofspeech_input").val() == 'number') {
			$("#word_input, #gender_input").parent().show();
			$("#infinitive_input, #exception_id_input, #plural_input, #pl_translation_input, #past_ms_input, #ms_input, #fs_input, #mp_input, #fp_input").parent().hide()
			$("#exception_id_input, #pl_translation_input, #plural_input, #ms_input, #fs_input, #mp_input, #fp_input, #form_id_input").val('');
			$("#word_input").attr('required', '');
		}
		else if($("#partofspeech_input").val() == 'verb') {
			$("#word_input, #exception_id_input, #plural_input, #pl_translation_input, #gender_input").parent().hide()
			$("#infinitive_input, #past_ms_input, #ms_input, #fs_input, #mp_input, #fp_input, #form_id_input").parent().show();
			$("#exception_id_input, #plural_input, #pl_translation_input, #gender_input").val('');
			$("#word_input").removeAttr('required');
		}
		else { //noun
			$("#word_input, #gender_input, #plural_input, #exception_id_input, #pl_translation_input").parent().show();
			$("#infinitive_input, #past_ms_input, #ms_input, #fs_input, #mp_input, #fp_input, #form_id_input").val('').parent().hide();
			$("#word_input").attr('required', '');
		}
	}
	pofspeech_changed();
	$("#partofspeech_input").on('change', function(){
		pofspeech_changed();
	});
	$("#word_form").on('submit', function(e){
		e.preventDefault();
		utils.loader($('button[type="submit"]'));
		$.ajax({
				method: 'POST',
				data: 'word='+$("#word_input").val()+'&partofspeech='+$("#partofspeech_input").val()+'&comment='+$("#comment_textarea").val()+'&translation='+$("#translation_input").val()+'&gender='+$("#gender_input").val() + '&plural=' + $("#plural_input").val() + '&pl_translation=' + $("#pl_translation_input").val() + '&exception_id=' + $("#exception_id_input").val() + '&ms=' + $("#ms_input").val() + '&fs=' + $("#fs_input").val() + '&mp=' + $("#mp_input").val() + '&fp=' + $("#fp_input").val()+ '&past_ms=' + $("#past_ms_input").val()  + '&form_id=' + $("#form_id_input").val() + '&topic_id=' + $("#topic_id_input").val() + '&add_new_topic=' + $("#add_new_topic_input").prop('checked') + '&new_topic=' + $("#new_topic_input").val() + '&new_topic_slug=' + $("#new_topic_slug_input").val() + '&infinitive=' + $("#infinitive_input").val()<?php if(isset($_GET['id'])) echo "+'&id='+".$_GET['id'];?>,
				dataType: 'json',
				url: 'ajax/edit_word.php',
				success: function(data) {
					console.log('success', data);
					if(data.status == 'success') {
						utils.showNotif($(".alert"), data.msg, 'success', 0);
						$(".modal").modal('hide');
					}
					else {
						utils.showNotif($(".alert"), data.msg, 'danger', 5000);
					}
					utils.deloader($('button[type="submit"]'));
				},
				error: function(data) {
					console.log('error', data);
				}
			});
		
	});
	$("#add_new_topic_input").change(function(){
		if($(this).prop('checked')) {//new topic
			$("#new_topic_input").parent().parent().show();
			$("#topic_id_input").val('');
			$("#new_topic_input").attr('required', true);
		}
		else {
			$("#new_topic_input").parent().parent().hide();
			$("#new_topic_input").removeAttr('required');

		}
	});
	$("#topic_id_input").change(function() {
		if($(this).val() != "") {//hide new topic input if selected topic
			$("#new_topic_input").removeAttr('required');
			$("#new_topic_input").parent().parent().hide();
			$("#add_new_topic_input").prop('checked', false);
		}
	})
</script>