<script>
	$("#part_of_speech_select, #topic_select").change(function() {
		const topic = $("#topic_select").val();
		const part_of_speech = $("#part_of_speech_select").val();
		console.log(topic, part_of_speech);
		$.ajax({
			method: 'GET',
			data: 'topic=' + topic + '&part_of_speech=' + part_of_speech,
			dataType: 'text',
			url: '',
			success: function(data) {
				$('#list_wrapper').parent().html($(data).find('#list').parent().html());
				$('table').DataTable({
					"language": {
						"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Russian.json"
					},
					"scrollX": true,
					"pageLength": 50
				} );
				$("td[oid], #create_word").on('click', function(){
					edit_word($(this));
				});
			},
			error: function(data) {
				console.log('error', data);
			}
		})
	});
	function edit_word(el) {
			const data = $(el).attr('oid') != undefined ? 'id=' + $(el).attr('oid') : '';
		$.ajax({
			method: 'GET',
			data: data,
			dataType: 'text',
			url: 'ajax/word_form.php',
			success: function(data) {
				$(".modal-content").html(data);
				$(".modal").modal('show');

			},
			error: function(data) {
				console.log('error', data);
			}
		});
	}
	$("td[oid], #create_word").on('click', function(){
		edit_word($(this));
	});
</script>