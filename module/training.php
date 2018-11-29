<?php
	require 'includes/connect.php';
	include 'menu.php'; ?>
<div class="container">
	<div class="row <?php if($_GET['task'] != 'prepositions') echo 'm-5'; ?>" id = "training">
		<div class="training-container text-center col-12">
			<?php
				if($_GET['task'] != 'prepositions')
					echo '<h5 class="word p-2"></h5>';
				else
					echo '<div class="board mt-5">
							<div class="board-column prepositions">
								<div class="board-column-header">Предлоги</div>
								<div class="board-column-content"></div>
							</div>
							<div class="board-column verbs">
								<div class="board-column-header">Глаголы</div>
								<div class="board-column-content"></div>
							</div>
						</div>';
			?>
			<div class="task"></div>
				<div class="progress m-2">
			 		<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
				</div>
			<div id="answer-area">
				<div class="alert alert-dismissible fade show" role="alert"></div>
				<button type="button" class="btn btn-lg btn-primary mb-2" id="answer">Ответить</button>
				<button type="button" class="btn btn-lg btn-danger mb-2" id="finish">Закончить</button>
			</div>
		</div>
	</div>	
</div>

<style type="text/css">
	/* Board */

.board {
  position: relative;
  margin-left: 1%;
}
.board-column {
  display: inline-block;
  width: 44%;
  margin: 0 1%;
  background: #f0f0f0;
  border-radius: 3px;
  z-index: 1;
}
.board-column.muuri-item-releasing {
  z-index: 2;
}
.board-column.muuri-item-dragging {
  z-index: 3;
  cursor: move;
}
.board-column-header {
  position: relative;
  height: 50px;
  line-height: 50px;
  overflow: hidden;
  padding: 0 20px;
  text-align: center;
  background: #333;
  color: #fff;
  border-radius: 3px 3px 0 0;
}
@media (max-width: 600px) {
  .board-column-header {
    text-indent: -1000px;
  }
}
.board-column.verbs .board-column-header {
  background: #4A9FF9;
}
.board-column.prepositions .board-column-header {
  background: #f9944a;
}
.board-column-content {
  position: relative;
  border: 10px solid transparent;
  min-height: 95px;
}
.board-item {
  position: absolute;
  width: 100%;
  margin: 5px 0;
}
.board-item.muuri-item-releasing {
  z-index: 9998;
}
.board-item.muuri-item-dragging {
  z-index: 9999;
  cursor: move;
}
.board-item.muuri-item-hidden {
  z-index: 0;
}
.board-item-content {
  position: relative;
  padding: 20px;
  background: #fff;
  border-radius: 4px;
  font-size: 17px;
  cursor: pointer;
  -webkit-box-shadow: 0px 1px 3px 0 rgba(0,0,0,0.2);
  box-shadow: 0px 1px 3px 0 rgba(0,0,0,0.2);
}
.verbs .board-item-content {
	cursor: default!important;
}
@media (max-width: 600px) {
  .board-item-content {
    text-align: center;
  }
  .board-item-content span {
    display: none;
  }
}
</style>