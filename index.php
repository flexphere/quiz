<?php
require_once('include/define.php');
require_once('include/common.php');
require_once('include/db.php');

//ログインチェック
//require_once("../config_shuyaku/config_li.php");
//f_checking();
$student_id = _c('mem_id');

//現在のステータスを取得
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
  <link rel="stylesheet" href="./css/style.css">
  <script src="js/lib/jquery.min.js"></script>
  <script src="js/index.js"></script>
</head>
<body>
<header class="bg-white">
	<div class="container-fluid bg-white">
	  <div class="row">
	    <div class="col-xs-12 col-sm-8 col-sm-offset-2">
	      <div class="border-r1 col-xs-12 col-sm-6">
	        <h2 class="content_heading">English Fill-in Test</h2>
	        <p class="content_lead">
	          ダミーテキストダミーテキストダミーテキスト
	        </p>
	      </div>
	      <div class="col-xs-12 col-sm-5 col-sm-offset-1 lesson_header">
					<h3><?php echo $active_label ?></h3>
					<button data-link="exam.php" class="btn btn-success btn-lg">START</button>
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
	    <div class="col-xs-12 col-sm-8 col-sm-offset-2 text-center">
	      <hr>
	      <i class="fa fa-pencil fa-lg"></i>
	      <h3 class="text-center">Lessons</h3>
	      <hr>
	    </div>
	    <!-- /.col-xs-12 col-sm-10 col-sm-offset-1 -->

	    <div class="col-xs-12 col-sm-8 col-sm-offset-2">
	      <ul class="lesson_list">
        <?php foreach($state->lessons as $lesson): ?>
					<li class="lesson_<?php echo $lesson->status ?>" <?php if ($lesson->status == 'active') echo 'data-link="exam.php"' ?>>
					  <div class="lesson_status">
					    <span class="fa-stack fa-lg">
					      <i class="fa fa-circle fa-stack-2x bg"></i>
								<i class="fa fa-<?php echo $lesson->icon ?> fa-stack-1x icon"></i>
					    </span>
					  </div>
					  <div class="lesson_title">
					    <h4><?php echo $lesson->label ?></h4>
					  </div>
					  <div class="lesson_archive">
					    <i class="fa fa-trophy fa-2x fa-<?php echo $lesson->trophy ?>"></i>
					  </div>
					</li>
				<?php endforeach; ?>
	      </ul>
	      <!-- /.col-xs-12 bg-white -->
	    </div>
	    <!-- /.col-xs-12 col-sm-10 col-sm-offset-1 -->
	  </div>
	  <!-- /.row -->
	</div>
	<!-- /.container -->
</main>

<?php if (empty($state->nickname)) : ?>
<div class="modal-nick">
	<div class="modal fade in modal-nick" role="dialog" data-backdrop="static" data-show="true">
	  <div class="modal-dialog modal-sm">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h4 class="modal-title">ニックネーム設定</h4>
	      </div>
	      <div class="modal-body text-center">
					<div class="input-group">
					  <span class="input-group-addon"><i class="fa fa-user"></i></span>
					  <input id="nick" class="form-control" type="text">
					</div>
					<button data-nick id="nick-submit" type="button" class="btn btn-success">決定</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<div class="modal-backdrop fade in"></div>
</div>
<?php endif; ?>
</body>
</html>
