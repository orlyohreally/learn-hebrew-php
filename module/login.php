<?php
	require 'includes/connect.php';
	include 'menu.php';
?>
<div id="login-container" class="container">
	<div class="form-row col-10 offset-1 offset-md-1">
		<form id="login-form" class="mt-5 mb-5">

		  <!--<img class="mb-4" src="img/logo.png" alt="" width="72" height="72">-->
			<div class="form-group">
				<label for="inputUsernameLogin">Логин | שם משתמש</label>
				<input type="text" id="inputUsernameLogin" class="form-control" placeholder="Логин" required autofocus>
			</div>
			<div class="form-group">
				<label for="inputPasswordLogin">Пароль | סיסמה</label>
				<input type="password" id="inputPasswordLogin" class="form-control" placeholder="Пароль" required>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="alert alert-dismissible fade show" role="alert"></div>
				</div>
				<div class="col-12 col-md-6 mb-2">
				  <button class="btn btn-lg btn-info btn-block" id="show_reg" type="button">Создать профиль<hr>הירשם</button>
				</div>
				<div class="col-12 col-md-6 mb-2">
				  <button class="btn btn-lg btn-primary btn-block" type="submit">Войти<hr>התחברות</button>
				</div>
			</div>

		</form>
	</div>
</div>
<div id="signup-container" class="container">
	<div class="form-row col-10 offset-1">
		<form id="signup-form" class="mt-5 mb-5">
		  <!--<img class="mb-4" src="img/logo.png" alt="" width="72" height="72">-->
			<div class="form-group">
			  <label for="inputUsernameSignup">Логин | שם משתמש</label>
			  <input type="text" id="inputUsernameSignup" class="form-control" placeholder="Логин" required autofocus>
			</div>
			<div class="form-group">
			  <label for="inputPasswordSignup">Пароль | סיסמה</label>
			  <input type="password" id="inputPasswordSignup" class="form-control" placeholder="Пароль" required>
			</div>
			<div class="form-group">
			  <label for="inputPassword2Signup">Пароль еще раз | סיסמא בשנית</label>
			  <input type="password" id="inputPassword2Signup" class="form-control" placeholder="Пароль" required>
			</div>
		  	<div class="text-center">
		  		<p class="mb-1">Не используйте пароли, которые Вы везде используете.<hr>אל תשתמש בסיסמה שבה אתה משתמש תמיד</p>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="alert alert-dismissible fade show" role="alert"></div>
				</div>
				
				<div class="col-12 col-md-6 mb-2">
				  <button class="btn btn-lg btn-info btn-block" id="show_log" type="button">Войти<hr>התחברות</button>
				</div>
				<div class="col-12 col-md-6 mb-2">
				  <button class="btn btn-lg btn-primary btn-block" type="submit">Создать профиль<hr>הירשם</button>
				</div>
				
			</div>
		</form>
	</div>
</div>