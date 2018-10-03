<nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse">
	<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<a class="navbar-brand hebrew text-white" href="/">אני לומד עברית</a>
	<div class="collapse navbar-collapse " id="navbarCollapse">
		<ul class="navbar-nav ml-auto">
			<li class="nav-item"><a class = "nav-link" href="words">Список слов</a></li>
			<?php
				if(!isset($_SESSION['user_id'])) {//неавторизован
					echo '<li class="nav-item"><a class = "nav-link" href="login">Войти</a></li>';
					
				}
				else {//авторизован
					//echo '<li class="nav-item"><a class = "nav-link" href="#">Мои тесты</a></li>';
					echo '<li class="nav-item"><a class = "nav-link" href="logout">Выйти</a></li>';
					
				}
			?>
		</ul>
	</div>
</nav>