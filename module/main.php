<?php
	require 'includes/connect.php';
	include 'menu.php'; ?>
<div id="page_content">
	<!--<div id="slider" class="carousel slide" data-ride="carousel">
		<ol class="carousel-indicators">
			<li data-target="#slider" data-slide-to="1" class="active"></li>
			<li data-target="#slider" data-slide-to="2"></li>
			<li data-target="#slider" data-slide-to="3"></li>
			<li data-target="#slider" data-slide-to="4"></li>
		</ol>
		<div class="carousel-inner" role="listbox">
			<div class="carousel-item active" style = "height: 400px;">
			
				<div class = "slider-img" style = "background: black url('img/slide-1.jpg') center top no-repeat; background-size: cover; width: 100%;"></div>
				<div class="carousel-caption d-md-block">
					<h3>Тренировать перевод с русского на иврит (с выбором ответа)</h3>
					<button type="button" class="btn btn-lg btn-primary" id="mchoice_ru-he">Начать</button>
				</div>
			</div>
			
			<div class="carousel-item" style = "height: 400px;">
			
				<div class = "slider-img"style = "background: black url('img/slide-2.jpg') center top no-repeat; background-size: cover; width: 100%;"></div>
				<div class="carousel-caption d-md-block">
					<h3>Тренировать перевод с иврита на русский (с выбором ответа)</h3>
					<button type="button" class="btn btn-lg btn-primary" id="mchoice_he-ru">Начать</button>
				</div>
			</div>
			<div class="carousel-item" style = "height: 400px;">
				<div class = "slider-img"style = "background: black url('img/slide-3.jpg') center top no-repeat; background-size: cover; width: 100%;"></div>
				<div class="carousel-caption d-md-block">
					<h3>Тренировать перевод с русского на иврит (ввод ответа)</h3>
					<button type="button" class="btn btn-lg btn-primary" id="typein_ru-he">Начать</button>
				</div>
			</div>
			<div class="carousel-item" style = "height: 400px;">
				<div class = "slider-img"style = "background: black url('img/slide-4.jpg') center top no-repeat; background-size: cover; width: 100%;"></div>
				<div class="carousel-caption d-md-block">
					<h3>Тренировать перевод с иврита на русский (ввод ответа)</h3>
					<button type="button" class="btn btn-lg btn-primary" id="typein_he-ru">Начать</button>
				</div>
			</div>
			
		</div>
		<a class="carousel-control carousel-control-prev" href="#slider" role="button" data-slide="prev">
			<img src = "img/arrow2.png" style = "transform: rotate(180deg);"/>
			<span class="sr-only">Previous</span>
		</a>
		<a class="carousel-control carousel-control-next" href="#slider" role="button" data-slide="next">
			<img src = "img/arrow2.png"/>
			<span class="sr-only">Next</span>
		</a>
	</div>-->
	<div class="container mb-5 mt-5" id="lists">
			<div class="row">
				<div class="col-12">
					<h1 class="text-center">Списки слов</h1>
				</div>
			</div>
			<div class="row">
		
			<?php
					if($list = $conn->query('select title, subtitle, description, url from page order by title, subtitle')) {
						$form_id = 0;
						while($row = $list->fetch_assoc()) {
							?>
							<div class="col-12 col-sm-6 mt-4 mb-2">
								<div class="card text-center">
									<h5 class="card-header p-3"><?php echo $row['title']; ?></h5>
									<div class="card-body p-2">
										<?php 
											if(isset($row['subtitle']))
												echo '<h5 class="card-title p-3">'.$row['subtitle'].'</h5>';
										?>
										<?php 
											if(isset($row['description']))
												echo '<p class="card-text p-3">'. $row['description'].'</p>';
										?>
										<a href="<?php echo $row['url']; ?>" class="btn btn-primary">Смотреть</a>
									</div>
								</div>
							</div>
							<?php
						}
					}
				?>
			</div>
		</div>
	</div>
</div>
