<script>
	function checkSelectedAnswer(lang, task) {
		const selected = $("#training .list-group-item.selected").html();
		$.ajax({
			method: 'POST',
			data: 'task='+task+'&lang='+lang+'&word='+$("#training .word").html() +'&answer='+selected + '&code="<?php echo $_GET['code']?>"',
			dataType: 'json',
			url: 'ajax/check.php',
			success: function(data) {
				//console.log('success', data);
				utils.deloader($("#answer"));
				if(data.result == 'correct') {
					utils.showNotif($("#answer-area .alert"), 'Верно!', 'success');
				}
				else {
					
					utils.showNotif($("#answer-area .alert"), 'Не верно!', 'danger');
				}
				$("#training .list-group-item").each(function(i, el){
					if($(el).html() == data.correct)
						$(el).removeClass('list-group-item-info').addClass('list-group-item-success');
				});
				setTimeout(function(){
					start_training();
				}, 500);
			},
			error: function(data) {
				console.log('error', data);
				utils.deloader($("#answer"));
				utils.showNotif($("#answer-area .alert"), 'Ошибка!', 'danger');
			}
		});
	}
	function checkTypeInAnswer(lang, task) {
		$.ajax({
				method: 'POST',
				data: 'task='+task+'&lang='+lang+'&word='+$("#training .word").html() +'&answer='+$("#typed_in_answer").val() + '&code="<?php echo $_GET['code']?>"',
				dataType: 'json',
				url: 'ajax/check.php',
				success: function(data) {
					utils.deloader($("#answer"));
					console.log('success', data);
					if(data.result == 'correct') {
						utils.showNotif($("#answer-area .alert"), 'Верно! Ответ - ' + data.correct, 'success');
					}
					else {
						utils.showNotif($("#answer-area .alert"), 'Не верно! Ответ - ' + data.correct, 'danger', 750);
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
	
	function multichoice(task, lang, list) {
		$("#page_content").hide();
		$("#training").show();
		$("#training .training-container .task").html('<div class="list-group"></div>');
		
		for(var i = 0; i < list.length - 1; i++) {
			$("#training .list-group").append('<button type="button" class="list-group-item list-group-item-action">' + list[i] + '</button>');
		}
		$(".training-container .word").html(list[list.length - 1]);
		
		$("#training .list-group-item").click(function(){
			$("#training .list-group-item").removeClass('selected list-group-item-info');
			$(this).addClass('selected list-group-item-info');
		});
		$("#answer").off('click');
		$("#answer").click(function(){
			utils.loader($("#answer"));
			checkSelectedAnswer(lang, task);
		});
	
	}
	function spelling(task, lang, word) {
		$("#page_content").hide();
		$("#training").show();
		$("#training .training-container .task").html('<div class="input-group mb-3"><input class="form-control" id="typed_in_answer" type="text" /></div>');
		$("#training .word").html(word);
		$("#answer").off('click');
		$("#answer").click(function(){
			utils.loader($("#answer"));
			checkTypeInAnswer(lang, task);
		});
		$("#typed_in_answer").focus();
		$("#typed_in_answer").keyup(function(e){
			if(e.keyCode == 13) {
				utils.loader($("#answer"));
				checkTypeInAnswer(lang, task);
			}
		});
	}
	function start_training() {
		const task = "<?php echo $_GET['task']?>";
		const lang = "<?php echo $_GET['lang']?>";
		const code = "<?php echo $_GET['code']?>";
		utils.loader($(".word"));
		$.ajax({
			method: 'GET',
			data: 'task='+task + '&lang=' + lang + '&code=' + code,
			dataType: 'json',
			url: 'ajax/get_words.php',
			success: function(data) {
				console.log('success', data);
				if(data.words.length) {
					if(task == 'multichoice')
						multichoice(task, lang, data.words);
					else
						spelling(task, lang, data.words[0])
				}
				else {
					var results_html = '<div class="card"><ul class="list-group list-group-flush">';
					for(var i = 0; i < data.results.length; i++) {
						results_html += '<li class="list-group-item"><div class="col-12"><div class="row"><div class="col-8"><strong>' + data.results[i]['word'] + ' - ' + data.results[i]['answer'] + '</strong></div><div class="col-4 text-right"><i class="fas ' + (data.results[i]['answered'] > 0 ? 'fa-check' : 'fa-times') + '"></i><span> ' + data.results[i]['tries'] + ' попыток</span></div></div></div></li>';
					}
					results_html += '</ul></div>';
					const dialog = bootbox.dialog({
						title: "Тренировка закончена",
						message: results_html,
						backdrop: true,
						buttons: {
							ok: {
								label: 'Ок',
								className: 'btn-primary',
								callback: function() {
									window.location.href = "/my-lists";
									return true;
								}
							}
						},
						closeButton: false
					});
					$().on('hide.bs.modal', function(){
						
					});
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
		window.location.href = '/my-lists/';
	});
</script>