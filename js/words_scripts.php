<script>
	$("td[oid], #create_word").on('click', function(){
		const data = $(this).attr('oid') != undefined ? 'id=' + $(this).attr('oid') : '';
		console.log( $(this), data);
		
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
	});
</script>