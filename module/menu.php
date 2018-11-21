<nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse">
	<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<a class="navbar-brand hebrew text-white" href="/">אני לומד עברית</a>
	<div class="collapse navbar-collapse " id="navbarCollapse">
		<ul class="navbar-nav ml-auto">
			<li class="nav-item"><a class = "nav-link text-center" href="/words">Список слов<hr>רשימת מילים</a></li>
			<li class="nav-item"><a class = "nav-link text-center" href="/verbs">Список глаголов <hr> רשימת פעלים</a></li>
			<li class="nav-item dropdown">
		        <a class="nav-link dropdown-toggle text-center" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Тесты<hr>מבחנים</a>
		        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
		          <a class="dropdown-item text-center" href="/tests?test=sv">сущ + гл<hr>שם + פועל</a>
		    </li>
			<li class="nav-item"><a class = "nav-link text-center" href="/my-lists">Мои списки слов<hr>רשימות המילים שלי
</a></li>
			<?php
				if(!isset($_SESSION['user_id'])) {//неавторизован
					echo '<li class="nav-item"><a class = "nav-link text-center" href="/login">Войти<hr>התחברות</a></li>';
				}
				else {//авторизован
					echo '<li class="nav-item"><a class = "nav-link text-center" href="/logout">Выйти<hr>להתנתק</a></li>';
				}
			?>
		</ul>
	</div>
</nav>