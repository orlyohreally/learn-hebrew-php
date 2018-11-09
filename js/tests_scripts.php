<script>
	function checkSV(test) {console.log($("#sentence").val());
		$.ajax({
				method: 'POST',
				data: 'test='+test +'&answer=' + $("#sentence").val() +'&sentence_template='+$(".sentence-template").html(),
				dataType: 'json',
				url: 'ajax/check_test.php',
				success: function(data) {console.log(data);
					utils.deloader($("#answer"));
					console.log('success', data);
					if(data.result == 'correct') {
						utils.showNotif($("#answer-area .alert"), 'Верно!', 'success');					}
					else {
						utils.showNotif($("#answer-area .alert"), 'Не верно!', 'danger', 750);
					}

					setTimeout(function(){
						start_training();
					}, 800);
				},
				error: function(data) {
					console.log('error', data);
					utils.deloader($("#answer"));
					utils.showNotif($("#answer-area .alert"), 'Ошибка!', 'danger');
				}
			});
	}
	
	function show_test(test, sentence_template) {
		$("#training .sentence-template").html(sentence_template);
		$("#answer").off('click');
		 $("#answer").click(function(){
		 	utils.loader($("#answer"));
		 	checkSV(test);
		 });
		$("#typed_in_answer").focus();
	}
	function start_training() {
		$("#sentence").val('');
		const test = "<?php echo $_GET['test']?>";
		utils.loader($(".sentence-template"));
		$.ajax({
			method: 'GET',
			data: 'test='+test,
			dataType: 'json',
			url: 'ajax/get_test.php',
			success: function(data) {
				console.log('success', data);
				if(data.status == 'success') {
					show_test(test, data.template);
				}
				else {
					utils.showNotif($("#answer-area .alert"), data.msg, 'danger');
				}
			},
			error: function(data) {
				console.log('error', data);
				utils.deloader($("#answer"));
				utils.showNotif($("#answer-area .alert"), 'Ошибка!', 'danger');
			}
		});
	}
	$(document).ready(function(){
		start_training();
	});
	
	$("#finish").click(function(){
		window.location.href = '/';
	});
</script>