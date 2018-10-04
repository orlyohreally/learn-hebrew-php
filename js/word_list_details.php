<script>
	function reset_list(list, list_id) {
		$.ajax({
				method: 'POST',
				data: 'list_id=' + list_id,
				dataType: 'json',
				url: '/ajax/empty_word_list.php',
				success: function(data) {
					console.log('success', data);
					if(data.status == 'success') {
						add_words(list, <?php echo $list_id?>);
					}
					else {
						utils.showNotif($(".alert"), data.msg, 'danger', 600);
					}
				},
				error: function(data) {
					console.log('error', data);
				}
			});
	}
	function add_words(list, list_id) {
		$.ajax({
				method: 'POST',
				data: 'words=' + JSON.stringify(list) + '&list_id=' + list_id,
				dataType: 'json',
				url: '/ajax/add_word_to_list.php',
				success: function(data) {
					console.log('success', data);
					if(data.status == 'success') {
						utils.showNotif($(".alert"), 'Список успешно был обновлен', 'success', 600);
					}
					else {
						utils.showNotif($(".alert"), data.msg, 'danger', 600);
					}
				},
				error: function(data) {
					console.log('error', data);
				}
			});
	}
	
	$("#update_list").on('click', function(){
		var list = [];
		$("td input[oid]").each(function(i, el) {
			if($(el).prop('checked'))
				list.push($(el).attr('oid'));
		});
		reset_list(list, <?php echo $list_id?>);
	});
	$("input.select-all").on('change', function() {
		console.log('click', $(this).prop('checked'));
		if($(this).prop('checked')) {
			$("td input[oid]").prop('checked', true);
		}
		else {
			$("td input[oid]").prop('checked', false);
		}
	});
	
	function update_list(old_name, name) {console.log(old_name, name);
		$.ajax({
				method: 'POST',
				data: 'old_name=' + old_name + '&name=' + name,
				dataType: 'json',
				url: '/ajax/update_word_list.php',
				success: function(data) {
					console.log('success', data);
					if(data.status == 'success') {
						window.location.href = '/my-list/' + data.name
					}
					else {
						utils.showNotif($(".update-name.alert"), data.msg, 'danger', 600);
					}
				},
				error: function(data) {
					console.log('error', data);
					utils.showNotif($(".update-name.alert"), 'Ошибка!', 'danger', 600);
				}
			});
	}
	
	$(".list-name").on('click', function(){
		const old_name = $(this).html();
		console.log(old_name);
		const dialog = bootbox.dialog({
			title: "Обновить название списка слов",
			message: '<div class="form-group"><label for="name_input">Новое название списка</label><input type="text" required value = "'+ old_name + '" class="form-control" id="name_input" aria-describedby="Название списка" placeholder="Название списка"></div><div class="update-name alert alert-dismissible fade show" role="alert"></div>',
			backdrop: true,
			buttons: {
				ok: {
					label: 'Обновить',
					className: 'btn-info',
					callback: function() {
						if($("#name_input").val() != '')
							update_list(old_name, $("#name_input").val());
						return false;
					}
				}
			}
		});
	});
	
</script>