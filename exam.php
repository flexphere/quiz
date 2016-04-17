<?php
require_once('include/define.php');
require_once('include/common.php');
require_once('include/db.php');

//ログインチェック
//require_once("../config_shuyaku/config_li.php");
//f_checking();
$student_id = _c('mem_id');

$state = get_state($student_id);
$active_label = get_active_lesson($state);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/font-awesome.css">
  <link rel="stylesheet" href="./css/notosansjapanese.css">
  <link rel="stylesheet" href="./css/component.css">
  <link rel="stylesheet" href="./css/style.css">
</head>
<body style="display:block;">
  <header class="bg-white">
  	<div class="container-fluid bg-white">
  	  <div class="row">
  	    <div class="col-xs-12 col-sm-8 col-sm-offset-2">
  	      <div class="header col-xs-12 col-sm-6 pad_box">
  	        <h2 class="content_heading"><?php echo $active_label ?></h2>
  	      </div>
  	      <div class="col-xs-12 col-sm-6 pad_box">
  	        <p class="progress-text"><span class="current">{{index}}</span>/<span class="total">10</span></p>
  					<div class="progress">
  					  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: {{progress}}%;">
  					  </div>
  					</div>
  	      </div>
  	    </div>
  	    <!-- /.col-xs-12 col-md-10 col-md-offset-1 -->
  	  </div>
  	  <!-- /.row -->
  	</div>
  	<!-- /.container -->
  </header>
  <main>
  	<div class="container-fluid">
  	  <div class="row">
  			<div class="col-xs-12 col-sm-8 col-sm-offset-2" style="float:left;">
  				<div class="col-xs-12 question_area">
  	        <h3 class="question_heading">Question {{index}}</h3>
  					<p class="question_text">{{question}}</p>
  					<div class="question_option">{{option_1}}</div>
  					<div class="question_option">{{option_2}}</div>
          </div>
  			</div>
  		</div>
  	  <!-- /.row -->
  	</div>
  	<!-- /.container -->
  </main>

<div class="md-modal md-effect-1" id="modal-success">
	<div class="md-content">
		<h3>Congratulation!</h3>
		<div>

		</div>
	</div>
</div>

<div class="md-modal md-effect-11" id="modal-fail">
	<div class="md-content">
		<h3>Keep it up!</h3>
		<div class="animocon_box">
      <span class="animocon">
        <i class="fa fa-trophy fa-5x"></i>
      </span>
		</div>
    <div class="text-center">
      <a href="./index.php">一覧へ</a>
    </div>
	</div>
</div>
<div class="md-overlay"></div>

<script src="js/lib/underscore.min.js"></script>
<script src="js/lib/jquery.min.js"></script>
<script src="js/lib/vue.min.js"></script>
<script src="js/lib/mo.min.js"></script>
<script src="js/exam.js"></script>
</body>
</html>
