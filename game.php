<?php
//ログインチェック
//require_once("../config_shuyaku/config_li.php");
//f_checking();

session_start();

//label設定
if (isset($_GET['label'])) {
	$_SESSION['label'] = $_GET['label'];
}
if ( ! isset($_SESSION['label'])) {
	header('Location:/index.php');
}

//ニックネーム設定
if (isset($_GET['nick'])) {
	$_SESSION['nickname'] = $_GET['nick'];
}
if ( ! isset($_SESSION['nickname'])) {
	header('Location:/index.php');
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
  <title>Document</title>
  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/font-awesome.css">
	<link rel="stylesheet" href="./css/component.css">
  <link rel="stylesheet" href="./css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js" type="text/javascript"></script>
	<script src="./js/lib/jquery.randomize.js" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore.js"></script>
  <script src="https://cdn.jsdelivr.net/vue/0.12.16/vue.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/2.2.2/isotope.pkgd.min.js"></script>
	<script src="./js/index.js"></script>
</head>
<body>
    <div id="demo" class="container">
      <div class="row">
        <div class="col-xs-12">
          <div class="header">
            英単語
            <p class="catch text-center">
              絵と単語をそろえよう！{{time}}秒
            </p>
          </div>
        </div>
        <div class="col-xs-12 items">
          <template v-repeat="items">
            <div class="unit in" data-index="{{$index}}">
							<img src="img/{{question}}">
							<hr>
							<div class="ja">{{{answer2}}}</div>
							<div class="right">正解</div>
						</div>
            <div class="unit in" data-index="{{$index}}">
							<div class="en">{{answer1}}</div>
							<div class="right">正解</div>
						</div>
          </template>
        </div>
      </div>


			<div class="md-modal md-effect-4" id="modal-success">
				<div class="md-content">
					<h3>やったね！クリア！</h3>
					<div class="row">
						<div class="result col-xs-12">
							<div class="text text-center">
								今回の記録：<span>{{score}}</span>点
							</div>
							<div class="text text-center">
								ランキング：<span>{{rank}}位</span>
							</div>
						</div>
						<div class="text-center">
							<a class="btn btn-lg btn-success" href="">もう一度チャレンジ</a>
							<a class="btn btn-lg btn-default" href="">ランキングを見る</a>
						</div>
					</div>
				</div>
			</div>
    </div>

</body>
</html>
