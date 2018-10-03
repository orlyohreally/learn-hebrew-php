<script>
	function get_words(lang) {
		$.ajax({
			method: 'POST',
			data: 'type='+lang,
			dataType: 'json',
			url: 'ajax/get_words.php',
			success: function(data) {
				console.log('success', data);
				startTraining(lang, data.words);
			},
			error: function(data) {
				console.log('error', data);
			}
		});
	};
	function get_word(lang) {
		$.ajax({
			method: 'POST',
			data: 'type='+lang+'&count=1',
			dataType: 'json',
			url: 'ajax/get_words.php',
			success: function(data) {
				console.log('success', data);
				startTaskType(lang, data.words[0]);
			},
			error: function(data) {
				console.log('error', data);
			}
		});
	};
	function checkSelectedAnswer(lang) {
		const selected = $("#training .list-group-item.selected").html();
		$.ajax({
			method: 'POST',
			data: 'type='+lang+'&word='+$("#training .word").html() +'&answer='+selected,
			dataType: 'json',
			url: 'ajax/check.php',
			success: function(data) {
				console.log('success', data);
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
					get_words(lang);
				}, 500);
			},
			error: function(data) {
				console.log('error', data);
			}
		});
	}
	function checkTypeInAnswer(lang) {
		$.ajax({
				method: 'POST',
				data: 'type='+lang+'&word='+$("#training .word").html() +'&answer='+$("#typed_in_answer").val(),
				dataType: 'json',
				url: 'ajax/check.php',
				success: function(data) {
					console.log('success', data);
					if(data.result == 'correct') {
						utils.showNotif($("#answer-area .alert"), 'Верно! Ответ - ' + data.correct, 'success');
					}
					else {
						utils.showNotif($("#answer-area .alert"), 'Не верно! Ответ - ' + data.correct, 'danger', 750);
					}
					setTimeout(function(){
						get_word(lang);
					}, 800);
				},
				error: function(data) {
					console.log('error', data);
				}
			});
	}
	function startTraining(lang, list) {
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
			checkSelectedAnswer(lang);
		});
		
	}
	function startTaskType(lang, word) {
		$("#page_content").hide();
		$("#training").show();
		$("#training .training-container .task").html('<div class="input-group mb-3"><input class="form-control" id="typed_in_answer" type="text" /></div>');
		$("#training .word").html(word);
		$("#answer").off('click');
		$("#answer").click(function(){
			checkTypeInAnswer(lang);
		});
		$("#typed_in_answer").focus();
		$("#typed_in_answer").keyup(function(e){
			if(e.keyCode == 13)
				checkTypeInAnswer(lang);
		});
	}
	$("#mchoice_ru-he, #mchoice_he-ru").click(function(){
		get_words($(this).attr('id').split('mchoice_')[1]);
	});
	$("#typein_ru-he, #typein_he-ru").click(function(){
		get_word($(this).attr('id').split('typein_')[1]);
	});
	$("#finish").click(function(){
		$("#page_content").show();
		$("#training").hide();
		$("#training .list-group").html('');
	});
</script>