<script>
	function create_list(name) {console.log(name);
		$.ajax({
				method: 'POST',
				data: 'name=' + name,
				dataType: 'json',
				url: 'ajax/create_word_list.php',
				success: function(data) {
					console.log('success', data);
					if(data.status == 'success') {
						console.log('yey');
						window.location.href = '/my-list/' + data.name
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
	
	$("#create_list").on('click', function(){
		const dialog = bootbox.dialog({
			title: "Создание списка слов",
			message: '<div class="form-group"><label for="name_input">Название списка</label><input type="text" required value = "" class="form-control" id="name_input" aria-describedby="Название списка" placeholder="Название списка"></div><div class="alert alert-dismissible fade show" role="alert"></div>',
			backdrop: true,
			buttons: {
				ok: {
					label: 'Создать',
					className: 'btn-info',
					callback: function() {						
						if($("#name_input").val() != '' && /^[a-zA-Z0-9-]+$/i.test($("#name_input").val()))
							create_list($("#name_input").val());
						else if($("#name_input").val() == '') {
							utils.showNotif($(".alert"), 'Укажите название списка', 'danger', 1500);
						}
						else if(!/^[a-zA-Z0-9-]+$/i.test($("#name_input").val())) {
							utils.showNotif($(".alert"), 'Название может состоять только из латинских букв и цифр', 'danger', 1500);
						}
						return false;
					}
				}
			}
		});
	});
	
</script>