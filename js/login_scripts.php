<script>
	function login(login, password) {
		console.log(login, password);
		$.ajax({
			method: 'POST',
			data: 'login=' + login + '&password=' + password,
			dataType: 'json',
			url: 'ajax/login.php',
			success: function(data) {
				console.log('success', data);
				if(data.status == 'success') {
					window.location.href = '/';
				}
				else
					utils.showNotif($("#login-container .alert"), data.msg, 'danger', 0);
		
			},
			error: function(data) {
				console.log('error', data);
			}
		});
	};
	function signup(login, password) {
		console.log(login, password);
		$.ajax({
			method: 'POST',
			data: 'login=' + login + '&password=' + password,
			dataType: 'json',
			url: 'ajax/signup.php',
			success: function(data) {
				console.log('success', data);
				if(data.status == 'success') {
					window.location.href = '/';
				}
				else
					utils.showNotif($("#signup-container .alert"), data.msg, 'danger', 0);
		
			},
			error: function(data) {
				console.log('error', data);
			}
		});
	};
	$("#login-form").on('submit', function(e){
		e.preventDefault();
		console.log('logging in');
		login($("#login-form #inputUsernameLogin").val(), $("#login-form #inputPasswordLogin").val());
	});
	$("#signup-form").on('submit', function(e){
		e.preventDefault();
		console.log('signing up', $("#signup-form #inputPasswordSignup").val(), $("#signup-form #inputPassword2Signup").val());
		if($("#signup-form #inputPasswordSignup").val() != $("#signup-form #inputPassword2Signup").val()) {
			utils.showNotif($("#signup-container .alert"), 'Пароль не совпадает', 'danger', 8000);
		}
		else
			signup($("#signup-form #inputUsernameSignup").val(), $("#signup-form #inputPasswordSignup").val());
	});
	$("#show_reg").click(function(){
		$("#login-container").hide();
		$("#signup-container").show();
	});
	$("#show_log").click(function(){
		$("#login-container").show();
		$("#signup-container").hide();
	});
</script>